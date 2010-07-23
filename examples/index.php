<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>OpenSRS PHP client library examples</title>
</head>
<body>

<h1>OpenSRS PHP client library examples</h1>

<h2>Cookie/Session commands</h2>
<ul>
<li>
<a href="session/delete.php">delete</a> Deletes a cookie.
</li>
<li>
<a href="session/quit.php">quit</a> Cleanly terminates the connection. This
command is required only if your connection method is CBC (crypt type can be
Blowfish or DES).
</li>
<li>
<a href="session/set.php">set</a> Creates a cookie for use in commands where a
cookie is required to access OpenSRS.
</li>
<li>
<a href="session/update.php">update</a> Allows the client to change the domain
associated with the current cookie.
</li>
</ul>

<h2>Lookup commands</h2>
<ul>
<li>
<a href="lookup/belongs_to_rsp.php">belongs_to_rsp</a>: determines whether
domain belongs to the RSP who issued the command.
</li>
<li>
cira_email_pwd: sends CIRA login information to admin contact.
</li>
<li>
<a href="lookup/get_balance.php">get_balance</a>: queries the requester's
account, and returns the total amount of money in the account and the amount
that is allocated to pending transactions.
</li>
<li>
get_ca_blocker_list: checks for any domains blocking the registration of a new
.CA domain.
</li>
<li>
get_deleted_domains: lists domains that have been deleted due to expiration or
request.
</li>
<li>
<a href="lookup/get.php">get (domain)</a>: queries various types of data
associated with a domain.
</li>
<li>
get_domains_contacts: queries contact information for a list of domains.
</li>
<li>
<a href="lookup/get_domains_by_expiredate.php">get_domains_by_expiredate</a>:
queries domains expiring within a date range.
</li>
<li>
<a href="lookup/get_notes.php">get_notes</a>: retrieves the domain notes that
detail the history of the domain, for example, renewals and transfers.
</li>
<li>
get_order_info: queries all information related to an order.
</li>
<li>
get_orders_by_domain: retrieves information about orders placed for a specific
domain.
</li>
<li>
<a href="lookup/get_price.php">get_price</a>: queries the price of a domain.
</li>
<li>
<a href="lookup/lookup_domain.php">lookup_domain</a>: determines the
availability of a domain.
</li>
</ul>

<h2>Provisioning commands</h2>
<ul>
<li>
activate: Activates a parked .DE domain
</li>
<li>
cancel_active_process (.CA order): Cancels an active .CA order.
</li>
<li>
cancel_pending_orders: Cancels orders with a status of pending or declined.
</li>
<li>
<a href="provisioning/modify.php">modify (domain)</a>: Changes information
associated with a domain.
</li>
<li>
name_suggest (domain): Checks whether a name, word, is phrase is available for
registration.
</li>
<li>
process_pending: Processes or cancels pending orders.
</li>
<li>
query_queued_request: Queries the status of a queued request.
</li>
<li>
<a href="provisioning/renew.php">renew (domain)</a>: Renews a domain and allows
you to set the auto-renewal flag on a domain.
</li>
<li>
revoke (domain): Removes the domain at the registry
</li>
<li>
send_CIRA_approval_email: Resends CIRA registration approval email.
</li>
<li>
<a href="provisioning/sw_register.php">sw_register</a>
</li>
<li>
update_all_info: Submits a domain-information update for .AT, .CH, .FR, .IT,
and .NL TLDs
</li>
</ul>

<h2>Transfer Commands</h2>
<ul>
<li>
cancel_transfer: Cancels transfers that are pending owner approval
</li>
<li>
check_transfer: Checks to see if the specified domain can be transferred to
OpenSRS, or from one OpenSRS Reseller to another.
</li>
<li>
get_transfers_away: Lists domains that have been transferred away
</li>
<li>
get_transfers_in: Lists domains that have been transferred in.
</li>
<li>
process_transfer: Creates a new order with the same data as a cancelled order.
</li>
<li>
trade_domain: transfers ownership of a .EU or .BE domain.
</li>
</ul>

<h2>Bulk Changes Commands</h2>
<ul>
<li>
bulk_transfer: transfers several domains at once.
</li>
<li>
submit (bulk_change): changes information associated with a large set of
domains.
</li>
<li>
submit_bulk_change: enable or disable WHOIS Privacy for multiple domains.
</li>
</ul>

<h2>Nameserver Commands</h2>
<ul>
<li>
advanced_update_nameservers: adds or removes nameservers for a domain.
</li>
<li>
create (nameserver): creates a nameserver in the same domain space as the
cookie's domain.
</li>
<li>
delete (nameserver): deletes a nameserver.
</li>
<li>
get (nameserver): queries nameservers that exist in the current user profile.
</li>
<li>
modify (nameserver): modifies a nameserver.
</li>
<li>
registry_add_ns: adds a nameserver to one or all registries to which a Reseller
has access.
</li>
<li>
registry_check_nameserver: Verifies whether a nameserver exists at a particular
registry.
</li>
</ul>

<h2>User Commands</h2>
<ul>
<li>
add (subuser): creates a subuser for a user's account.
</li>
<li>
delete (subuser): deletes a sub-user.
</li>
<li>
get (subuser): queries a domain's sub-user data.
</li>
<li>
get (userinfo): retrieves a user's general information.
</li>
<li>
modify (subuser): modifies a domain's sub-user data.
</li>
</ul>

</body>
</html>
