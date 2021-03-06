<?php
require_once("../config.php");
require_once("../../src/OpenSRS.php");

// Get form variables if submitted
if (isset($_REQUEST['domain'])) {
    // Instantiate OpenSRS class and set to test mode
    $opensrs = new OpenSRS($user, $api_key);
    $opensrs->testMode(true);
    
    // Call cookie->set()
    try {
        var_dump($opensrs->domain()->lookup($_REQUEST['domain']));
        
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
    <h3>Action: lookup</h3>
    <form>
    <table>
    <tr>
    <td>domain</td>
    <td><input type="text" name="domain" value="e-noise-test9.com" /></td>
    </tr>
    <tr>
    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>
    </tr>
    </table>
    </form>
    <?php
}
?>