<?php
/**
 * OpenSRS/Autoloader.php
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
 * Register autoload function
 */
spl_autoload_register(array("OpenSRS_Autoloader", "autoload"));

/**
 * OpenSRS autoloader class.
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Autoloader
{
    /**
     * Autoload magic method.
     *
     * This method is automatically called in case you are trying to use a
     * class/interface which hasn't been defined yet. By calling this function
     * the scripting engine is given a last chance to load the class before
     * PHP fails with an error.
     *
     * @param string $class_name The class name to load.
     *
     * @return void
     * @since  1.0
     */
    public static function autoload($class_name)
    {
        preg_match('/^OpenSRS_([a-zA-Z]+)/', $class_name, $matches);

        if (isset($matches[1])) {
            $file_name  = dirname(__FILE__);
            $file_name .= DIRECTORY_SEPARATOR.$matches[1].".php";

            if (is_file($file_name)) {
                include $file_name;
                return;
            }
        }
    }
}