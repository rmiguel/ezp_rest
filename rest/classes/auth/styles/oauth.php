<?php
/**
 * File containing ezpRestOauthAuthenticationStyle
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 *
 */

class ezpRestOauthAuthenticationStyle implements ezpRestAuthenticationStyle
{
    public function setup( ezcMvcRequest $request )
    {
        // Setup for testing credentials
        // Check for required components (fail if not present)
        // Fail if too many components are required (according to spec, later)
        // Validate components

        // Fetch and validate token for validity and optionally scope.
        // Either let teh request pass, or immediately bail with 401.
        // Section 5.2.1 for error handling.
        //
        // invalid_request missing required params -> 400
        //
        // invalid_token Expired token which cannot be refreshed -> 401
        //
        // expired_token Token has expired -> 401
        //
        // insufficient_scope The requested scope is outside scope associated with token -> 403
        //
        // Do not include error info for requests which did not contain auth details.ref. 5.2.1
        $logger = ezcLog::getInstance();
        $logger->source = __FUNCTION__;
        $logger->category = "oauth";

        $logger->log( "Begin oauth verification", ezcLog::DEBUG );

        $token = ezpOauthUtility::getToken( $request );
    }

    public function authenticate( ezcMvcRequest $request )
    {
        // Checking for existance of token
        // $session = ezcPersistentSessionInstance::get();
        // $fetchedToken = $session->load( 'ezpRestToken', $token );
        // $logger->log( $fetchedToken->client_id, ezcLog::DEBUG );

        // We need to catch exceptions here, as exceptions thrown in the RequestFilter
        // is not caught by MvcTools, so the error controller will not pick them up.
        try
        {
            // Not valid token
            $request->uri = '/login/oauth';
            return new ezcMvcInternalRedirect( $request );

        }
        catch ( Exception $e )
        {
            $request->variables['exception'] = $e;
            $request->uri = '/api/fatal';
            return new ezcMvcInternalRedirect( $request );
        }
    }
}
?>