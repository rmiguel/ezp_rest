<?php
class ezpRestDummyController extends ezcMvcController
{
    public function doFoo()
    {
        // Nada
        $res = new ezcMvcResult;
        $res->variables['content'] = "This is the dummy protected content.";
        return $res;
    }
}
?>