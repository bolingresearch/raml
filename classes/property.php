<?php
class Property
{
    public $id;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $country;
    public $latitude;
    public $longitude;

    private $table_name = "properties";

    public function __construct($arg)
    {
        if (is_numeric($arg))
        {
            $record = $this->find_by_id($arg);
            $this->instantiate($record);
        } elseif (! empty($arg))
        {
            $this->populate($arg);
        }
    }

    public function find_by_id($id = 0)
    {
        global $db;
        $result = $db->query("SELECT * FROM ".$this->table_name." WHERE id={$id}");
        $record = $db->fetch_array($result);
        return $record;
    }

    public function find_by_sql($sql = "")
    {
        global $db;
        $result_set = $db->query($sql);
        $object_array = array ();
        while ($row = $db->fetch_array($result_set))
        {
            $object_array[] = $this->instantiate($row);
        }
        return $object_array;
    }

    private function instantiate($record)
    {
        foreach ($record as $attribute=>$value)
        {
            if ($this->has_attribute($attribute))
            {
                $this->$attribute = $value;
            }
        }
    }

    public function insert()
    {
        if (!isset($this->id) && $this->address != "")
        {
            global $db;
            $sql = "INSERT INTO properties (address, address2, city, state, zip, country, latitude, longitude) ";
            $sql .= "VALUES ('".$this->address."', NULL, '".$this->city."', '".$this->state."', '".$this->zip."', '".$this->country."', '".$this->latitude."', '".$this->longitude."')";
            if ($db->query($sql))
            {
                return $this->id = $db->insert_id();
            } else
            {
                return false;
            }
        } else {
        	return false;
        }
    }

    public function get_serialized()
    {
        return serialize($this);
    }

    public function populate($address = array ())
    {
        if (! empty($address))
        {
            $address['street'] = urlencode($address['street']);
            $address['city'] = urlencode($address['city']);
            $address['state'] = urlencode($address['state']);

            // Yahoo! Web Services request
            $req = "http://local.yahooapis.com/MapsService/V1/geocode?";
            $req .= "appid=".YAHOO_APP_ID."&";
            $req .= "street=".$address['street']."&";
            $req .= "city=".$address['city']."&";
            $req .= "state=".$address['state']."&";
            $req .= "output=php"; // serialized php array

            // Make the request
            $phpserialized = file_get_contents($req);
            if ($phpserialized === false)
            {
                die ('Request failed');
            }

            // Parse the serialized response
            $data = unserialize($phpserialized);

            $this->address = $data['ResultSet']['Result']['Address'];
            $this->city = $data['ResultSet']['Result']['City'];
            $this->state = $data['ResultSet']['Result']['State'];
            $this->zip = $data['ResultSet']['Result']['Zip'];
            $this->country = $data['ResultSet']['Result']['Country'];
            $this->latitude = $data['ResultSet']['Result']['Latitude'];
            $this->longitude = $data['ResultSet']['Result']['Longitude'];
        }
    }

    private function has_attribute($attribute)
    {
        $object_vars = get_object_vars($this); // fyi: includes private variables too.
        // we just want the the keys, not concerned with the values.
        return array_key_exists($attribute, $object_vars);
    }
}
?>
