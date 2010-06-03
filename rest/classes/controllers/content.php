<?php
/**
 * File containing the ezpContentRestController class.
 *
 * @copyright Copyright (C) 1999-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPLv2
 */

/**
 * This controller is used for serving content
 */
class ezpRestContentController extends ezcMvcController
{

    public function doList()
    {
        $result = new ezcMvcResult();
        $result->variables['content'] = "This is the content, baby.";
        // var_dump( __METHOD__, $this );
        return $result;
    }

    public function doDisplay()
    {
    }

    public function doFields()
    {
        $demoNode = eZContentObjectTreeNode::fetch( $this->contentId );

        $result = new ezcMvcResult();
        $result->variables['content'] = "These are the fields, baby.";
        $result->variables['demo'] = $demoNode;
        // var_dump( __METHOD__, $this );
        return $result;
    }

    public function doShow()
    {
        $result = new ezcMvcResult;
        $result->variables['message'] = $this->message;
        $result->variables['stackTrace'] = $this->stackTrace;
        return $result;
    }
}
?>