<?php
$controller = new ezpRestContentController( 'viewObject', new ezcMvcRequest );
$result = $controller->doViewNode( 1 );
print_r( $result );
?>
