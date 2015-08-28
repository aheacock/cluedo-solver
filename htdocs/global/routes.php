<?php

  function allowed_clean_string_characters() {
    return "a-z0-9-";
  }

  function clean_string($string) {
    $string = remove_exterior_spaces($string);
    $string = str_replace(
      str_split("àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ", 2),
      str_split("aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY"),
      $string
    );
    $string = strtolower($string);
    $string = preg_replace("/[^".allowed_clean_string_characters()."]/", "-", $string);
    return $string;
  }

  function path($action, $model_name, $model_id = "", $prefix = "", $query_array = array(), $include_csrf = false) {
    $query_string = "";
    $include_start_char = URL_REWRITE;
    if ($include_csrf) {
      $query_array["csrf_token"] = get_csrf_token();
    }
    if (STATE == "development" && isset($GLOBALS["query_array"]["current_date"])) {
      $query_array["current_date"] = $GLOBALS["query_array"]["current_date"];
    }
    foreach ($query_array as $key => $value) {
      if (!is_empty($value)) {
        if ($include_start_char) {
          $query_string .= "?";
          $include_start_char = false;
        } else {
          $query_string .= "&";
        }
        if ($key == "tags") {
          $query_string .= "tags=".tag_array_to_string($value);
        } else {
          $query_string .= $key."=".$value;
        }
      }
    }
    if (!URL_REWRITE) {
      return true_path($action, $model_name, $model_id, $prefix).$query_string;
    }
    return ROOT_PATH.(is_empty($prefix) ? "" : $prefix."/").$model_name.(is_empty($model_id) ? "" : "/".$model_id).(is_empty($action) ? "" : "/".$action).$query_string;
  }

  function full_path($path) {
    if (substr($path, 0, 1) != "/") {
      $path = "/".$path;
    }
    return "http".(is_empty($_SERVER["HTTPS"]) ? "" : "s")."://".$_SERVER["HTTP_HOST"].$path;
  }

  function true_path($action, $model_name, $model_id = "", $prefix = "") {
    if (is_empty($prefix)) {
      $prefix_string = "";
    } else {
      $prefix_elements = explode("/", $prefix);
      $prefix_string = "&prefix=".$prefix_elements[0]."&binet=".$prefix_elements[1]."&term=".$prefix_elements[2];
    }
    $action = is_empty($action) ? "index" : $action;
    return "./".ROOT_PATH."index.php?controller=".$model_name."&action=".$action.(is_empty($model_id) ? "" : "&".$model_name."=".$model_id).$prefix_string."&";
  }

  function write_path_rule($path, $url, $options = "[L,NC,QSA]") {
    if (fwrite($GLOBALS["htaccess"], "RewriteRule ^".$path."/?$ ".$url."%{QUERY_STRING} ".$options."
    ") === FALSE) {
      echo ".htaccess could not be written for urlrewriting.";
    }
  }

  function write_controller_rules($hash) {
    set_if_not_set($hash["except"], array());
    set_if_not_set($hash["binet_prefix"], false);
    set_if_not_set($hash["action_on_collection"], array());
    set_if_not_set($hash["action_on_member"], array());
    set_if_not_set($hash["root"], "index");

    $collection_actions = array_merge(array_diff(array("index", "new", "create"), $hash["except"]), $hash["action_on_collection"]);
    $member_actions = array_merge(array_diff(array("show", "edit", "update", "delete"), $hash["except"]), $hash["action_on_member"]);

    if (!in_array("index", $hash["except"])) {
      write_path_rule(
        path("", $hash["controller"], "", $hash["binet_prefix"] ? "binet/([".allowed_clean_string_characters()."]+)/([0-9]+)" : ""),
        true_path($hash["root"], $hash["controller"], "", $hash["binet_prefix"] ? "binet/$1/$2" : "")
      );
    }
    foreach ($collection_actions as $action) {
      write_path_rule(
        path($action, $hash["controller"], "", $hash["binet_prefix"] ? "binet/([".allowed_clean_string_characters()."]+)/([0-9]+)" : ""),
        true_path($action, $hash["controller"], "", $hash["binet_prefix"] ? "binet/$1/$2" : "")
      );
    }
    foreach ($member_actions as $action) {
      write_path_rule(
        path($action, $hash["controller"], "([0-9]+)", $hash["binet_prefix"] ? "binet/([".allowed_clean_string_characters()."]+)/([0-9]+)" : ""),
        true_path($action, $hash["controller"], "$".($hash["binet_prefix"] ? "3" : "1"), $hash["binet_prefix"] ? "binet/$1/$2" : "")
      );
    }
  }

  function urlrewrite() {
    $htaccess = fopen((ROOT_PATH == "" ? "" : ".")."./.htaccess", "w");
  	if (!$htaccess) {
  		echo ".htaccess could not be opened for urlrewriting.";
  		exit;
  	}
		if (fwrite(
      $htaccess,
      "
      ErrorDocument  404  ".substr(true_path("unknown_url", "error"), 1)."
	    AddDefaultCharset UTF-8
	    RewriteEngine ".(URL_REWRITE ? "on" : "off")."
	    ") === FALSE) {
      echo ".htaccess could not be written for urlrewriting.";
      exit;
    }

    $GLOBALS["htaccess"] = $htaccess;

    write_path_rule(substr(ROOT_PATH, 0, strlen(ROOT_PATH) -1), true_path("index", "game"));
    write_controller_rules(array("controller" => "game", "except" => array("edit", "update", "delete"), "action_on_member" => array("turn", "skip", "daybook", "revert")));

    fclose($htaccess);
  }
