<?php
require_once preg_replace("/(.*)tests\/.+/", "$1src/OpenSRS.php", __FILE__);

class OpenSRSTest extends PHPUnit_Framework_TestCase
{
    private $_user;
    private $_key;
    private $_cache_dir;
    private $_cache_time;
    private $_opensrs;

    public function setUp()
    {
        $config = parse_ini_file(dirname(__FILE__)."/tests.ini");

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
    }

    public function tearDown()
    {
        //...
    }

    public function test_getHost()
    {
        $this->assertEquals("horizon.opensrs.net", $this->_opensrs->getHost());
    }

    public function test_getKey()
    {
        $this->assertEquals($this->_key, $this->_opensrs->getKey());
    }

    public function test_getUser()
    {
        $this->assertEquals($this->_user, $this->_opensrs->getUser());
    }

    public function test_debug()
    {
        $this->assertFalse($this->_opensrs->debug());
        $this->assertTrue($this->_opensrs->debug(true));
        $this->assertTrue($this->_opensrs->debug());
        $this->assertFalse($this->_opensrs->debug(false));
        $this->assertFalse($this->_opensrs->debug());
    }

    public function test_testMode()
    {
        $this->assertTrue($this->_opensrs->testMode());
        $this->assertEquals("horizon.opensrs.net", $this->_opensrs->getHost());

        $this->assertFalse($this->_opensrs->testMode(false));
        $this->assertEquals("rr-n1-tor.opensrs.net", $this->_opensrs->getHost());

        $this->assertFalse($this->_opensrs->testMode());
        $this->assertEquals("rr-n1-tor.opensrs.net", $this->_opensrs->getHost());

        $this->assertTrue($this->_opensrs->testMode(true));
        $this->assertEquals("horizon.opensrs.net", $this->_opensrs->getHost());

        $this->assertTrue($this->_opensrs->testMode());
        $this->assertEquals("horizon.opensrs.net", $this->_opensrs->getHost());
    }

    public function test_balance()
    {
        $this->assertType("OpenSRS_Balance", $this->_opensrs->balance());
    }

    public function test_cookie()
    {
        $this->assertType("OpenSRS_Cookie", $this->_opensrs->cookie());
    }

    public function test_domain()
    {
        $this->assertType("OpenSRS_Domain", $this->_opensrs->domain());
    }

    public function test_session()
    {
        $this->assertType("OpenSRS_Session", $this->_opensrs->session());
    }

    public function test_send()
    {
        $request = new OpenSRS_Request(
            "domain",
            "belongs_to_rsp",
            array("domain"=>"staticriot.org")
        );

        $response = $this->_opensrs->send($request);

        $this->assertType("OpenSRS_Response", $response);
        $this->assertTrue($response->isSuccess());
        $this->assertEquals(200, $response->getResponseCode());
        $this->assertEquals("Query successful", $response->getResponseText());

        $attr = $response->getAttributes();
        $this->assertType("array", $attr);
        $this->assertArrayHasKey("belongs_to_rsp", $attr);
        $this->assertArrayHasKey("domain_expdate", $attr);
        $this->assertEquals(1, $attr["belongs_to_rsp"]);
        $this->assertEquals("2008-11-20 12:34:57", $attr["domain_expdate"]);
    }

    public function test_sendAndLog()
    {
        $logfile = dirname(__FILE__)."/log";

        if (is_file($logfile)) {
            unlink($logfile);
        }

        $log = new OpenSRS_Log($logfile);
        $this->_opensrs->attach($log);

        $this->_opensrs->debug(true);

        $request = new OpenSRS_Request(
            "domain",
            "belongs_to_rsp",
            array("domain"=>"staticriot.org")
        );

        $this->_opensrs->send($request);

        // Check that messages were written to file
        $file_contents = file_get_contents($logfile);
        $this->assertEquals(1, preg_match('/SENDING REQUEST/', $file_contents));
        $this->assertEquals(1, preg_match('/GOT RESPONSE/', $file_contents));

        if (is_file($logfile)) {
            unlink($logfile);
        }
    }

    public function test_sendFailureWrongUser()
    {
        $this->setExpectedException("OpenSRS_Exception");

        $opensrs = new OpenSRS("aaa", $this->_key);
        $request = new OpenSRS_Request(
            "domain",
            "belongs_to_rsp",
            array("domain"=>"staticriot.org")
        );

        $opensrs->send($request);
    }

    public function test_sendFailureWrongKey()
    {
        $this->setExpectedException("OpenSRS_Exception");

        $opensrs = new OpenSRS($this->_user, "ss");
        $request = new OpenSRS_Request(
            "domain",
            "belongs_to_rsp",
            array("domain"=>"staticriot.org")
        );

        $opensrs->send($request);
    }
}
