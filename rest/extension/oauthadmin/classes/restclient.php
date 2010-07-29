<?php
class ezpRestClient
{
    public $id = null;
    public $name = null;
    public $description = null;
    public $client_id = null;
    public $client_secret = null;
    public $endpoint_uri = null;
    public $owner_id = null;
    public $created = null;
    public $updated = null;
    public $version = null;

    public function getState()
    {
        $result = array();
        $result['id'] = $this->id;
        $result['name'] = $this->name;
        $result['description'] = $this->description;
        $result['client_id'] = $this->client_id;
        $result['client_secret'] = $this->client_secret;
        $result['endpoint_uri'] = $this->endpoint_uri;
        $result['owner_id'] = $this->owner_id;
        $result['created'] = $this->created;
        $result['updated'] = $this->updated;
        $result['version'] = $this->version;
        return $result;
    }

    public function setState( array $properties )
    {
        foreach( $properties as $key => $value )
        {
            $this->$key = $value;
        }
    }

    public function attribute( $attributeName )
    {
        if ( property_exists( $this, $attributeName ) )
            return $this->$attributeName;
        elseif ( $this->__isset( $attributeName ) )
            return $this->__get( $attributeName );
        else
            eZDebug::writeError( "Attribute '$attributeName' does not exist", __CLASS__ . '::attribute' );
    }

    public function hasAttribute( $attributeName )
    {
        return property_exists( $this, $attributeName ) or $this->__isset( $attributeName );
    }

    public function __get( $propertyName )
    {
        switch( $propertyName )
        {
            case 'owner':
            {
                return $this->_owner();
            } break;

            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
    }

    /**
     * Returns the eZUser who owns the object
     * @return eZUser
     */
    protected function _owner()
    {
        static $owner = false;

        if ( $owner === false )
        {
            $owner = eZUser::fetch( $this->owner_id );
        }

        return $owner;
    }

    public function __isset( $propertyName )
    {
        return in_array( $propertyName, array( 'owner' ) );
    }

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 0;
}
?>