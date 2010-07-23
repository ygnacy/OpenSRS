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
        // Call domain->renew()
        $response = $opensrs->domain()->renew(
            $_REQUEST['domain'], 
            $_REQUEST['period'],
            $_REQUEST['auto_renew'],
            $_REQUEST['currentexpirationyear'],
            $_REQUEST['handle'],
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
    <h3>Action: renew</h3>
    <form method="post">
    <table>
    <tr>
    <td>domain</td>
    <td><input type="text" name="domain" value="e-noise-test9.com" /></td>
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
    <td>currentexpirationyear</td>
    <td><input type="text" name="currentexpirationyear" value="2010" /> YYYY</td>
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
    <td>affiliate_id</td>
    <td><input type="text" name="affiliate_id" value="" /></td>
    </tr>
    <tr>
    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>
    </tr>
    </table>
    </form>
    <?php
}
?>