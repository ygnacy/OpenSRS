<?php
/**
 * OpenSRS/ContactSet.php
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
 * OpenSRS ContactSet Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_ContactSet
{
    /**
     * An array to hold the contact objects
     *
     * @var array
     */
    private $_contacts = array();

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
                $method_name = ucwords(str_replace("_", " ", $key));
                $method_name = "set".str_replace(" ", "", $method_name);

                if (method_exists($this, $method_name)) {
                    $this->$method_name($value);
                }
            }
        }
    }

    /**
     * Set owner contact
     *
     * @param OpenSRS_Contact $contact An OpenSRS_Contact object
     *
     * @return void
     * @since  1.0
     */
    public function setOwner(OpenSRS_Contact $contact)
    {
        $this->_contacts["owner"] = $contact;
    }

    /**
     * Set admin contact
     *
     * @param OpenSRS_Contact $contact An OpenSRS_Contact object
     *
     * @return void
     * @since  1.0
     */
    public function setAdmin(OpenSRS_Contact $contact)
    {
        $this->_contacts["admin"] = $contact;
    }

    /**
     * Set billing contact
     *
     * @param OpenSRS_Contact $contact An OpenSRS_Contact object
     *
     * @return void
     * @since  1.0
     */
    public function setBilling(OpenSRS_Contact $contact)
    {
        $this->_contacts["billing"] = $contact;
    }

    /**
     * Set tech contact
     *
     * @param OpenSRS_Contact $contact An OpenSRS_Contact object
     *
     * @return void
     * @since  1.0
     */
    public function setTech(OpenSRS_Contact $contact)
    {
        $this->_contacts["tech"] = $contact;
    }

    /**
     * Is valid?
     *
     * @return bool
     * @since  1.0
     */
    public function isValid()
    {
        $keys = array("owner", "admin", "billing", "tech");

        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->_contacts)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get contact set as an associative array
     *
     * @return bool
     * @since  1.0
     */
    public function toArray()
    {
        return $this->_contacts;
    }
}
