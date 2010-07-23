<?php
require_once("../config.php");
require_once("../../src/OpenSRS.php");

// Get form variables if submitted
if (
    isset($_REQUEST['domain']) 
    && isset($_REQUEST['reg_username']) 
    && isset($_REQUEST['reg_password']) 
    && isset($_REQUEST['domain_new'])
) {
    // Instantiate OpenSRS class and set to test mode
    $opensrs = new OpenSRS($user, $api_key);
    $opensrs->testMode(true);
    
    // Call cookie->set()
    try {
        $cookie = $opensrs->cookie()->set(
            $_REQUEST['domain'], 
            $_REQUEST['reg_username'], 
            $_REQUEST['reg_password']
        );
        
        // Call cookie->update()
        $response = $opensrs->cookie()->update(
            $cookie, 
            $_REQUEST['domain'], 
            $_REQUEST['domain_new'], 
            $_REQUEST['reg_username'], 
            $_REQUEST['reg_password']
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
    <h2>Object: cookie</h2>
    <h3>Action: update</h3>
    <form>
    <table>
    <tr>
    <td>domain</td>
    <td><input type="text" name="domain" value="e-noise-test9.com" /></td>
    </tr>
    <tr>
    <td>domain_new</td>
    <td><input type="text" name="domain_new" value="e-noise-test1.com" /></td>
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
    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>
    </tr>
    </table>
    </form>
    This will set a cookie using the provided credentials and then update 
    cookie using domain_new.
    <?php
}
?>