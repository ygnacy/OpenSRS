<?php
/**
 * OpenSRS/Domain.php
 *
 * PHP version 5
 *
 * @category  XMLRPC
 * @package   OpenSRS
 * @author    Lupo Montero <lupo@e-noise.com>
 * @copyright 2010 E-noise.com Limited
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      https://github.com/lupomontero/OpenSRS
 */

/**
 * OpenSRS Domain Class
 *
 * @category XMLRPC
 * @package  OpenSRS
 * @author   Lupo Montero <lupo@e-noise.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     https://github.com/lupomontero/OpenSRS
 * @since    1.0
 */
class OpenSRS_Domain
{
    const EXPIRE_ACTION_AUTO_RENEW          = "auto_renew";
    const EXPIRE_ACTION_LET_EXPIRE          = "let_expire";
    const EXPIRE_ACTION_NORMAL_NOTIFICATION = "normal_notification";

    /**
     * A reference to the calling OpenSRS object
     *
     * @var OpenSRS
     */
    private $_opensrs;

    /**
     * Constructor
     *
     * @param OpenSRS $opensrs An OpenSRS object used to send the requests.
     *
     * @return void
     * @since  1.0
     */
    public function __construct(OpenSRS $opensrs)
    {
        $this->_opensrs = $opensrs;
    }

    /**
     * Check whether a given domain name belogs to reseller.
     *
     * @param string $domain_name The domain name we want to check.
     *
     * @return bool
     * @since  1.0
     */
    public function belongsToRSP($domain_name)
    {
        $request = new OpenSRS_Request(
            "domain",
            "belongs_to_rsp",
            array("domain"=>$domain_name)
        );

        $response = $this->_opensrs->send($request);

        $attr = $response->getAttributes();

        return (bool) $attr["belongs_to_rsp"];
    }

    /**
     * Get domains by expiry date
     *
     * @param string $exp_from The minimum expiry date to filter result set
     * @param string $exp_to   The maximum expiry date to filter result set
     * @param int    $limit    [Optional] The number of entries we want per
     *                         page. Default value is 20.
     * @param int    $page     [Optional] The page number to retrieve. Default
     *                         value is 1.
     *
     * @return array Returns an associative array containing the following
     *               keys:
     *                 - exp_domains (array)
     *                 - page (int)
     *                 - remainder (int)
     *                 - total (int)
     * @since  1.0
     */
    public function getDomainsByExpiredate(
        $exp_from,
        $exp_to,
        $limit=20,
        $page=1
    ) {
        $request = new OpenSRS_Request(
            "domain",
            "get_domains_by_expiredate",
            array(
                "exp_from" => $exp_from,
                "exp_to"   => $exp_to,
                "limit"    => $limit,
                "page"     => $page
            )
        );

        // Send response and get attributes
        $attr = $this->_opensrs->send($request)->getAttributes();

        return array(
            "exp_domains" => $attr["exp_domains"],
            "page"        => (int) $attr["page"],
            "remainder"   => (int) $attr["remainder"],
            "total"       => (int) $attr["total"]
        );
    }

    /**
     * Get domain notes
     *
     * @param string $domain_name The domain name for which to get the notes.
     * @param string $type        [Optional] Either "domain", "order or "
     *                            transfer". Default value is "domain".
     * @param int    $order_id    [Optional] Only required when $type is
     *                            "order".
     * @param int    $transfer_id [Optional] Only required when $type is
     *                            "transfer".
     *
     * @return array Returns an associative array containing the following
     *               keys:
     *                 - notes (array with two keys: 'timestamp' and 'note').
     *                 - page_size (int)
     *                 - page (int)
     *                 - total (int)
     * @since  1.0
     */
    public function getNotes(
        $domain_name,
        $type="domain",
        $order_id=null,
        $transfer_id=null
    ) {
        $request = new OpenSRS_Request(
            "domain",
            "get_notes",
            array(
                "domain"      => $domain_name,
                "type"        => $type,
                "order_id"    => $order_id,
                "transfer_id" => $transfer_id
            )
        );

        // Send response and get attributes
        $attr = $this->_opensrs->send($request)->getAttributes();

        return array(
            "notes"     => $attr["notes"],
            "page_size" => (int) $attr["page_size"],
            "page"      => (int) $attr["page"],
            "total"     => (int) $attr["total"]
        );
    }

    /**
     * Get domain price.
     *
     * @param string $domain_name The domain name for which to get the price
     *
     * @return float
     * @since  1.0
     */
    public function getPrice($domain_name)
    {
        $request = new OpenSRS_Request(
            "domain",
            "get_price",
            array("domain"=>$domain_name)
        );

        $attr = $this->_opensrs->send($request)->getAttributes();

        return (float) $attr["price"];
    }


