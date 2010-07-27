<?php
/**
 * File containing the oauthadmin/list view definition
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package kernel
 */

$tpl = eZTemplate::factory();
$module = $Params['Module'];

$tpl->setVariable( 'applications', array() );

$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'i18n/context', 'oAuthAdmin' ) ),
                         array( 'url' => false,
                                'text' => ezpI18n::tr( 'i18n/context', 'Registered applications' ) ) );

$Result['content'] = $tpl->fetch( 'design:oauthadmin/list.tpl' );

return $Result;
?>