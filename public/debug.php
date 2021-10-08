<?php
$colorLoaded = '#4eab32';
$colorNotLoaded = '#ab3285';

echo (extension_loaded('Zend OPcache'))
    ? "<h3 class='center' style='color:{$colorLoaded};'>OPCache is loaded!</h3>"
    : "<h3 class='center' style='color:{$colorNotLoaded};'>OPCache is not loaded!</h3>";

echo (extension_loaded('apcu'))
    ? "<h3 class='center' style='color:{$colorLoaded};'>APCU is loaded!</h3>"
    : "<h3 class='center' style='color:{$colorNotLoaded};'>APCU is not loaded!</h3>";

echo (extension_loaded('xdebug'))
    ? "<h3 class='center' style='color:{$colorLoaded};'>XDebug is loaded!</h3>"
    : "<h3 class='center' style='color:{$colorNotLoaded};'>XDebug is not loaded!</h3>";

echo phpinfo();
