<?php
/*  I highly encourage you to put your config file outside of the repo in a static place.
    Using a JSON file makes the configuration easily portable. */
if (!defined("CONFIG_FILE_PATH"))
    define("CONFIG_FILE_PATH", "/srv/config/isp-monitor/config.json");
return \IspMonitor\Utilities\Environment::getConfig();