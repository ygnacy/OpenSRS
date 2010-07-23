<?php
/**
 * OpenSRS/Session.php
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
 * OpenSRS Session Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Session
{
    /**
     * A reference to the calling OpenSRS object.
     *
     * @var OpenSRS
     */
    private $_openrsr;

    /**
     * Constructor.
     *
     * @param OpenSRS $openrsr An OpenSRS object used to send the requests.
     *
     * @return void
     * @since  1.0
     */
    public function __construct(OpenSRS $openrsr)
    {
        $this->_openrsr = $openrsr;
    }

    /**
     * Quit the current session.
     *
     * @return bool Returns TRUE on success or throws an exception on failure.
     * @throws OpenSRS_Exception
     * @since  1.0
     */
    public function quit()
    {
        // If no exception is thrown sending request the response status must
        // be ok, so we return true.
        $this->_openrsr->send(new OpenSRS_Request("session", "quit"));

        return true;
    }
}
