<?php
/**
 * Crude bin test script
 * Simulates GET /api/content/object/1 and outputs the ezcMvcResult
 */
$request = new ezcMvcRequest();
$request->date = new DateTime;
$request->uri = '/api/content/object/1/field/name';
$request->protocol = 'http';
$request->host = 'api.example.no';

$request->variables['objectId'] = 1;

$controller = new ezpRestContentController( 'viewObject', $request );
$result = $controller->doViewObject();
print_r( $result );
?>
