<?php
/**
 * OpenSRS.php
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
 * Require autoloader class.
 */
require "OpenSRS/Autoloader.php";

/**
 * A PHP class to interact with OpenSRS using XML API.
 *
 * This class is a facade class offering a single point of interaction with the
 * OpensSRS-PHP library.
 *
 * This class implements the SplSubject interface, so objects implementing the
 * SplObserver interface can subscribe to OpenSRS objects for updates.
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS implements SplSubject
{
    /**
     * The RPC Handler Version.
     *
     * @var string
     */
    const RPC_HANDLER_VERSION = "0.9";
    /**
     * The RPC Handler Port.
     *
     * @var string
     */
    private $_rpc_handler_port = 55443;
    /**
     * The OpenSRS server hostname.
     *
     * @var string
     */
    private $_host = "rr-n1-tor.opensrs.net";
    /**
     * The OpenSRS reseller username.
     *
     * @var string
     */
    private $_user = null;
    /**
     * The OpenSRS API access key.
     *
     * @var string
     */
    private $_key = null;
    /**
     * The cookie string if it has been set.
     *
     * @var string
     */
    private $_cookie = null;
    /**
     * Enable debugging?
     *
     * @var bool
     */
    private $_debug = false;
    /**
     * Cache directory if any.
     *
     * @var srting
     */
    private $_cache_dir = null;
    /**
     * Cache time in seconds.
     *
     * @var int
     */
    private $_cache_time = null;
    /**
     * Storage object holding references to the subsribed observers.
     *
     * @var SplObjectStorage
     */
    private $_obs;
    /**
     * An array containing messages about the requests sent to the OpenSRS
     * servers and the returned responses.
     *
     * @var array
     */
    private $_messages;

    /**
     * Constructs a new OpenSRS object.
     *
     * @param string $user       The reseller username.
     * @param string $key        The reseller's private API key.
     * @param string $cache_dir  [Optional] Path to cache directory (must be
     *                           writable).
     * @param int    $cache_time [Optional] Cache time in seconds.
     *
     * @return void
     * @since  1.0
     */
    public function __construct($user, $key, $cache_dir=null, $cache_time=null)
    {
        $this->_user       = trim($user);
        $this->_key        = trim($key);
        $this->_cache_dir  = trim($cache_dir);
        $this->_cache_time = (int) $cache_time;
        $this->_obs        = new SplObjectStorage();
        $this->_messages   = array();

        // If cache dir is specified check that exists and that is writable
        if (!empty($this->_cache_dir)) {
            if (!is_dir($this->_cache_dir) && !mkdir($this->_cache_dir)) {
                $msg = "Failed attempting to create cache directory.";
                throw new RuntimeException($msg);
            }

            if (!is_writable($this->_cache_dir)) {
                $msg = "Cache dir is not writable.";
                throw new RuntimeException($msg);
            }
        }
    }

    /**
     * Attach an observer object to receive updates.
     *
     * @param SplObserver $observer An object instance of type SplObserver.
     *
     * @return void
     * @since  1.0
     */
    public function attach(SplObserver $observer)
    {
        $this->_obs->attach($observer);
    }

    /**
     * Detach an observer object.
     *
     * @param SplObserver $observer An object instance of type SplObserver.
     *
     * @return void
     * @since  1.0
     */
    public function detach(SplObserver $observer)
    {
        $this->_obs->detach($observer);
    }

    /**
     * Notify subscribed observers of a state change.
     *
     * @return void
     * @since  1.0
     */
    public function notify()
    {
        foreach ($this->_obs as $observer) {
            $observer->update($this);
        }
    }

    /**
     * Enable/disable debugging messages.
     *
     * @param bool $bool [Optional] A boolean indicating whether debugging
     *                   should be enabled. If not passed the current value
     *                   will be returned.
     *
     * @return bool Returns a boolean value indicating whether debugging is
     *              enabled.
     * @since  1.0
     */
    public function debug($bool=null)
    {
        if (!is_null($bool)) {
            $this->_debug = (bool) $bool;
        }

        return $this->_debug;
    }

    /**
     * Get/set test mode.
     *
     * @param bool $bool [Optional] A boolean indicating whether test mode
     *                   should be enabled. If not passed the current value
     *                   will be returned.
     *
     * @return bool Returns a boolean value indicating whether test mode is
     *              enabled.
     * @since  1.0
     */
    public function testMode($bool=null)
    {
        // Set appropriate server if argument was passed
        if (!is_null($bool)) {
           if ($bool) {
               $this->_host = "horizon.opensrs.net";
           } else {
               $this->_host = "rr-n1-tor.opensrs.net";
           }
        }

        // Return boolean depending on current server
        if ($this->_host == "horizon.opensrs.net") {
           return true;
        }

        return false;
    }

    /**
     * Get opensrs host.
     *
     * @return string
     * @since  1.0
     */
    public function getHost()
    {
        return $this->_host;
    }

    /**
     * Get opensrs user.
     *
     * @return string
     * @since  1.0
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Get opensrs API key.
     *
     * @return string
     * @since  1.0
     */
    public function getKey()
    {
        return $this->_key;
    }

    /**
     * Get OpenSRS Balance object.
     *
     * @return OpenSRS_Balance
     * @since  1.0
     */
    public function balance()
    {
        return new OpenSRS_Balance($this);
    }

    /**
     * Get OpenSRS Cookie object.
     *
     * @return OpenSRS_Cookie
     * @since  1.0
     */
    public function cookie()
    {
        return new OpenSRS_Cookie($this);
    }

    /**
     * Get OpenSRS Domain object.
     *
     * @return OpenSRS_Domain
     * @since  1.0
     */
    public function domain()
    {
        return new OpenSRS_Domain($this);
    }

    /**
     * Get OpenSRS Session object.
     *
     * @return OpenSRS_Session
     * @since  1.0
     */
    public function session()
    {
        return new OpenSRS_Session($this);
    }

    /**
     * Send a request and return a response.
     *
     * @param OpenSRS_Request $request An OpenSRS_Request object to be sent to the
     *                                 server.
     *
     * @return OpenSRS_Response
     * @throws OpenSRS_Exception on failure.
     * @since  1.0
     */
    public function send(OpenSRS_Request $request)
    {
        // Sign request
        $signature = $this->_signRequest($request);

        // Build headers
        $str  = "POST ".$this->getHost()." HTTP/1.0\r\n";
        $str .= "Content-Type: text/xml\r\n";
        $str .= "X-Username: " . $this->getUser() . "\r\n";
        $str .= "X-Signature: " . $signature . "\r\n";
        $str .= "Content-Length: " . strlen($request) . "\r\n\r\n";

        // Prepend headers to request
        $request = $str.$request;

        // Connect to socket using SSL
        $fp = @fsockopen(
            "ssl://".$this->_host,
            $this->_rpc_handler_port,
            $errno,
            $errstr,
            30
        );

        if (!$fp) {
            throw new OpenSRS_Exception($errstr, $errno);
        }

        // show request if debugging
        if ($this->debug()) {
            $this->addMessage("SENDING REQUEST... \n\n".$request);
        }

        // Write the request to the socket
        fputs($fp, $request);

        // Get raw response
        $response = "";
        while (!feof($fp)) {
            $response .= fgets($fp, 1024);
        }

        // Close socket
        fclose($fp);

        // show response if debugging
        if ($this->debug()) {
            $this->addMessage("GOT RESPONSE... \n\n" . $response);
        }

        // Crete response object
        $response = new OpenSRS_Response($response);

        if (!$response->isSuccess()) {
            throw new OpenSRS_Exception(
                $response->getResponseText(),
                $response->getResponseCode()
            );
        }

        return $response;
    }

    /**
     * Get last message.
     *
     * @return string
     * @since  1.0
     */
    public function getLastMessage()
    {
        return end($this->getMessages());
    }

    /**
     * Get messages array.
     *
     * @return array
     * @since  1.0
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Add an internal message.
     *
     * @param string $str The message to be notified to subsribed observers.
     *
     * @return void
     * @since  1.0
     */
    public function addMessage($str)
    {
        // Store message in internal array
        $this->_messages[] = trim($str);

        // Notify observers
        $this->notify();
    }

    /**
     * Sign request using API key.
     *
     * @param OpenSRS_Request $request An OpenSRS_Request object to sign.
     *
     * @return string
     * @since  1.0
     */
    private function _signRequest(OpenSRS_Request $request)
    {
        // Cast request object to string
        $request = (string) $request;

        // Generate signature
        return md5(md5($request.$this->getKey()).$this->getKey());
    }
}
