<?php
class ezpRestClient
{
    public $id = null;
    public $name = null;
    public $description = null;
    public $clientId = null;
    public $clientSecret = null;
    public $endPointUri = null;
    public $owner = null;
    public $created = null;
    public $updated = null;

    public function getState()
    {
        $result = array();
        $result['id'] = $this->id;
        $result['name'] = $this->name;
        $result['description'] = $this->description;
        $result['client_id'] = $this->clientId;
        $result['client_secret'] = $this->clientSecret;
        $result['endpoint_uri'] = $this->endPointUri;
        $result['owner'] = $this->owner;
        $result['created'] = $this->created;
        $result['updated'] = $this->updated;
        return $result;
    }

    public function setState( array $properties )
    {
        foreach( $properties as $key => $value )
        {
            $this->$key = $value;
        }
    }

    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 0;
}
?>