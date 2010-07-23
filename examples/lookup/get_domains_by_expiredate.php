<?php
require_once("../config.php");
require_once("../../src/OpenSRS.php");

// Get form variables if submitted
if (isset($_REQUEST['exp_from']) && isset($_REQUEST['exp_to'])) {
    // Instantiate OpenSRS class and set to test mode
    $opensrs = new OpenSRS($user, $api_key);
    $opensrs->testMode(true);
    
    // Call domain->getDomainsByExpiredate()
    try {
        $response = $opensrs->domain()->getDomainsByExpiredate(
            $_REQUEST['exp_from'], 
            $_REQUEST['exp_to'], 
            $_REQUEST['limit'], 
            $_REQUEST['page']
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
    <h3>Action: get_domains_by_expiredate</h3>
    <form method="post">
    <table>
    <tr>
    <td>exp_from</td>
    <td><input type="text" name="exp_from" value="2010-01-01" /></td>
    </tr>
    <tr>
    <td>exp_to</td>
    <td><input type="text" name="exp_to" value="2010-01-31" /></td>
    </tr>
    <tr>
    <td>limit</td>
    <td><input type="text" name="limit" value="40" /></td>
    </tr>
    <tr>
    <td>page</td>
    <td><input type="text" name="page" value="1" /></td>
    </tr>
    <tr>
    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>
    </tr>
    </table>
    </form>
    <?php
}
?>