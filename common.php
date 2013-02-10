<?php

require "config.php";

include DIR_CLASSES . "/Browser.php";

$oBr = new Browser;

$bI = ( isset( $_GET['d'] ) ) ? false : ( $oBr->getPlatform() == "iPhone" );