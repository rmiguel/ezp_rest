<?php
/**
 * File containing the ezpOauthRequired class.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 *
 */


/**
 * This result type is used to signal a HTTP basic auth header
 */
class ezpOauthRequired implements ezcMvcResultStatusObject
{
    /**
     * The realm is the unique ID to identify a login area
     *
     * @var string
     */
    public $realm;

    // For error codes see section 5.2.1
    public $errorType;
    public $errorMessage;

    public function __construct( $realm, $errorType = null, $errorMessage = null )
    {
        $this->realm = $realm;
        $this->errorType = $errorType;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Uses the passed in $writer to set the HTTP authentication header.
     *
     * @param ezcMvcResponseWriter $writer
     */
    public function process( ezcMvcResponseWriter $writer )
    {
        if ( $writer instanceof ezcMvcHttpResponseWriter )
        {
            $writer->headers['HTTP/1.1 ' . ezpHttpResponseCodes::UNAUTHORIZED] = "";

            if ( $this->errorType !== null && $this->errorMessage !== null)
            {
                $writer->headers['WWW-Authenticate'] = "OAuth realm=\"{$this->realm}\" error=\"{$this->errorType}\"";
            }
            else
            {
                $writer->headers['WWW-Authenticate'] = "OAuth realm=\"{$this->realm}\"";
            }
        }
    }
}
?>
