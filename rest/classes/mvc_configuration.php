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
        $req->variables['message'] = $e->getMessage();
        $req->variables['stackTrace'] = xdebug_get_function_stack();
        return $req;
    }

    public function createRequestParser()
    {
        $parser = new ezcMvcHttpRequestParser();
        $parser->prefix = str_replace( '/index_rest.php', '', $_SERVER['SCRIPT_NAME'] );
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

    }

    public function runResponseFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response )
    {

    }

    public function runResultFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result )
    {

    }

}
?>