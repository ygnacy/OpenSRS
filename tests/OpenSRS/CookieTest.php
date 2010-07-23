<?php
require_once preg_replace("/(.*)tests\/.+/", "$1src/OpenSRS.php", __FILE__);

class OpenSRS_CookieTest extends PHPUnit_Framework_TestCase
{
    private $_user;
    private $_key;
    private $_cache_dir;
    private $_cache_time;
    private $_opensrs;
    private $_cookie;

    public function setUp()
    {
        $ini = preg_replace("/(.*tests\/).+/", "$1tests.ini", __FILE__);
        $config = parse_ini_file($ini);

        $this->_user       = $config["user"];
        $this->_key        = $config["test_key"];
        $this->_cache_dir  = null;
        $this->_cache_time = null;

        $this->_opensrs = new OpenSRS(
            $this->_user,
            $this->_key,
            $this->_cache_dir,
            $this->_cache_time
        );

        $this->_opensrs->testMode(true);

        $this->_cookie = new OpenSRS_Cookie($this->_opensrs);
    }

    public function tearDown()
    {
        //...
    }

    public function test_set()
    {
        $cookie = $this->_cookie->set(
            "e-noise-test9.com",
            "opensrsphp",
            "Passw0rd"
        );

        $this->assertType("string", $cookie);
        $this->assertTrue(strlen($cookie) > 0);
    }

    public function test_delete()
    {
        $cookie = $this->_cookie->set(
            "e-noise-test9.com",
            "opensrsphp",
            "Passw0rd"
        );

        // Call cookie->delete()
        $this->assertTrue($this->_cookie->delete($cookie));
    }

    public function test_update()
    {
        $cookie = $this->_cookie->set(
            "e-noise-test9.com",
            "opensrsphp",
            "Passw0rd"
        );

        $this->assertType("string", $cookie);
        $this->assertTrue(strlen($cookie) > 0);

        // Call cookie->update()
        $new_cookie = $this->_cookie->update(
            $cookie,
            "e-noise-test9.com",
            "e-noise-test1.com",
            "opensrsphp",
            "Passw0rd"
        );

        $this->assertType("string", $new_cookie);
        $this->assertTrue(strlen($new_cookie) > 0);
    }
}
