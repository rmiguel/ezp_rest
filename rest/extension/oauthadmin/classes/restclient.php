<?php
class ezpRestClient
{
    public $id = null;
    public $clientId = null;
    public $clientSecret = null;
    public $endPointUri = null;

    public function getState(
    {
        $result = array();
        $result['id'] = $this->id;
        $result['client_id'] = $this->clientId;
        $result['client_secret'] = $this->clientSecret;
        $result['endpoint_uri'] = $this->endPointUri;
        return $result;
    }

    public function setState( array $properties )
    {
        foreach( $properties as $key => $value )
        {
            $this->$key = $value;
        }
    }}
?>