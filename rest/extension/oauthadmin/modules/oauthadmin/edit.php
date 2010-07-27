<?php
/**
 * File containing the oauthadmin/edit view definition
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package kernel
 */

$tpl = eZTemplate::factory();
$module = $Params['Module'];

$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'i18n/context', 'Text' ) ) );

$Result['content'] = $tpl->fetch( 'design:oauthadmin/edit.tpl' );
return $Result;
?>