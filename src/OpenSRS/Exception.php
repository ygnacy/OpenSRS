<?php
/**
 * OpenSRS/Exception.php
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
 * OpenSRS Exception Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Exception extends Exception
{
    /**
     * Constructor
     *
     * @param string $msg  The exception message to be passed to the parent
     * @param int    $code The exception code to be passed to the parent
     *
     * @return void
     * @since  1.0
     */
    public function __construct($msg, $code=null)
    {
        parent::__construct($msg, $code);
    }
}
