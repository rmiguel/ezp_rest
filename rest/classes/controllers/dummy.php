<?php
class ezpRestDummyController extends ezcMvcController
{
    public function doFoo()
    {
        // Nada
        $res = new ezcMvcResult;
        return $res;
    }
}
?>