    /**
     * Get domain info
     *
     * @param string $cookie The cookie used to authorise domain user
     * @param string $type   [Optional] The type of info we want to get.
     *                       Possible values are: admin, all_info, billing,
     *                       ced_info, domain_auth_info, expire_action,
     *                       forwarding_email, list, nameservers, nexus_info,
     *                       owner, rsp_whois_info, status, tech, trademark,
     *                       waiting history, whois_privacy_state,
     *                       xpack_waiting_history, auto_renew_flag. Default
     *                       value is "all_info".
     *
     * @return array
     * @since  1.0
     * @todo   This method needs to be refactored into a few more specialised
     *         ones as the OpenSRS API method could return many different
     *         arrays depending on the value of $type.
     */
    public function get($cookie, $type="all_info")
    {
        $request = new OpenSRS_Request(
            "domain",
            "get",
            array("cookie"=>$cookie, "type"=>$type)
        );

        return $this->_opensrs->send($request)->getAttributes();
    }

    /**
     * Check whether a domain name is registered
     *
     * @param string $domain_name The domain name we want to check
     *
     * @return string Either 'available' or 'taken'.
     * @since  1.0
     */
    public function lookup($domain_name)
    {
        $request = new OpenSRS_Request(
            "domain",
            "lookup",
            array("domain"=>$domain_name)
        );

        $attr = $this->_opensrs->send($request)->getAttributes();

        return $attr["status"];
    }

    /**
     * Register a domain name
     *
     * @param string             $domain_name         The domain to register
     * @param string             $reg_username        The domain username
     * @param string             $reg_password        The domain password
     * @param int                $period              The length of the
     *                                                registration period. Allowed
     *                                                values are 1 � 10, depending
     *                                                on the TLD, that is, not all
     *                                                registries allow for a 1-year
     *                                                registration. The default is
     *                                                2, which is valid for all
     *                                                TLDs.
     * @param OpenSRS_ContactSet $contact_set         A contact set object with the
     *                                                WHOIS contacts for the domain.
     * @param bool               $auto_renew          [Optional] Used to set domain
     *                                                to auto-renew.
     * @param bool               $f_lock_domain       [Optional] Allows you to lock
     *                                                the domain so that it cannot
     *                                                be transferred away. To allow
     *                                                a transfer on a locked domain,
     *                                                the domain must first be
     *                                                unlocked. Even if submitted,
     *                                                this setting is not applied
     *                                                to TLDs where locking is not
     *                                                supported (.CA, .DE, .UK,
     *                                                .CH, .NL, .FR, IT, BE, AT).
     * @param bool               $f_whois_privacy     [Optional] Allows you to
     *                                                enable WHOIS Privacy for new
     *                                                .COM, .NET, .ORG, .INFO, .BIZ,
     *                                                and .NAME registrations.
     * @param string             $handle              [Optional] Accepted values are
     *                                                "process" or "save". Indicates
     *                                                how to process the order. If
     *                                                this parameter is not
     *                                                specified, the default
     *                                                parameter is taken from the
     *                                                RSP's RWI settings.
     * @param bool               $custom_nameservers  [Optional] An indication of
     *                                                whether to use the RSP's
     *                                                default nameservers, or those
     *                                                provided in the 'sw_register'
     *                                                request.
     * @param array              $nameserver_list     [Optional] A list of
     *                                                nameserver pairs, each of
     *                                                which contain a nameserver's
     *                                                name and sort order. (Minimum
     *                                                two required). For allowed
     *                                                values, see "Nameserver pair".
     * @param bool               $custom_tech_contact [Optional] Use custom tech
     *                                                contact?
     * @param int                $affiliate_id        [Optional] Affiliate ID
     *
     * @return int The order ID.
     * @since  1.0
     */
    public function register(
        $domain_name,
        $reg_username,
        $reg_password,
        $period,
        OpenSRS_ContactSet $contact_set,
        $reg_domain=null,
        $auto_renew=false,
        $f_lock_domain=false,
        $f_whois_privacy=false,
        $handle=null,
        $custom_nameservers=false,
        array $nameserver_list=null,
        $custom_tech_contact=false,
        $affiliate_id=null
    ) {
        $attr = array(
            "reg_type"            => "new",
            "domain"              => $domain_name,
            "reg_domain"          => $reg_domain,
            "reg_username"        => $reg_username,
            "reg_password"        => $reg_password,
            "period"              => $period,
            "contact_set"         => $contact_set->toArray(),
            "auto_renew"          => $auto_renew,
            "f_lock_domain"       => $f_lock_domain,
            "f_whois_privacy"     => $f_whois_privacy,
            "custom_tech_contact" => $custom_tech_contact
        );

        if (!is_null($handle) && !empty($handle)) {
            $handle = strtolower(trim((string) $handle));
            if ($handle != "process" && $handle != "save") {
                $msg  = "Accepted values for parameter 'handle' are ";
                $msg .= "'process' or 'save'.";
                throw new OpenSRS_Exception($msg);
            }
            $attr["handle"] = $handle;
        }

        if ($custom_nameservers) {
            if (!is_array($nameserver_list)) {
                $msg = "Parameter 'nameserver_list' must be an array.";
                throw new OpenSRS_Exception($msg);
            }

            $attr["custom_nameservers"] = $custom_nameservers;
            $attr["nameserver_list"]    = $nameserver_list;
        }

        if (!is_null($affiliate_id) && !empty($affiliate_id)) {
            $attr["affiliate_id"] = $affiliate_id;
        }

        $request = new OpenSRS_Request("domain", "sw_register", $attr);

        $attr = $this->_opensrs->send($request)->getAttributes();

        return (int) $attr["id"];
    }

