<?php
require 'rest_config.php';

$mvcConfig = new ezpMvcConfiguration();

$frontController = new ezcMvcConfigurableDispatcher( $mvcConfig );
$frontController->run();
?>
