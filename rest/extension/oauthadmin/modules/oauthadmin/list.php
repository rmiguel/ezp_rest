<?php
/**
 * File containing the oauthadmin/list view definition
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package kernel
 */

require_once( 'kernel/common/template.php' );
$tpl = templateInit();
$module = $Params['Module'];

$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'i18n/context', 'Text' ) ) );
$Result['content'] = $tpl->fetch( 'design:' );
return $Result;
?>