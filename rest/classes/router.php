<?php
/**
 * File containing rest router
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 *
 */
class ezpRestRouter extends ezcMvcRouter
{
    public function createRoutes()
    {
        return array(
            new ezcMvcRailsRoute( '/api/content/', 'ezpRestContentController', 'list' ),
            new ezcMvcRailsRoute( '/api/content/:contentId/fields/', 'ezpRestContentController', 'fields' ),
            new ezcMvcRailsRoute( '/api/fatal', 'ezpRestContentController', 'show' ),
        );
    }
}
?>