<?php
/*  I highly encourage you to put your config file outside of the repo in a static place.
    Using a JSON file makes the configuration easily portable. */

define("CONFIG_FILE_PATH", "/srv/config/isp-monitor/config.json");
$settings = file_exists(CONFIG_FILE_PATH) ? json_decode(file_get_contents(CONFIG_FILE_PATH), true)
    : json_decode(file_get_contents(__DIR__ . '/config.json'), true);

return $settings;