<?php
/**
 * File containing the oauthadmin/action view definition
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package kernel
 */

// ezcDb init. @todo: should be refactored, but later
$dbMapping = array( 'ezmysqli' => 'mysql',
                    'ezmysql' => 'mysql',
                    'mysql' => 'mysql',
                    'mysqli' => 'mysql',
                    'postgresql' => 'pgsql',
                    'ezpostgresql' => 'pgsql',
                    'ezoracle' => 'oracle',
                    'oracle' => 'oracle' );

$ini = eZINI::instance();
list( $dbType, $dbHost, $dbPort, $dbUser, $dbPass, $dbName ) =
    $ini->variableMulti( 'DatabaseSettings',
        array( 'DatabaseImplementation', 'Server', 'Port', 'User', 'Password', 'Database' ) );
if ( !isset( $dbMapping[$dbType] ) )
{
    eZDebug::writeError( "Unknown / unmapped DB type '$dbType'" );
    return eZError::KERNEL_NOT_AVAILABLE;
}
else
{
    $dbType = $dbMapping[$dbType];
}
$dsnHost = $dbHost . ( $dbPort != '' ? ":$dbPort" : '' );
$dsnAuth = $dbUser . ( $dbPass != '' ? ":$dbPass" : '' );
$dsn = "{$dbType}://{$dbUser}:{$dbPass}@{$dsnHost}/{$dbName}";

$ezcDb = ezcDbFactory::create( $dsn );
$session = new ezcPersistentSession(
    $ezcDb,
    new ezcPersistentCacheManager( new ezcPersistentCodeManager( "extension/oauthadmin/classes/persistentobjects/" ) )
);
ezcPersistentSessionInstance::set( $session ); // set default session
// end ezcDb init.

$module = $Params['Module'];

// new application: create draft, redirect to edit this draft
if ( $module->isCurrentAction( 'NewApplication' ) )
{
    $user = eZUser::currentUser();
    $application = new ezpRestClient();
    $application->name = ezpI18n::tr( 'extension/oauthadmin', 'New REST application' );
    $application->version = ezpRestClient::STATUS_DRAFT;
    $application->owner = $user->attribute( 'contentobject_id' );
    $application->created = time();
    $application->updated = 0;

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