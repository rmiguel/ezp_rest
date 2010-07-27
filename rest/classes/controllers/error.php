<?php
/**
 * File containing the ezpRestErrorController class
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 *
 */

/**
* This controller deals with error situations arising in the REST layer.
*/
class ezpRestErrorController extends ezcMvcController
{
    /**
     * Default method, currently used for fatal error handling
     * @return ezcMvcResult
     */
    public function doShow()
    {
        if ( ($this->exception instanceof ezcMvcRouteNotFoundException) || ($this->exception instanceof ezpContentNotFoundException ) )
        {
            // we want to return a 404 to the user
            $result = new ezcMvcResult;
            $result->status = new ezpRestNotFound;
            return $result;
        }

        $result = new ezcMvcResult;
        $result->variables['message'] = $this->exception->getMessage();
        return $result;
    }
}
?>