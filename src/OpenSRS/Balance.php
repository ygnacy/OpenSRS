<?php
/**
 * OpenSRS/Balance.php
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
 * OpenSRS Balance Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Balance
{
    /**
     * A reference to the calling OpenSRS object
     *
     * @var OpenSRS
     */
    private $_openrsr;

    /**
     * Constructor
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
     * Get reseller's account balance.
     *
     * @return float Returns the total amount of money in the account.
     * @since  1.0
     */
    public function getBalance()
    {
        // Build request object
        $request = new OpenSRS_Request("balance", "get_balance");

        // Send request
        $response = $this->_openrsr->send($request);

        // Get response attributes
        $attr = $response->getAttributes();

        // Return balance as float
        return (float) $attr["balance"];
    }
}
