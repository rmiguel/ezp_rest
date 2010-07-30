<?php
/**
 * File containing the oauth/authorize view definition
 *
 * @param string $_GET[client_id] the client application identifier, as in ezpRestClient
 * @param string $_GET[redirect_uri] the URI the view should redirect to in case of success
 * @param string $_GET[response_type] the requested response type. Can be code_and_token, code, or token
 * @param string $_GET[scope] the permissions scope the client requests (optional)
 * @param string $_GET[state] Not implemented yet (optional)
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package oauth
 */

$module = $Params['Module'];

// First check for mandatory parameters
$http = eZHTTPTool::instance();

// Redirect URI, required to handle other errors, checked first
if ( !$http->hasGetVariable( 'redirect_uri' ) )
{
    response( '400 Bad Request' );
    eZExecution::cleanExit();
}
$pRedirectUri = $http->getVariable( 'redirect_uri' );

// Client ID
if ( !$http->hasGetVariable( 'client_id' ) )
{
    error( $pRedirectUri, 'invalid_request', "Missing client ID parameter" );
    // redirect to the redirect_uri with GET parameter error=invalid_request
    // @todo mismatch between chapters 3.2's example (error=access-denied) and error codes list at 3.2.1 (error=access_denied)
}
$pClientId = $http->getVariable( 'client_id' );

// Requested response type
if ( !$http->hasGetVariable( 'response_type' ) )
{
    error( $pRedirectUri, 'invalid_request', "Missing response_type parameter" );
    // redirect to the redirect_uri with GET parameter error=invalid_request
    // @todo mismatch between chapters 3.2's example (error=access-denied) and error codes list at 3.2.1 (error=access_denied)
}
$pResponseType = $http->getVariable( 'response_type' );

// Scope
if ( $http->hasGetVariable( 'scope' ) )
    $pScope = $http->getVariable( 'scope' );

// @todo The spec mentions (FIXME:chapter) throwing an error if the request has extra parameters. Check this.

include 'extension/oauthadmin/modules/oauthadmin/tmppo.php';

// Try loading the REST client based on the ID
$application = ezpRestClient::fetchByClientId( $pClientId );
if ( !$application instanceof ezpRestClient )
{
    error( $pRedirectUri, 'invalid_client' );
}

// The client is found, validate the redirect_uri
if ( !$application->isEndPointValid( $pRedirectUri ) )
{
    error( $pRedirectUri, 'redirect_uri_mismatch' );
}

// Everything is valid, redirect to the redirect_uri with these parameters:
// - code, only if request_type == code OR code_and_token @todo Implement
// - access_token, only if request_type == token OR code_and_token
// - expires_in, the token lifetime in seconds @todo Implement
// - scope, the permission scope the provided code / token grants, if different from the requested one (not implemented yet)
// - state, not implemented yet (state persistency related)
$parameters = array();

$rAccessToken = uniqid( 'token' );
$rExpiresIn = 3600;

$parameters[] = 'access_token=' . urlencode( $rAccessToken );
$parameters[] = "expires_in=$rExpiresIn";
$location = "{$pRedirectUri}?" . implode( $parameters, '&' );

response( '302 Found', $location );

/**
 * oAuth error handler function. Terminates execution after redirecting.
 *
 * @param string $redirectUri The URI the error should be sent to
 * @param string $errorCode The error code, as defined in section 3.2.1
 * @param string $message A human readable error message explaining the error
 *
 * @return void
 */
function error( $redirectUri, $errorCode, $message = null )
{
    $location = "{$redirectUri}?error=" . urlencode( $errorCode );
    if( $message !== null )
        $location .= '&error_description=' . urlencode( $message );
    response( '302 Found', $location );
}

/**
 * oAuth2 response handler function. Terminates execution after sending the headers.
 *
 * @param string $httpHeader The HTTP header to be sent as a response
 * @param string $location The location to redirect to. No redirection is done if not provided.
 *
 * @return void
 */
function response( $httpHeader, $location = null )
{
    header( "HTTP 1.1 $httpHeader" );
    if ( $location !== null )
        // debug stuff: echo "header( \"Location: $location\" );\n";
        header( "Location: $location" );
    eZExecution::cleanExit();
}
?>