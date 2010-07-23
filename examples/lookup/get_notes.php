<?php
require_once("../config.php");
require_once("../../src/OpenSRS.php");

// Get form variables if submitted
if (isset($_REQUEST['domain']) && isset($_REQUEST['type'])) {
    // Instantiate OpenSRS class and set to test mode
    $opensrs = new OpenSRS($user, $api_key);
    $opensrs->testMode(true);
    
    // Call domain->getNotes()
    try {
        $response = $opensrs->domain()->getNotes(
            $_REQUEST['domain'], 
            $_REQUEST['type'], 
            $_REQUEST['order_id'], 
            $_REQUEST['transfer_id']
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
    <h3>Action: get_notes</h3>
    <form method="post">
    <table>
    <tr>
    <td>domain</td>
    <td><input type="text" name="domain" value="e-noise-test9.com" /></td>
    </tr>
    <tr>
    <td>type</td>
    <td>
    <select name="type">
        <option value="domain">domain</option>
        <option value="order">order</option>
        <option value="transfer">transfer</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>order_id</td>
    <td><input type="text" name="order_id" value="" /></td>
    </tr>
    <tr>
    <td>transfer_id</td>
    <td><input type="text" name="transfer_id" value="" /></td>
    </tr>
    <tr>
    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>
    </tr>
    </table>
    </form>
    <?php
}
?>