<?php
/**
 * File containing the oauthadmin/action view definition
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package kernel
 */

include 'extension/oauthadmin/modules/oauthadmin/tmppo.php';

$module = $Params['Module'];

// new application: create draft, redirect to edit this draft
if ( $module->isCurrentAction( 'NewApplication' ) )
{
    $user = eZUser::currentUser();
    $application = new ezpRestClient();
    $application->name = ezpI18n::tr( 'extension/oauthadmin', 'New REST application' );
    $application->version = ezpRestClient::STATUS_DRAFT;
    $application->owner_id = $user->attribute( 'contentobject_id' );
    $application->created = time();
    $application->updated = 0;
    $application->version = ezpRestClient::STATUS_DRAFT;

    $session->save( $application );

    return $module->redirectToView( 'edit', array( $application->id ) );
}

// delete one application (dedicated button from full view)
if ( $module->isCurrentAction( 'DeleteApplication' ) )
{
    if ( $module->hasActionParameter['ConfirmDelete'] )
    {
        // confirmed, remove the application
    }
    else
    {
        // display confirmation request
    }
}

// delete several applications (checkboxes on list view)
if ( $module->isCurrentAction( 'DeleteApplicationList' ) )
{
    if ( $module->hasActionParameter['ConfirmDelete'] )
    {
        // confirmed, remove the application
    }
    else
    {
        // display confirmation request
    }
}

return $Result;
?>