<?php
/**
 * OpenSRS/Log.php
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
 * OpenSRS Log Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Log implements SplObserver
{
    /**
     * Absolute path to log file on disk.
     *
     * @var string
     */
    private $_filename;

    /**
     * Constructor
     *
     * @param string $filename Absolute path to log file on disk.
     *
     * @return void
     * @since  1.0
     */
    public function __construct($filename)
    {
        $filename = trim($filename);

        if (!is_file($filename) && !touch($filename)) {
            $msg = "Could not create log file.";
            throw new RuntimeException($msg);
        }

        if (!is_writable($filename)) {
            $msg = "Log file is not writable.";
            throw new RuntimeException($msg);
        }

        $this->_filename = $filename;
    }

    /**
     * Handle updates issued by observed subjects.
     *
     * @param SplSubject $subject Instance of observed subject.
     *
     * @return void
     * @since  1.0
     */
    public function update(SplSubject $subject)
    {
        // Get last message
        $msg = $subject->getLastMessage();

        // Write message to file
        file_put_contents($this->_filename, $msg."\n\n", FILE_APPEND);
    }
}
