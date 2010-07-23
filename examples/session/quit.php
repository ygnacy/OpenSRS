<?php
require_once("../config.php");
require_once("../../src/OpenSRS.php");

// Get form variables if submitted
if (
    isset($_REQUEST['domain']) 
    && isset($_REQUEST['reg_username']) 
    && isset($_REQUEST['reg_password'])
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
        
        // Call session->quit()
        var_dump($opensrs->session()->quit());
        
    } catch (OpenSRS_Exception $e) {
        echo "<pre>";
        echo "OpenSRS_Exception\n";
        echo "Code: ".$e->getCode()."\n";
        echo "Message: ".$e->getMessage();
    }
}
else {
    ?>
    <h2>Object: session</h2>
    <h3>Action: quit</h3>
    <form>
    <table>
    <tr>
    <td>domain</td>
    <td><input type="text" name="domain" value="e-noise-test9.com" /></td>
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
    This will set a cookie using the provided credentials and then quit the 
    session.
    <?php
}
?>