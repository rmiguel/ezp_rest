<?php
class ezpRestOauthErrorStatus implements ezcMvcResultStatusObject
{
    // Messages should also in some cases be added to the HTTP body, with
    // info from app, extending the normal short http default boiler palte message.

    public $code = null;

    public function __construct( $code )
    {
        $this->code = $code;
    }

    public function process( ezcMvcResponseWriter $writer )
    {
        if ( $writer instanceof ezcMvcHttpResponseWriter )
        {
            // @TODO message lookup
            $writer->headers["HTTP/1.1 " . $this->code] = "";
        }
    }
}
?>