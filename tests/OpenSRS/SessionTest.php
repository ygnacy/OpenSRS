<?php
require_once preg_replace("/(.*)tests\/.+/", "$1src/OpenSRS.php", __FILE__);

class OpenSRS_SessionTest extends PHPUnit_Framework_TestCase
{
    private $_user;
    private $_key;
    private $_cache_dir;
    private $_cache_time;
    private $_opensrs;
    private $_session;

    public function setUp()
    {
        $this->_user       = "enoisecom";
        $this->_key        = "0d333d45db07fd7cf396ed262b51427a15fa0b88dc444f318467a8526a49cb0a6a5effa92c9323544f70cedd86cbd9c0fa71671f4ba6f2a9";
        $this->_cache_dir  = null;
        $this->_cache_time = null;

        $this->_opensrs = new OpenSRS(
            $this->_user,
            $this->_key,
            $this->_cache_dir,
            $this->_cache_time
        );

        $this->_opensrs->testMode(true);

        $this->_session = new OpenSRS_Session($this->_opensrs);
    }

    public function tearDown()
    {
        //...
    }

    public function test_quit()
    {
        $cookie = new OpenSRS_Cookie($this->_opensrs);
        $cookie = $cookie->set(
            "e-noise-test9.com",
            "opensrsphp",
            "Passw0rd"
        );

        $this->assertType("string", $cookie);
        $this->assertTrue(strlen($cookie) > 0);

        // Call session->quit()
        $this->assertTrue($this->_opensrs->session()->quit());
    }
}
