<?php
/**
 * OpenSRS/Contact.php
 *
 * PHP version 5
 *
 * @category  XMLRPC
 * @package   OpenSRS
 * @author    Lupo Montero <lupo@e-noise.com>
 * @copyright 2010 E-noise.com Limited
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      https://github.com/lupomontero/OpenSRS
 */

/**
 * OpenSRS Contact Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Contact implements Iterator, Countable, ArrayAccess
{
    /**
     * Array holding the contact data
     *
     * @var array
     */
    private $_array = array();

    /**
     * Internal array pointer
     *
     * @var int
     */
    private $_pointer = 0;

    /**
     * Constructor
     *
     * @param array $options An associative array used to populate object while
     *                       constructing
     *
     * @return void
     * @since  1.0
     */
    public function __construct(array $options=null)
    {
        if (!is_null($options)) {
            foreach ($options as $key=>$value) {
                $method_name = "set".$this->_makeCamelCase($key);
                if (method_exists($this, $method_name)) {
                    $this->$method_name($value);
                }
            }
        }
    }

    /**
     * Get organisation name
     *
     * @return string
     * @since  1.0
     */
    public function getOrgName()
    {
        return $this->_array["org_name"];
    }

    /**
     * Get first name
     *
     * @return string
     * @since  1.0
     */
    public function getFirstName()
    {
        return $this->_array["first_name"];
    }

    /**
     * Get last name
     *
     * @return string
     * @since  1.0
     */
    public function getLastName()
    {
        return $this->_array["last_name"];
    }

    /**
     * Get address1
     *
     * @return string
     * @since  1.0
     */
    public function getAddress1()
    {
        return $this->_array["address1"];
    }

    /**
     * Get address2
     *
     * @return string
     * @since  1.0
     */
    public function getAddress2()
    {
        return $this->_array["address2"];
    }

    /**
     * Get address3
     *
     * @return string
     * @since  1.0
     */
    public function getAddress3()
    {
        return $this->_array["address3"];
    }

    /**
     * Get city
     *
     * @return string
     * @since  1.0
     */
    public function getCity()
    {
        return $this->_array["city"];
    }

    /**
     * Get post code
     *
     * @return string
     * @since  1.0
     */
    public function getPostalCode()
    {
        return $this->_array["postal_code"];
    }

    /**
     * Get state or province
     *
     * @return string
     * @since  1.0
     */
    public function getState()
    {
        return $this->_array["state"];
    }

    /**
     * Get country
     *
     * @return string
     * @since  1.0
     */
    public function getCountry()
    {
        return $this->_array["country"];
    }

    /**
     * Get phone
     *
     * @return string
     * @since  1.0
     */
    public function getPhone()
    {
        return $this->_array["phone"];
    }

    /**
     * Get fax
     *
     * @return string
     * @since  1.0
     */
    public function getFax()
    {
        return $this->_array["fax"];
    }

    /**
     * Get email
     *
     * @return string
     * @since  1.0
     */
    public function getEmail()
    {
        return $this->_array["email"];
    }

    /**
     * Get preferred language
     *
     * @return string
     * @since  1.0
     */
    public function getLangPref()
    {
        return $this->_array["lang_pref"];
    }

    /**
     * Set organisation name
     *
     * @param string $value The organisation name
     *
     * @return void
     * @since  1.0
     */
    public function setOrgName($value)
    {
        $this->_array["org_name"] = $value;
    }

    /**
     * Set first name
     *
     * @param string $value The first name
     *
     * @return void
     * @since  1.0
     */
    public function setFirstName($value)
    {
        $this->_array["first_name"] = $value;
    }

    /**
     * Set last name
     *
     * @param string $value The last name
     *
     * @return void
     * @since  1.0
     */
    public function setLastName($value)
    {
        $this->_array["last_name"] = $value;
    }

    /**
     * Set the first line of the address
     *
     * @param string $value The first line of the address
     *
     * @return void
     * @since  1.0
     */
    public function setAddress1($value)
    {
        $this->_array["address1"] = $value;
    }

    /**
     * Set the second line of the address
     *
     * @param string $value The second line of the address
     *
     * @return void
     * @since  1.0
     */
    public function setAddress2($value)
    {
        $this->_array["address2"] = $value;
    }

    /**
     * Set the third line of the address
     *
     * @param string $value The third line of the address
     *
     * @return void
     * @since  1.0
     */
    public function setAddress3($value)
    {
        $this->_array["address3"] = $value;
    }

    /**
     * Set city
     *
     * @param string $value The city
     *
     * @return void
     * @since  1.0
     */
    public function setCity($value)
    {
        $this->_array["city"] = $value;
    }

    /**
     * Set post code
     *
     * @param string $value The post code
     *
     * @return void
     * @since  1.0
     */
    public function setPostalCode($value)
    {
        $this->_array["postal_code"] = $value;
    }

    /**
     * Set state or province
     *
     * @param string $value The state or province
     *
     * @return void
     * @since  1.0
     */
    public function setState($value)
    {
        $this->_array["state"] = $value;
    }

    /**
     * Set country
     *
     * @param string $value The country
     *
     * @return void
     * @since  1.0
     */
    public function setCountry($value)
    {
        $this->_array["country"] = $value;
    }

    /**
     * Set phone number
     *
     * @param string $value The phone number
     *
     * @return void
     * @since  1.0
     */
    public function setPhone($value)
    {
        $this->_array["phone"] = $value;
    }

    /**
     * Set fax number
     *
     * @param string $value The fax number
     *
     * @return void
     * @since  1.0
     */
    public function setFax($value)
    {
        $this->_array["fax"] = $value;
    }

    /**
     * Set email address
     *
     * @param string $value The email address
     *
     * @return void
     * @since  1.0
     */
    public function setEmail($value)
    {
        $this->_array["email"] = $value;
    }

    /**
     * Set preferred language
     *
     * @param string $value The preferred language
     *
     * @return void
     * @since  1.0
     */
    public function setLangPref($value)
    {
        $this->_array["lang_pref"] = $value;
    }

    /**
     * Implementation of Iterator::current()
     *
     * @return string
     * @since  1.0
     */
    public function current()
    {
        return $this->_array[$this->key()];
    }

    /**
     * Implementation of Iterator::next()
     *
     * @return void
     * @since  1.0
     */
    public function next()
    {
        $this->_pointer++;
    }

    /**
     * Implementation of Iterator::key()
     *
     * @return int
     * @since  1.0
     */
    public function key()
    {
        $keys = array_keys($this->_array);

        return $keys[$this->_pointer];
    }

    /**
     * Implementation of Iterator::valid()
     *
     * @return bool
     * @since  1.0
     */
    public function valid()
    {
        return ($this->_pointer < $this->count());
    }

    /**
     * Implementation of Iterator::rewind()
     *
     * @return void
     * @since  1.0
     */
    public function rewind()
    {
        $this->_pointer = 0;
    }

    /**
     * Count elements (implementation of Countable interface)
     *
     * @return int
     * @since  1.0
     */
    public function count()
    {
        return count($this->_array);
    }

    /**
     * Check whether a given offset exists in uderlying array
     *
     * Array Access interface implementation
     *
     * @param string $offset The offset to check
     *
     * @return bool
     * @since  1.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_array);
    }

    /**
     * Get a given offset from uderlying array
     *
     * Array Access interface implementation
     *
     * @param string $offset The offset to get
     *
     * @return string
     * @since  1.0
     */
    public function offsetGet($offset)
    {
        if (!isset($this->_array[$offset])) {
            $msg = "Can not get undefined offset in Contact. ";
            throw new OpenSRS_Exception($msg);
        }

        return $this->_array[$offset];
    }

    /**
     * Set a given offset in uderlying array
     *
     * Array Access interface implementation
     *
     * @param string $offset The offset to set
     * @param string $value  The value to set the offset to
     *
     * @return void
     * @since  1.0
     */
    public function offsetSet($offset, $value)
    {
        $method_name = "set".$this->_makeCamelCase($offset);
        if (!method_exists($this, $method_name)) {
            $msg = "Can not set undefined offset in Contact. ";
            throw new OpenSRS_Exception($msg);
        }

        $this->$method_name($value);
    }

    /**
     * Unset a given offset from in uderlying array
     *
     * Array Access interface implementation
     *
     * @param string $offset The offset to unset
     *
     * @return void
     * @since  1.0
     */
    public function offsetUnset($offset)
    {
        if (isset($this->_array[$offset])) {
            unset($this->_array[$offset]);
        }
    }

    /**
     * Format string to "camel case" convention
     *
     * @param string $str The string we want to format
     *
     * @return void
     * @since  1.0
     */
    private function _makeCamelCase($str)
    {
        return str_replace(" ", "", ucwords(str_replace("_", " ", $str)));
    }
}
