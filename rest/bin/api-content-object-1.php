<?php
/**
 * Crude bin test script
 * Simulates GET /api/content/object/1 and outputs the ezcMvcResult
 */
$request = new ezcMvcRequest( new DateTime, 'http', 'api.example.no', '/api/content/object/1/field/name' );
$controller = new ezpRestContentController( 'viewObject', $request );
$result = $controller->doViewObject( 1 );
print_r( $result );
?>