    /**
     * Renew domain name registration
     *
     * @param string $domain_name           The domain name we want to renew.
     * @param int    $period                Period in years to renew domain name.
     * @param bool   $auto_renew            Set domain to autorenew in the
     *                                      future? Default is to FALSE.
     * @param int    $currentexpirationyear The current expiration year.
     * @param string $handle                [Optional] Accepted values are
     *                                      "process" or "save". Indicates how to
     *                                      process the order. If this parameter is
     *                                      not specified, the default parameter is
     *                                      taken from the RSP's RWI settings.
     * @param int    $affiliate_id          [Optional] Affiliate ID if any.
     *
     * @return array An associative array with the following keys:
     *                 - 'admin_email' (string)
     *                 - 'order_id' (int)
     *                 - 'auto_renew' (bool)
     *                 - 'expiration_date' (string)
     * @since  1.0
     */
    public function renew(
        $domain_name,
        $period,
        $auto_renew,
        $currentexpirationyear,
        $handle=null,
        $affiliate_id=null
    ) {
        $request = new OpenSRS_Request(
            "domain",
            "renew",
            array(
                "domain"                => $domain_name,
                "period"                => $period,
                "auto_renew"            => $auto_renew,
                "currentexpirationyear" => $currentexpirationyear,
                "handle"                => $handle,
                "affiliate_id"          => $affiliate_id
            )
        );

        $attr = $this->_opensrs->send($request)->getAttributes();

        return array(
            "admin_email"     => $attr["admin_email"],
            "order_id"        => (int) $attr["order_id"],
            "auto_renew"      => (bool) $attr["auto_renew"],
            "expiration_date" => $attr["registration expiration date"]
        );
    }

