<?php
/**
 * File containing the ezpOuathUtility class
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 *
 */

/**
 * Functionality for working against the draft 10 of the oauth2 spec.
 *
 * @package rest
 */
class ezpOauthUtility
{
    protected $logger = null;

    const AUTH_HEADER_NAME     = 'Authorization';
    const AUTH_CGI_HEADER_NAME = 'HTTP_AUTHORIZATION';

    public function __construct()
    {
        $this->logger = ezcLog::getInstance();
        $this->logger->source = __CLASS__;
        $this->logger->category = "oauth";
    }

    /**
     * Retrieving token as per section 5 of draft-ietf-oauth-v2-10
     *
     * Token can be present inside the Authorize header, inside a URI query
     * parameter, or in the HTTP body.
     *
     * According to section 5.1 the header is the preferred way, and the query
     * component and HTTP body are only looked at if no such header can be found.
     *
     * @TODO A configuration mechanism should alternatively let us select which
     * method to use: 1. header, 2. query component, 3. http body, in other words
     * to override the default behaviour according to spec.
     *
     * @param string $ezcMvcRequest
     * @return void
     */
    public function getToken( ezcMvcRequest $request )
    {
        // 1. Should first extract required token from the request object
        //    as we know that the request parser does not support this at the
        //    moment we, will skip to the fallback right away. That is to say,
        //    ideally the request parser would make this header available to us,
        //    when available, automatically.
        $this->logger->log( "Trying to get access token from http headers", ezcLog::DEBUG );
        $token = $this->getTokenFromAuthorizationHeader();
        if ( $token !== null )
            $this->logger->log( "Found token from header", ezcLog::DEBUG );
    }


    /**
     * Extracts the OAuth token from the HTTP header, Authorization.
     * 
     * The token is transmitted via the OAuth Autentication scheme ref.
     * Section 5.1.1.
     * 
     * PHP does not expose the Authorization header unelss it uses the 'Basic'
     * or 'Digest' schemes, and it is therefore extracted from the raw Apache
     * headers.
     * 
     * On systems running CGI or Fast-CGI PHP makes this header available via
     * the <var>HTTP_AUTHORIZATION</var> header.
     * @link http://php.net/manual/en/features.http-auth.php
     *
     * @return string The access token string.
     */
    protected function getTokenFromAuthorizationHeader()
    {
        // @TODO We cannot throw exceptions here, until all alternatives are checked.
        $apacheHeaders = apache_request_headers();
        if ( !isset( $apacheHeaders[self::AUTH_HEADER_NAME] ) )
            throw new ezpOauthTokenNotFoundException( "No Authorization header found" );

        $tokenPattern = "/^(?P<authscheme>OAuth)\s(?P<token>[a-zA-Z0-9]+)$/";
        $match = preg_match( $tokenPattern, $apacheHeaders[self::AUTH_HEADER_NAME], $m );
        if ( !$match )
            throw new ezpOauthTokenNotFoundException( "Token not found Authorization header" );

        if ( $m['authscheme'] !== 'OAuth' )
            throw new ezpOauthTokenNotFoundException( "OAuth authentication scheme not found" );

        return $m['token'];
    }

    protected function getTokenFromQueryComponent()
    {

    }

    protected function getTokenFromHttpBody()
    {

    }
}
?>
