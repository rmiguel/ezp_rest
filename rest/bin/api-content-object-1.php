<?php
/**
 * Crude bin test script
 * Simulates GET /api/content/object/1 and outputs the ezcMvcResult
 */
$controller = new ezpRestContentController( 'viewObject', new ezcMvcRequest );
$result = $controller->doViewNode( 1 );
print_r( $result );
?>
