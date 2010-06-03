<?php
/**
 * Crude bin test script
 * Simulates GET /api/content/node/2 and outputs the ezcMvcResult
 */
$request = new ezcMvcRequest( new DateTime, 'http', 'api.example.no', '/api/content/object/1/field/name' );
$controller = new ezpRestContentController( 'viewNode', $request );
$result = $controller->doViewNode( 2 );
print_r( $result );
?>