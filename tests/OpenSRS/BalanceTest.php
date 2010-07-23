<?php
require_once preg_replace("/(.*)tests\/.+/", "$1src/OpenSRS.php", __FILE__);

class OpenSRS_BalanceTest extends PHPUnit_Framework_TestCase
{
    private $_user;
    private $_key;
    private $_cache_dir;
    private $_cache_time;
    private $_opensrs;
    private $_balance;

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

        $this->_balance = new OpenSRS_Balance($this->_opensrs);
    }

    public function tearDown()
    {
        //...
    }

    public function test_getBalance()
    {
        $this->assertType("float", $this->_balance->getBalance());
    }
}
