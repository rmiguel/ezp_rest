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

    /**
     * @return ezcMvcResult
     */
    public function doViewNode( $nodeId )
    {
        try {
            $content = ezpContent::fromNodeId( $nodeId );
        } catch( Exception $e ) {
            // @todo handle error
            die( $e->getMessage() );
        }

        return $this->viewContent( $content );
    }

    public function doViewObject( $objectId )
    {
        try {
            $content = ezpContent::fromObjectId( $objectId );
        } catch( Exception $e ) {
            // @todo handle error
            die( $e->getMessage() );
        }

        return $this->viewContent( $content );
    }

    public function doViewFields( $objectId )
    {
        try {
            $content = ezpContent::fromObjectId( $objectId );
        } catch( Exception $e ) {
            // @todo handle error
            die( $e->getMessage() );
        }

        $result = new ezcMvcResult;
        foreach( $content->fields as $name => $field )
        {
            $result->variables[$name] = (string)$field; // this spits either an array or an object
        }
        return $result;
    }

    public function doShow()
    {
        $result = new ezcMvcResult;
        $result->variables['message'] = $this->message;
        $result->variables['stackTrace'] = $this->stackTrace;
        return $result;
    }

    /**
     * Returns an ezcMvcResult that represents a piece of content
     * @return ezcMvcResult
     */
    protected function viewContent( ezpContent $content )
    {
        $result = new ezcMvcResult;
        $result->variables['classIdentifier'] = $content->classIdentifier;
        $result->variables['objectName'] = $content->name;
        $result->variables['published'] = $content->datePublished;
        $result->variables['modified'] = $content->dateModified;

        return $result;
    }
}
?>