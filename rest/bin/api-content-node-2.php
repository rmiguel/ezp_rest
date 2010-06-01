<?php
$controller = new ezpRestContentController( 'viewNode', new ezcMvcRequest );
$result = $controller->doViewNode( 2 );
print_r( $result );
?>