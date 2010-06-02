<?php
/**
 * Crude bin test script
 * Simulates GET /api/content/node/2 and outputs the ezcMvcResult
 */
$controller = new ezpRestContentController( 'viewField', new ezcMvcRequest );
$result = $controller->doViewField( 1, 'name' );
print_r( $result );
?>