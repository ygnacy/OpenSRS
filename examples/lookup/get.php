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
        
        // Call domain->get()
        $response = $opensrs->domain()->get($cookie, $_REQUEST['type']);
    
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
    <h3>Action: get</h3>
    <form method="post">
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
    <td>type</td>
    <td>
    <select name="type">
        <option value="admin">admin</option>
        <option value="all_info">all_info</option>
        <option value="billing">billing</option>
        <option value="ced_info">ced_info</option>
        <option value="domain_auth_info">domain_auth_info</option>
        <option value="expire_action">expire_action</option>
        <option value="forwarding_email">forwarding_email</option>
        <option value="list">list</option>
        <option value="nameservers">nameservers</option>
        <option value="nexus_info">nexus_info</option>
        <option value="owner">owner</option>
        <option value="rsp_whois_info">rsp_whois_info</option>
        <option value="status">status</option>
        <option value="tech">tech</option>
        <option value="trademark">trademark</option>
        <option value="waiting history">waiting history</option>
        <option value="whois_privacy_state">whois_privacy_state</option>
        <option value="xpack_waiting_history">xpack_waiting_history</option>
        <option value="auto_renew_flag">auto_renew_flag</option>
    </select>
    </td>
    </tr>
    <tr>
    <td colspan="2"><input type="submit" name="submit" value="submit" /></td>
    </tr>
    </table>
    </form>
    <?php
}
?>