<?php
/**
 * File containing Mvc configuration
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 */
class ezpMvcConfiguration implements ezcMvcDispatcherConfiguration
{
    public function createFatalRedirectRequest( ezcMvcRequest $request, ezcMvcResult $result, Exception $e )
    {
        $req = clone $request;
        $req->uri = '/api/fatal';
        $req->variables['exception'] = $e;
        return $req;
    }

    public function createRequestParser()
    {
        $parser = new ezcMvcHttpRequestParser();
        return $parser;
    }

    public function createResponseWriter( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response )
    {
        return new ezcMvcHttpResponseWriter( $response );
    }

    public function createRouter( ezcMvcRequest $request )
    {
        return new ezpRestRouter( $request );
    }

    public function createView( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result )
    {
        $view = new ezpRestDemoView( $request, $result );
        return $view;
    }

    public function runPreRoutingFilters( ezcMvcRequest $request )
    {

    }

    public function runRequestFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request )
    {
        // We need to catch exceptions here, as exceptions thrown in the RequestFilter
        // is not caught by MvcTools, so the error controller will not pick them up.
        try
        {
            $authConfig = new ezpRestAuthConfiguration( $routeInfo, $request );
            return $authConfig->filter();
        }
        catch ( Exception $e )
        {
            $request->variables['exception'] = $e;
            $request->uri = '/api/fatal';
            return new ezcMvcInternalRedirect( $request );
        }
    }

    public function runResponseFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response )
    {
        $response->content = new ezcMvcResultContent();
        $response->content->type = "application/json";
        $response->content->charset = "UTF-8";
        $response->generator = "eZ Publish";
    }

    public function runResultFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result )
    {

    }

    public function runAuthFilter( $request )
    {
        // $basicAuth = new ezpRestBasicAuthStyle;
        // Testing basic auth
        $logger = ezcLog::getInstance();
        $logger->source = __FUNCTION__;
        $logger->category = "auth";

        if ( $request->authentication === null )
        {
            $logger->log( "No credentials available", ezcLog::DEBUG );
            $request->uri = '/http-basic-auth';
            return new ezcMvcInternalRedirect( $request );
        }

        $cred = new ezcAuthenticationPasswordCredentials( $request->authentication->identifier,
                                                          md5( "{$request->authentication->identifier}\n{$request->authentication->password}" ) );
        $authDbInfo = new ezcAuthenticationDatabaseInfo( ezcDbInstance::get(), 'ezuser', array( 'login', 'password_hash' ) );

        $auth = new ezcAuthentication( $cred );
        $auth->addFilter( new ezcAuthenticationDatabaseFilter( $authDbInfo ) );


        if ( !$auth->run() )
        {
            // @TODO: Proper error messages required of course.
            $request->uri = '/http-basic-auth';
            return new ezcMvcInternalRedirect( $request );
        }
        else
        {
            // We're in
            $logger->log( "Authentication successful", ezcLog::DEBUG );
            // $logger->log( var_export( $request->raw, true), ezcLog::DEBUG );
        }
    }

}
?>