    /**
     * Modify domain data.
     *
     * @param bool   $affect_domains   Flag indicating the domains to which to
     *                                 apply the change.
     *
     *                                 0 = change applies only to the specified
     *                                     domain.
     *                                 1 = change applies to all domains linked
     *                                     to this profile.
     *
     * @param string $data             Type of data. Allowed values are:
     *                                 - ced_info— for changes to the .ASIA CED
     *                                   information.
     *                                 - change_ips_tag— for transfers of .UK
     *                                   domains between registrars. The
     *                                   domain's domain tag must be changed to
     *                                   that of the gaining registrar in order
     *                                   to transfer a .UK domain.
     *                                 - contact_info— for contact information
     *                                   changes.
     *                                 - descr— for changes to .DE owner
     *                                   contact.
     *                                 - domain_auth_info— for changes to
     *                                   domain-auth-info.
     *                                 - expire_action— for changes to domain
     *                                   renewal action flags. Requires both
     *                                   auto_renew and let_expire flags to be
     *                                   specified.
     *                                 - forwarding_email— for forwarding
     *                                   feature on .NAME domains (cannot be
     *                                   set if it was missing from the
     *                                   capabilities in the response to the
     *                                   'Get User Info'.).
     *                                 - nexus_info— for changes to the .US
     *                                   nexus information.
     *                                 - parkpage_state— enables or disables
     *                                   the parked pages service for a
     *                                   particular domain.
     *                                 - rsp_whois_info— to control 'RSP Info
     *                                   in Whois' feature.
     *                                 - status— to control the lock state of
     *                                   the domain.
     *                                 - trademark— used for .CA domains to
     *                                   indicate whether the registered owner
     *                                   of the domain name is the legal holder
     *                                   of the trademark for that name.
     *                                 - uk_whois_opt— allows individuals to
     *                                   activate WHOIS opt-out for a .UK
     *                                   domain. The WHOIS opt-out for .UK
     *                                   domains is available only to
     *                                   individuals (not available to
     *                                   organizations). When activated, the
     *                                   individual's personal information is
     *                                   not returned with the WHOIS for their
     *                                   .UK domain.
     *                                 - whois_privacy_state— used to disable
     *                                   or re-enable WHOIS Privacy.
     *                                 - nameserver_list— Deprecated. Use the
     *                                   advanced_update_nameserve rs command
     *                                   instead.
     *                                 - auto_renew— Deprecated. Use the
     *                                   expire_action value instead.
     * @param bool   $all              Required if data = rsp_whois_info
     *                                 Indicates the domains for which the 'RSP
     *                                 Info in Whois' feature is enabled or
     *                                 disabled.
     *
     *                                 0 = change is only applied to the
     *                                     specified domain.
     *                                 1 = rsp_whois_info change applies to all
     *                                     domains in the profile.
     * @param string $contact_set      Required if data = contact_info
     *                                 A hash containing the modified contact
     *                                 information of a specific type:
     *                                 - admin
     *                                 - billing
     *                                 - owner
     *                                 - tech
     * @param string $flag             Required if data = rsp_whois_info
     *                                 Enables or disables the 'RSP Info in
     *                                 Whois' feature. Allowed values are Y or
     *                                 N.
     * @param string $forwarding_email Required if data = forwarding_email
     *                                 For use with .NAME forwarding feature.
     * @param bool   $let_expire       Required if data = expire_action
     *                                 Flag indicating the desired expire
     *                                 status for the domain.
     *                                 0 = normal expiration.
     *                                 1 = domain expires silently.
     *                                 Note: If affect_domains is 1, then all
     *                                 the domains in this profile are set to
     *                                 the expire status specified by the
     *                                 let_expire flag.
     * @param string $org_name         Only used if data = contact_info
     *                                 Organization name.
     *
     * @return array
     * @since  1.0
     * @todo   This method needs to be refactored into a bunch of more
     *         specialised methods as the generic "modify" can take many
     *         different combinations of arguments and possible returns
     *         depending on the data being modified.
     */
    public function modify(
        $affect_domains,
        $data,
        $all=null,
        $contact_set=null,
        $flag=null,
        $forwarding_email=null,
        $let_expire=null,
        $org_name=null
    ) {
        $request = new OpenSRS_Request(
            "domain",
            "modify",
            array(
                "affect_domains"   => $affect_domains,
                "data"             => $data,
                "all"              => $all,
                "contact_set"      => $contact_set,
                "flag"             => $flag,
                "forwarding_email" => $forwarding_email,
                "let_expire"       => $let_expire,
                "org_name"         => $org_name
            )
        );

        return $this->_opensrs->send($request)->getAttributes();
    }

    public function modifyIPSTag()
    {

    }

    public function modifyContactInfo()
    {

    }

    public function modifyAuthInfo()
    {

    }

    public function modifyExpireAction($cookie, $expire_action)
    {
        $actions = array("auto_renew", "let_expire", "normal_notification");
        if (!in_array($expire_action, $actions)) {
            $msg  = "Expire action not recognised. See class constants in ";
            $msg .= get_class($this)."for supported expire actions.";
            throw new InvalidArgumentException($msg);
        }

        // Set auto_renew and let_expire flags depending on expire action
        switch ($expire_action) {
        case "auto_renew" :
            $auto_renew = 1;
            $let_expire = 0;
            break;

        case "let_expire" :
            $auto_renew = 0;
            $let_expire = 1;
            break;

        case "normal_notification" :
            $auto_renew = 0;
            $let_expire = 0;
            break;
        }

        $request = new OpenSRS_Request(
            "domain",
            "modify",
            array(
                "cookie"         => $cookie,
                "affect_domains" => 0,
                "auto_renew"     => $auto_renew,
                "let_expire"     => $let_expire,
                "data"           => "expire_action"
            )
        );

        // If request is sent without exceptions being thrown it means that the
        // command was executed successfully, so we simply return TRUE
        $this->_opensrs->send($request);

        return true;
    }

    public function modifyForwardingEmail()
    {

    }

    public function modifyNexusInfo()
    {

    }

    public function modifyParkpageState()
    {

    }

    public function modifyRspWhoisInfo()
    {

    }

    public function modifyStatus()
    {

    }

    public function modifyTrademark()
    {

    }

    public function modifyUKWhoisOpt()
    {

    }

    public function modifyWhoisPrivacyState()
    {

    }

    public function modifyNameserverList()
    {

    }
}
