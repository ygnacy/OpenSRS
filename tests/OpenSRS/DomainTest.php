<?php
require_once preg_replace("/(.*)tests\/.+/", "$1src/OpenSRS.php", __FILE__);

class OpenSRS_DomainTest extends PHPUnit_Framework_TestCase
{
    private $_user;
    private $_key;
    private $_cache_dir;
    private $_cache_time;
    private $_opensrs;
    private $_domain;

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

        $this->_domain = new OpenSRS_Domain($this->_opensrs);
    }

    public function tearDown()
    {
        //...
    }

    public function test_belongsToRSP()
    {
        $this->assertTrue($this->_domain->belongsToRSP("staticriot.org"));
    }

    public function test_getDomainsByExpiredate()
    {
        $response = $this->_domain->getDomainsByExpiredate(
            "2010-01-01",
            "2010-01-31",
            40,
            1
        );

        $this->assertType("array", $response);
        $this->assertArrayHasKey("exp_domains", $response);
        $this->assertType("array", $response["exp_domains"]);
        $this->assertArrayHasKey("page", $response);
        $this->assertType("int", $response["page"]);
        $this->assertArrayHasKey("remainder", $response);
        $this->assertType("int", $response["remainder"]);
        $this->assertArrayHasKey("total", $response);
        $this->assertType("int", $response["total"]);
    }

    public function test_getNotes()
    {
        $response = $this->_domain->getNotes(
            "e-noise-test9.com",
            "domain"
        );

        $this->assertType("array", $response);
        $this->assertArrayHasKey("notes", $response);
        $this->assertType("array", $response["notes"]);
        $this->assertType("array", $response["notes"][0]);
        $this->assertArrayHasKey("timestamp", $response["notes"][0]);
        $this->assertArrayHasKey("note", $response["notes"][0]);
        $this->assertArrayHasKey("page_size", $response);
        $this->assertType("int", $response["page_size"]);
        $this->assertArrayHasKey("page", $response);
        $this->assertType("int", $response["page"]);
        $this->assertArrayHasKey("total", $response);
        $this->assertType("int", $response["total"]);
    }

    public function test_getPrice()
    {
        $price = $this->_domain->getPrice("e-noise-test9.com");
        $this->assertType("float", $price);
    }

    public function test_get()
    {
        $cookie = $this->_opensrs->cookie()->set(
            "e-noise-test9.com",
            "opensrsphp",
            "Passw0rd"
        );

        $response = $this->_domain->get($cookie, "all_info");

        $this->assertType("array", $response);
    }

    public function test_lookupAvailable()
    {
        $status = $this->_domain->lookup("e-noise-test999.com");

        $this->assertEquals("available", $status);
    }

    public function test_lookupTaken()
    {
        $status = $this->_domain->lookup("e-noise-test9.com");

        $this->assertEquals("taken", $status);
    }

    public function test_register()
    {
        // Pack owner contact details into asoc array
        $owner = new OpenSRS_Contact(array(
           "org_name"    => "Some org",
           "first_name"  => "Lupo",
           "last_name"   => "Montero",
           "address1"    => "Some address",
           "address2"    => "Somewhere",
           "address3"    => "",
           "city"        => "London",
           "postal_code" => "E9 5EN",
           "state"       => "England",
           "country"     => "GB",
           "phone"       => "02089853999",
           "fax"         => "",
           "email"       => "lupo@e-noise.com",
           "lang_pref"   => "en_GB"
        ));

        // Pack contacts into contact_set array
        $contact_set = new OpenSRS_ContactSet(array(
           "owner"   => $owner,
           "admin"   => $owner,
           "billing" => $owner,
           "tech"    => $owner
        ));

        // Create name servers array
        $nameserver_list = array(
            array("sortorder"=>1, "name"=>"ns.mainnameserver.com"),
            array("sortorder"=>2, "name"=>"ns2.mainnameserver.com")
        );

        // Call domain->register()
        $response = $this->_domain->register(
            "e-noise-test11111.com",
            "opensrsphp",
            "Passw0rd",
            "1",
            $contact_set,
            "e-noise-test9.com",
            false,
            true,
            true,
            "save",
            true,
            $nameserver_list,
            false,
            ""
        );

        $this->assertType("int", $response);
        $this->assertTrue($response > 0);
    }

    public function test_registerTaken()
    {
        $this->setExpectedException("OpenSRS_Exception");

        // Pack owner contact details into asoc array
        $owner = new OpenSRS_Contact(array(
           "org_name"    => "Some org",
           "first_name"  => "Lupo",
           "last_name"   => "Montero",
           "address1"    => "Some address",
           "address2"    => "Somewhere",
           "address3"    => "",
           "city"        => "London",
           "postal_code" => "E9 5EN",
           "state"       => "England",
           "country"     => "GB",
           "phone"       => "02089853999",
           "fax"         => "",
           "email"       => "lupo@e-noise.com",
           "lang_pref"   => "en_GB"
        ));

        // Pack contacts into contact_set array
        $contact_set = new OpenSRS_ContactSet(array(
           "owner"   => $owner,
           "admin"   => $owner,
           "billing" => $owner,
           "tech"    => $owner
        ));

        // Create name servers array
        $nameserver_list = array(
            array("sortorder"=>1, "name"=>"ns.mainnameserver.com"),
            array("sortorder"=>2, "name"=>"ns2.mainnameserver.com")
        );

        // Call domain->register()
        $response = $this->_domain->register(
            "e-noise-test9.com",
            "opensrsphp",
            "Passw0rd",
            "1",
            $contact_set,
            null,
            false,
            true,
            true,
            "save",
            true,
            $nameserver_list,
            false,
            ""
        );
    }

    public function test_renew()
    {
        $response = $this->_domain->renew("e-noise-test9.com", 1, false, 2010);

        $this->assertType("array", $response);
        $this->assertArrayHasKey("admin_email", $response);
        $this->assertType("string", $response["admin_email"]);
        $this->assertArrayHasKey("order_id", $response);
        $this->assertType("int", $response["order_id"]);
        $this->assertArrayHasKey("auto_renew", $response);
        $this->assertType("bool", $response["auto_renew"]);
        $this->assertArrayHasKey("expiration_date", $response);
        $this->assertType("string", $response["expiration_date"]);
    }

    public function test_modify()
    {

    }

    public function test_modifyExpireActionAutoRenew()
    {
        $cookie = $this->_opensrs->cookie()->set(
            "e-noise-test9.com",
            "opensrsphp",
            "Passw0rd"
        );

        $response = $this->_domain->modifyExpireAction(
            $cookie,
            OpenSRS_Domain::EXPIRE_ACTION_AUTO_RENEW
        );

        $this->assertTrue($response);
    }

    public function test_modifyExpireActionLetExpire()
    {
        $cookie = $this->_opensrs->cookie()->set(
            "e-noise-test9.com",
            "opensrsphp",
            "Passw0rd"
        );

        $response = $this->_domain->modifyExpireAction(
            $cookie,
            OpenSRS_Domain::EXPIRE_ACTION_LET_EXPIRE
        );

        $this->assertTrue($response);
    }
}
