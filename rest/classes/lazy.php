<?php
/**
 * File containing a collection lazy initialisation hooks
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 *
 */

class ezpRestLogConfig implements ezcBaseConfigurationInitializer
{
        public static function configureObject( $log )
        {
            // Disable log rotation
            $writeAll = new ezcLogUnixFileWriter( "var/log/", "rest.log", false );
            $log->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writeAll, true ) );
        }
}
ezcBaseInit::setCallback( 'ezcInitLog', 'ezpRestLogConfig' );

class ezpRestDbConfig implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $instance )
    {
        //Ignoring $instance
        return ezcDbFactory::create( 'pgsql://postgres@localhost/trunkgit' );
    }
}
ezcBaseInit::setCallback( 'ezcInitDatabaseInstance', 'ezpRestDbConfig' );

class ezpRestPoConfig implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $instance )
    {
        return new ezcPersistentSession( ezcDbInstance::get(), new ezcPersistentCodeManager( 'rest/rest/classes/po_maps' ) );
    }
}
ezcBaseInit::setCallback( 'ezcInitPersistentSessionInstance', 'ezpRestPoConfig' );

?>
