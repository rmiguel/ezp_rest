<?php
/**
 * Crude bin test script
 * Simulates GET /api/content/node/2 and outputs the ezcMvcResult
 */
$controller = new ezpRestContentController( 'viewFields', new ezcMvcRequest );
$result = $controller->doViewFields( 1 );
print_r( $result );
?>