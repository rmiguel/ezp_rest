<?php
/**
 * File containing ezpRestAuthConfiguration
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 *
 */

/**
* Class controlling which routes require authentication.
* 
* This class sets up the defaults for which routes require auth and which
* can be omitted. This class acts as a compatibility bridge between the REST-
* layer and the traditional eZ Publish permission configuration.
*/
class ezpRestAuthConfiguration
{

    function __construct( ezcMvcRoutingInformation $info, ezcMvcRequest $req )
    {

    }
}

?>