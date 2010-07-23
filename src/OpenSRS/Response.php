<?php
/**
 * OpenSRS/Response.php
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
 * OpenSRS Response Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Response
{
    /**
     * Response string
     *
     * @var string
     */
    private $_response;
    /**
     * An array holding the parsed response
     *
     * @var array
     */
    private $_array = array();

    /**
     * Constructor
     *
     * @param string $str XML response string as received from the OpenSRS server
     *
     * @return void
     * @since  1.0
     */
    public function __construct($str)
    {
        $this->_response = trim((string) $str);

        // drop the headers from response string
        $arrResponse = explode("\n", $this->_response);
        $response    = "";
        $flag        = false;

        foreach ($arrResponse as $line) {
            if ($flag) {
                $response .= $line."\n";
            } elseif (trim($line) == "") {
                $flag = true;
            }
        }

        // Convert XML response into array and store in object
        if (!empty($response)) {
            $this->_array = $this->_parseXMLResponse($response);
        } else {
            $this->_array = $this->_parseXMLResponse($this->_response);
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
        return $this->_response;
    }

    /**
     * Is success?
     *
     * @return bool
     * @since  1.0
     */
    public function isSuccess()
    {
        if (!isset($this->_array["is_success"])) {
            return false;
        }

        return (bool) $this->_array["is_success"];
    }

    /**
     * Get HTTP status code
     *
     * @return int
     * @since  1.0
     */
    public function getResponseCode()
    {
        if (!isset($this->_array["response_code"])) {
            return null;
        }

        return (int) $this->_array["response_code"];
    }

    /**
     * Get response text
     *
     * @return string
     * @since  1.0
     */
    public function getResponseText()
    {
        if (!isset($this->_array["response_text"])) {
            return null;
        }

        return (string) $this->_array["response_text"];
    }

    /**
     * Get response attributes
     *
     * @return array
     * @since  1.0
     */
    public function getAttributes()
    {
        if (!isset($this->_array["attributes"])) {
            return null;
        }

        return $this->_array["attributes"];
    }

    /**
     * This method is used to parse the XML response returned by OpenRSR
     *
     * Resonse is returned as a nice asociative array with all the data.
     *
     * @param string $str A string containing the XML response.
     *
     * @return array
     * @since  1.0
     */
    private function _parseXMLResponse($str)
    {
        $domDocument = new DOMDocument;
        $domDocument->loadXML($str);

        $domXPath = new DOMXPath($domDocument);
        $query    = "//OPS_envelope/body/data_block/dt_assoc/item";
        $nodes    = $domXPath->query($query);

        return $this->_parseXMLResponseRecurse($domXPath, $nodes);
    }

    /**
     * This method is used by _parseXMLResponse() to loop recursively through XML
     * nodes and collect data.
     *
     * @param DOMXPath $domXPath    The DOMXPath object used for parsing the XML.
     *                              This object is created in _parseXMLResponse().
     * @param object   $nodes       The nodes to process
     * @param string   $search_path The search path for DOMXPath
     * @param array    &$array      An array passed by reference that we populate
     *                              recursively and then use for return
     *
     * @return array
     * @since  1.0
     */
    private function _parseXMLResponseRecurse(
        DOMXPath $domXPath,
        $nodes,
        $search_path="",
        &$array=array()
    ) {
        foreach ($nodes as $node) {
            if ($node->childNodes->length > 1) {
                $query    = "dt_assoc/item";
                $children = $domXPath->query($query, $node);

                $this->_parseXMLResponseRecurse(
                    $domXPath,
                    $children,
                    $query,
                    $array[$node->getAttribute("key")]
                );

                $query    = "dt_array/item";
                $children = $domXPath->query($query, $node);

                $this->_parseXMLResponseRecurse(
                    $domXPath,
                    $children,
                    $query,
                    $array[$node->getAttribute("key")]
                );
            } else {
                $array[$node->getAttribute("key")] = $node->nodeValue;
            }
        }

        return $array;
    }
}
