<?php
/**
 * File containing the oauthadmin/edit view definition
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package kernel
 */

include 'extension/oauthadmin/modules/oauthadmin/tmppo.php';

$module = $Params['Module'];

// @todo Instanciate the session maybe ?
$applicationId = $Params['ApplicationID'];
$application = $session->load( 'ezpRestClient', $applicationId );

$tpl = eZTemplate::factory();
$tpl->setVariable( 'module', $module );
$tpl->setVariable( 'application', $application );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'extension/oauthadmin', 'oAuthAdmin' ) ),
                         array( 'url' => false,
                                'text' => ezpI18n::tr( 'extension/oauthadmin', 'REST application: %application_name%', null,
                                    array( '%application_name%' => $application->name ) ) ),
);

$Result['content'] = $tpl->fetch( 'design:oauthadmin/view.tpl' );
return $Result;
?>