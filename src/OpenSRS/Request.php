<?php
/**
 * OpenSRS/Request.php
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
 * OpenSRS Request Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Request
{
    /**
     * Array holding the request data
     *
     * @var array
     */
    private $_array = array('protocol' => 'XCP');

    /**
     * Constructor
     *
     * @param string $object The Open SRS object to which the action belongs.
     * @param string $action The action to be performed on the remote object.
     * @param array  $attr   The attributes to be passed with the request.
     *
     * @return void
     * @since  1.0
     */
    public function __construct($object, $action, array $attr=null)
    {
        $this->_array["object"] = trim((string) $object);
        $this->_array["action"] = trim((string) $action);

        if (!is_null($attr)) {
            $this->_array["attributes"] = $attr;
        }
    }

    /**
     * Convert object to string
     *
     * @return string
     * @since  1.0
     */
    public function __toString()
    {
        $str  = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\" ?>\r\n";
        $str .= "<!DOCTYPE OPS_envelope SYSTEM \"ops.dtd\">\r\n";
        $str .= "<OPS_envelope>\r\n";
        $str .= "<header>\r\n";
        $str .= "<version>".OpenSRS::RPC_HANDLER_VERSION."</version>\r\n";
        $str .= "</header>\r\n";
        $str .= "<body>\r\n";
        $str .= "<data_block>\r\n";
        $str .= $this->_buildDataBlock($this->_array);
        $str .= "</data_block>\r\n";
        $str .= "</body>\r\n";
        $str .= "</OPS_envelope>\r\n";

        return $str;
    }

    /**
     * Builds the xml data block for the request. Recursive function.
     *
     * @param array|Iterator $array An array to process and build the XML data
     *                              block.
     *
     * @return string
     * @since  1.0
     */
    private function _buildDataBlock($array)
    {
        if (!is_array($array) && !$array instanceof Iterator) {
            $msg  = "Argument passed to ".get_class($this)."::_buildDataBlock() ";
            $msg .= "should be of type array or Iterator";
            throw new OpenSRS_Exception($msg);
        }

        if (array_key_exists(0, $array)) {
            $tag_name = "dt_array";
        } else {
            $tag_name = "dt_assoc";
        }

        $data_block = "<".$tag_name.">\r\n";

        foreach ($array as $key=>$value) {
            if (is_array($value) || $value instanceof Iterator) {
                $data_block .= "<item key=\"".$key."\">\r\n";
                $data_block .= $this->_buildDataBlock($value);
                $data_block .= "</item>\r\n";
            } elseif (!is_null($value)) {
                $data_block .= "<item key=\"".$key."\">".$value."</item>\r\n";
            }
        }

        $data_block .= "</".$tag_name.">\r\n";

        return $data_block;
    }
}
