<?php

  define("GLOBAL_PATH", "global/");
  define("MODEL_PATH", "model/");
  define("HELPER_PATH", "helper/");
  define("CONTROLLER_PATH", "controller/");
  define("LIB_PATH", "lib/");
  define("VIEW_PATH", "view/");
  define("ASSET_PATH", "/".ROOT_PATH."asset/");
  define("IMG_PATH", ASSET_PATH."img/");
  define("LAYOUT_PATH", VIEW_PATH."layout/");
  define("EMAIL_PATH", VIEW_PATH."email/");
  define("FORM_PATH", "form/");

  define("weapon", 3);
  define("suspect", 1);
  define("room", 2);

  define("owned", 3);
  define("very_likely", 2);
  define("likely", 1);
  define("not_owned", 0);

  define("MAX_AMOUNT", 1000000000);
  define("MAX_TEXT_LENGTH", 65000);
  define("MAX_NAME_LENGTH", 127);
  define("MAX_TERM", 2100);

  define("total_card_number", 21);
  define("dead_card_number", 3);
  define("dealed_card_number", total_card_number - dead_card_number);
