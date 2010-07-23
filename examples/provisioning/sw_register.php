<?php
require_once("../config.php");
require_once("../../src/OpenSRS.php");

// Get form variables if submitted
if (isset($_REQUEST['domain'])) {
    // Pack owner contact details into asoc array
    $owner = new OpenSRS_Contact(array(
       "org_name"    => $_REQUEST['org_name'],
       "first_name"  => $_REQUEST['first_name'],
       "last_name"   => $_REQUEST['last_name'],
       "address1"    => $_REQUEST['address1'],
       "address2"    => $_REQUEST['address2'],
       "address3"    => $_REQUEST['address3'],
       "city"        => $_REQUEST['city'],
       "postal_code" => $_REQUEST['postal_code'],
       "state"       => $_REQUEST['state'],
       "country"     => $_REQUEST['country'],
       "phone"       => $_REQUEST['phone'],
       "fax"         => $_REQUEST['fax'],
       "email"       => $_REQUEST['email'],
       "lang_pref"   => $_REQUEST['lang_pref']
    ));
    
    // Pack contacts into contact_set array
    $contact_set = new OpenSRS_ContactSet(array(
       "owner"   => $owner,
       "admin"   => $owner,
       "billing" => $owner,
       "tech"    => $owner
    ));
    
    // Create name servers array if needed
    if (
       isset($_REQUEST['nameserver_list']) 
       && is_array($_REQUEST['nameserver_list'])
    ) {
        $nameserver_list = array();
        foreach ($_REQUEST['nameserver_list'] as $key=>$value) {
            $array = array();
            $array["sortorder"] = ($key+1);
            $array["name"] = $value;
            //$array["ipaddress"] = gethostbyname($nameserver);
            $nameserver_list[] = $array;
        }
    } else {
        $nameserver_list=null;
    }
    
    
    // Instantiate OpenSRS class and set to test mode
    $opensrs = new OpenSRS($user, $api_key);
    $opensrs->testMode(true);
    
    // Call cookie->set()
    try {
        // Call domain->register()
        $response = $opensrs->domain()->register(
            $_REQUEST['domain'], 
            $_REQUEST['reg_username'], 
            $_REQUEST['reg_password'],
            $_REQUEST['period'],
            $contact_set,
            $_REQUEST['reg_domain'],
            $_REQUEST['auto_renew'],
            $_REQUEST['f_lock_domain'],
            $_REQUEST['f_whois_privacy'],
            $_REQUEST['handle'],
            $_REQUEST['custom_nameservers'],
            $nameserver_list,
            $_REQUEST['custom_tech_contact'],
            $_REQUEST['affiliate_id']
        );
    
        var_dump($response);
        
    } catch (OpenSRS_Exception $e) {
        echo "<pre>";
        echo "OpenSRS_Exception\n";
        echo "Code: ".$e->getCode()."\n";
        echo "Message: ".$e->getMessage();
    }
}
else {
    ?>
    <h2>Object: domain</h2>
    <h3>Action: sw_register</h3>
    <form method="post">
    <fieldset>
    <legend>attributes</legend>
    <table>
    <tr>
    <td>domain</td>
    <td><input type="text" name="domain" value="e-noise-test1.com" /></td>
    </tr>
    <tr>
    <td>reg_domain</td>
    <td><input type="text" name="reg_domain" value="e-noise-test2.com" /></td>
    </tr>
    <tr>
    <td>reg_username</td>
    <td><input type="text" name="reg_username" value="opensrsphp" /></td>
    </tr>
    <tr>
    <td>reg_password</td>
    <td><input type="text" name="reg_password" value="Passw0rd" /></td>
    </tr>
    <tr>
    <td>period</td>
    <td><input type="text" name="period" value="1" /> years</td>
    </tr>
    <tr>
    <td>auto_renew</td>
    <td>
    <select name="auto_renew">
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>f_lock_domain</td>
    <td>
    <select name="f_lock_domain">
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>f_whois_privacy</td>
    <td>
    <select name="f_whois_privacy">
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>handle</td>
    <td>
    <select name="handle">
        <option value="save">save</option>
        <option value="process">process</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>custom_tech_contact</td>
    <td>
    <select name="custom_tech_contact">
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>affiliate_id</td>
    <td><input type="text" name="affiliate_id" value="" /> Optional</td>
    </tr>
    </table>
    </fieldset>
    
    <fieldset>
    <legend>contact_set</legend>
    <table>
    <tr>
    <td>org_name</td>
    <td><input type="text" name="org_name" value="E-noise.com Limited" /></td>
    </tr>
    <tr>
    <td>first_name</td>
    <td><input type="text" name="first_name" value="Luis" /></td>
    </tr>
    <tr>
    <td>last_name</td>
    <td><input type="text" name="last_name" value="Montero" /></td>
    </tr>
    <tr>
    <td>address1</td>
    <td><input type="text" name="address1" value="9C Queens Yard" /></td>
    </tr>
    <tr>
    <td>address2</td>
    <td><input type="text" name="address2" value="White Post Lane" /> Optional</td>
    </tr>
    <tr>
    <td>address3</td>
    <td><input type="text" name="address3" value="" /> Optional</td>
    </tr>
    <tr>
    <td>city</td>
    <td><input type="text" name="city" value="London" /></td>
    </tr>
    <tr>
    <td>postal_code</td>
    <td><input type="text" name="postal_code" value="E9 5EN" /></td>
    </tr>
    <tr>
    <td>state</td>
    <td><input type="text" name="state" value="London" /></td>
    </tr>
    <tr>
    <td>country</td>
    <td><input type="text" name="country" value="GB" /></td>
    </tr>
    <tr>
    <td>phone</td>
    <td><input type="text" name="phone" value="+44.2089853999" /></td>
    </tr>
    <tr>
    <td>fax</td>
    <td><input type="text" name="fax" value="" /> Optional</td>
    </tr>
    <tr>
    <td>email</td>
    <td><input type="text" name="email" value="whois@e-noise.com" /></td>
    </tr>
    <tr>
    <td>lang_pref</td>
    <td><input type="text" name="lang_pref" value="en_GB" /></td>
    </tr>
    </table>
    </fieldset>
    
    <fieldset>
    <legend>nameserver_list</legend>
    <table>
    <tr>
    <td>custom_nameservers</td>
    <td>
    <select name="custom_nameservers">
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>ns1</td>
    <td><input type="text" name="nameserver_list[]" value="" /></td>
    </tr>
    <tr>
    <td>ns2</td>
    <td><input type="text" name="nameserver_list[]" value="" /></td>
    </tr>
    </table>
    </fieldset>
    
    <br />
    <input type="submit" name="submit" value="submit" />
    
    </form>
    <?php
    
    /* tld specific items */
    // .ca
    //$params['tld_specific']['ca']['isa_trademark'] = "";
    //$params['tld_specific']['ca']['legal_type'] = "";
    // .us
    //$params['tld_specific']['us']['category'] = "";
    //$params['tld_specific']['us']['app_purpose'] = "";
}
?>