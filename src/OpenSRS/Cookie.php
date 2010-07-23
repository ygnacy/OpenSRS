<?php
/**
 * OpenSRS/Cookie.php
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
 * OpenSRS Cookie Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Cookie
{
    /**
     * A reference to the calling OpenSRS object.
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
     * Create a cookie for use in commands where a cookie is required to
     * access OpenSRS.
     *
     * @param string $domain_name  The domain for which we want to set the
     *                             cookie.
     * @param string $reg_username The username that owns the domain name.
     * @param string $reg_password The password for the domain username.
     *
     * @return string The current user's cookie. Note: The format of the cookie
     *                is subject to change, and should be treated as a simple
     *                string.
     * @since  1.0
     */
    public function set($domain_name, $reg_username, $reg_password)
    {
        $request = new OpenSRS_Request(
            "cookie",
            "set",
            array(
                "domain" => $domain_name,
                "reg_username" => $reg_username,
                "reg_password" => $reg_password
            )
        );

        $attr = $this->_openrsr->send($request)->getAttributes();

        return $attr["cookie"];
    }

    /**
     * Delete cookie
     *
     * @param string $cookie The cookie to be deleted
     *
     * @return bool Returns TRUE on success or throws an exception on failure.
     * @throws OpenSRS_Exception
     * @since  1.0
     */
    public function delete($cookie)
    {
        $request = new OpenSRS_Request(
            "cookie",
            "delete",
            array("cookie"=>$cookie)
        );

        // If no exception is thrown sending request the response status must
        // be ok, so we return true.
        $this->_openrsr->send($request);

        return true;
    }

    /**
     * Update cookie
     *
     * @param string $cookie       The cookie to be updated
     * @param string $domain_name  The domain for which the old cookie had been set
     * @param string $domain_new   The domain for which we want to set the new
     *                             cookie
     * @param string $reg_username The username that owns the domain name
     * @param string $reg_password The password for the domain username
     *
     * @return string The current user's cookie. Note: The format of the cookie
     *                is subject to change, and should be treated as a simple
     *                string.
     * @since  1.0
     */
    public function update(
        $cookie,
        $domain_name,
        $domain_new,
        $reg_username,
        $reg_password
    ) {
        $request = new OpenSRS_Request(
            "cookie",
            "update",
            array(
                "cookie"       => $cookie,
                "domain"       => $domain_name,
                "domain_new"   => $domain_new,
                "reg_username" => $reg_username,
                "reg_password" => $reg_password
            )
        );

        $attr = $this->_openrsr->send($request)->getAttributes();

        return $attr["cookie"];
    }
}
