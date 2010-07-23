<?php
class ezpRestNotFound implements ezcMvcResultStatusObject
{
    // @TODO Make this dynamic to return all types of HTTP response codes
    // e.g. For instance constructor can accept code as param.

    // Messages should also in some cases be added to the HTTP body, with
    // info from app, extending the normal short http default boiler palte message.

    public function process( ezcMvcResponseWriter $writer )
    {
        if ( $writer instanceof ezcMvcHttpResponseWriter )
        {
            $writer->headers["HTTP/1.1 " . ezpHttpResponseCodes::NOT_FOUND] = "Not Found";
        }
    }
}
?>