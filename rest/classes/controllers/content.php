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
     * Handles a content request per node ID
     * Request: GET /api/content/node/XXX
     *
     * @param int $nodeId Numerical eZContentObjectTreeNode id
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

    /**
     * Handles a content request per object ID
     * Request: GET /api/content/object/XXX
     *
     * @param int $objectId Numerical eZContentObject id
     * @return ezcMvcResult
     */
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

    /**
     * Handles a content request with fields per object Id
     * Request: GET /api/content/object/XXX/fields
     *
     * @param int $objectId Numerical eZContentObjectId
     * @return ezcMvcResult
     */
    public function doViewFields( $objectId )
    {
        try {
            $content = ezpContent::fromObjectId( $objectId );
        } catch( Exception $e ) {
            // @todo handle error
            die( $e->getMessage() );
        }

        $result = new ezcMvcResult;

        // iterate over each field and extract its exposed properties
        $returnFields = array();
        foreach( $content->fields as $name => $field )
        {
            $returnFields[$name] = $this->attributeOutputData( $field );
        }
        $result->variables['fields'] = $returnFields;
        return $result;
    }

    /**
     * Default method, currently used for fatal error handling
     * @return ezcMvcResult
     */
    public function doShow()
    {
        $result = new ezcMvcResult;
        $result->variables['message'] = $this->message;
        $result->variables['stackTrace'] = $this->stackTrace;
        return $result;
    }

    /**
     * Handles a content unique field request through an object ID
     * @param int $objectId
     * @param string $fieldReference
     * @return ezcMvcResult
     */
    public function doViewField( $objectId, $fieldReference )
    {
        try {
            $content = ezpContent::fromObjectId( $objectId );
        } catch( Exception $e ) {
            // @todo handle error
            die( $e->getMessage() );
        }

        if ( !isset( $content->fields->$fieldReference ) )
        {
            // @todo Handle error
            return false;
        }

        // object metadata
        $result = self::viewContent( $content );

        // fieldd data
        $result->variables['fields'][$fieldReference] = $this->attributeOutputData( $content->fields->$fieldReference );

        return $result;
    }

    /**
     * Returns an ezcMvcResult that represents a piece of content
     * @param ezpContent $content
     * @param ezcMvcResult $result A result the variables will be added to. If not given, a fresh one is used.
     * @return ezcMvcResult
     */
    protected function viewContent( ezpContent $content, ezcMvcResult $result = null )
    {
        if ( $result === null )
            $result = new ezcMvcResult;

        // metadata
        $result->variables['classIdentifier'] = $content->classIdentifier;
        $result->variables['objectName'] = $content->name;
        $result->variables['datePublished'] = $content->datePublished;
        $result->variables['dateModified'] = $content->dateModified;

        // links to further resources about the object
        $resourceLinks = array();
        $result->variables['links'] = $resourceLinks;

        return $result;
    }

    /**
     * Transforms an ezpContentField in an array representation
     * @todo Refactor, this doesn't really belong here. Either in ezpContentField, or in an extend class
     */
    protected function attributeOutputData( ezpContentField $attribute )
    {
        $sXml = simplexml_import_dom( $attribute->serializedXML );

        $attributeType = (string)$sXml['type'];

        // get ezremote NS elements in order to get the attribute identifier
        $ezremoteAttributes = $sXml->attributes( 'http://ez.no/ezobject' );
        $attributeIdentifier = (string)$ezremoteAttributes['identifier'];

        // attribute value
        $children = $sXml->children();
        $attributeValue = array();
        foreach( $children as $child )
        {
            // simple value
            if ( count( $child->children() ) == 0 )
            {
                // complex value, probably a native eZ Publish XML
                $attributeValue[$child->getName()] = (string)$child;
            }
            else
            {
                // complex attribute, skip for now
            }
        }

        // cleanup values so that the result is consistent:
        // - no array if one item
        // - false if no values
        if ( count( $attributeValue ) == 0 )
            $attributeValue = false;
        elseif ( count( $attributeValue ) == 1 )
            $attributeValue = current( $attributeValue );

        return array(
            'type'       => $attributeType,
            'identifier' => $attributeIdentifier,
            'value'      => $attributeValue,
        );
    }
}
?>