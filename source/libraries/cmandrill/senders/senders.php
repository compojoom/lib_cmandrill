<?php
/**
 * Build on top of the official mandrill API PHP wrapper
 *
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       01.10.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Class CmandrillSenders
 *
 * @since  3.0
 */
class CmandrillSenders
{
	/**
	 * The constructor
	 *
	 * @param   CmandrillQuery  $master  - the mandrill class
	 */
	public function __construct(CmandrillQuery $master)
	{
		$this->master = $master;
	}

	/**
	 * Return the senders that have tried to use this account.
	 *
	 * @return array an array of sender data, one for each sending addresses used by the account
	 *     - return[] object the information on each sending address in the account
	 *         - address string the sender's email address
	 *         - created_at string the date and time that the sender was first seen by Mandrill as a UTC date string in YYYY-MM-DD HH:MM:SS format
	 *         - sent integer the total number of messages sent by this sender
	 *         - hard_bounces integer the total number of hard bounces by messages by this sender
	 *         - soft_bounces integer the total number of soft bounces by messages by this sender
	 *         - rejects integer the total number of rejected messages by this sender
	 *         - complaints integer the total number of spam complaints received for messages by this sender
	 *         - unsubs integer the total number of unsubscribe requests received for messages by this sender
	 *         - opens integer the total number of times messages by this sender have been opened
	 *         - clicks integer the total number of times tracked URLs in messages by this sender have been clicked
	 *         - unique_opens integer the number of unique opens for emails sent for this sender
	 *         - unique_clicks integer the number of unique clicks for emails sent for this sender
	 */
	public function getList()
	{
		$params = array();

		return $this->master->call('senders/list', $params);
	}

	/**
	 * Returns the sender domains that have been added to this account.
	 *
	 * @return array an array of sender domain data, one for each sending domain used by the account
	 *     - return[] object the information on each sending domain for the account
	 *         - domain string the sender domain name
	 *         - created_at string the date and time that the sending domain was first seen as a UTC string in YYYY-MM-DD HH:MM:SS format
	 *         - last_tested_at string when the domain's DNS settings were last tested as a UTC string in YYYY-MM-DD HH:MM:SS format
	 *         - spf object details about the domain's SPF record
	 *             - valid boolean whether the domain's SPF record is valid for use with Mandrill
	 *             - valid_after string when the domain's SPF record will be considered valid for use with Mandrill as a UTC string in
	 *               YYYY-MM-DD HH:MM:SS format. If set, this indicates that the record is valid now, but was previously invalid, and Mandrill will
	 *               wait until the record's TTL elapses to start using it.
	 *             - error string an error describing the spf record, or null if the record is correct
	 *         - dkim object details about the domain's DKIM record
	 *             - valid boolean whether the domain's DKIM record is valid for use with Mandrill
	 *             - valid_after string when the domain's DKIM record will be considered valid for use with Mandrill as a UTC string in
	 *               YYYY-MM-DD HH:MM:SS format. If set, this indicates that the record is valid now, but was previously invalid, and Mandrill will
	 *               wait until the record's TTL elapses to start using it.
	 *             - error string an error describing the DKIM record, or null if the record is correct
	 *         - verified_at string if the domain has been verified, this indicates when that verification occurred as a UTC string in
	 *           YYYY-MM-DD HH:MM:SS format
	 *         - valid_signing boolean whether this domain can be used to authenticate mail, either for itself or as a custom signing domain.
	 *           If this is false but spf and dkim are both valid, you will need to verify the domain before using it to authenticate mail
	 */
	public function domains()
	{
		$params = array();

		return $this->master->call('senders/domains', $params);
	}

	/**
	 * Adds a sender domain to your account. Sender domains are added automatically as you
	 * send, but you can use this call to add them ahead of time.
	 *
	 * @param   string  $domain  - a domain name
	 *
	 * @return object information about the domain
	 *     - domain string the sender domain name
	 *     - created_at string the date and time that the sending domain was first seen as a UTC string in YYYY-MM-DD HH:MM:SS format
	 *     - last_tested_at string when the domain's DNS settings were last tested as a UTC string in YYYY-MM-DD HH:MM:SS format
	 *     - spf object details about the domain's SPF record
	 *         - valid boolean whether the domain's SPF record is valid for use with Mandrill
	 *         - valid_after string when the domain's SPF record will be considered valid for use with Mandrill as a UTC string in
	 *           YYYY-MM-DD HH:MM:SS format. If set, this indicates that the record is valid now, but was previously invalid, and Mandrill will
	 *           wait until the record's TTL elapses to start using it.
	 *         - error string an error describing the spf record, or null if the record is correct
	 *     - dkim object details about the domain's DKIM record
	 *         - valid boolean whether the domain's DKIM record is valid for use with Mandrill
	 *         - valid_after string when the domain's DKIM record will be considered valid for use with Mandrill as a UTC string in
	 *           YYYY-MM-DD HH:MM:SS format. If set, this indicates that the record is valid now, but was previously invalid, and Mandrill will wait
	 *           until the record's TTL elapses to start using it.
	 *         - error string an error describing the DKIM record, or null if the record is correct
	 *     - verified_at string if the domain has been verified, this indicates when that verification occurred as a UTC string in
	 *       YYYY-MM-DD HH:MM:SS format
	 *     - valid_signing boolean whether this domain can be used to authenticate mail, either for itself or as a custom signing domain. If this is
	 *       false but spf and dkim are both valid, you will need to verify the domain before using it to authenticate mail
	 */
	public function addDomain($domain)
	{
		$params = array("domain" => $domain);

		return $this->master->call('senders/add-domain', $params);
	}

	/**
	 * Checks the SPF and DKIM settings for a domain. If you haven't already added this domain to your
	 * account, it will be added automatically.
	 *
	 * @param   string  $domain  - a domain name
	 *
	 * @return object information about the sender domain
	 *     - domain string the sender domain name
	 *     - created_at string the date and time that the sending domain was first seen as a UTC string in YYYY-MM-DD HH:MM:SS format
	 *     - last_tested_at string when the domain's DNS settings were last tested as a UTC string in YYYY-MM-DD HH:MM:SS format
	 *     - spf object details about the domain's SPF record
	 *         - valid boolean whether the domain's SPF record is valid for use with Mandrill
	 *         - valid_after string when the domain's SPF record will be considered valid for use with Mandrill as a UTC string in
	 *           YYYY-MM-DD HH:MM:SS format. If set, this indicates that the record is valid now, but was previously invalid, and Mandrill will wait
	 *           until the record's TTL elapses to start using it.
	 *         - error string an error describing the spf record, or null if the record is correct
	 *     - dkim object details about the domain's DKIM record
	 *         - valid boolean whether the domain's DKIM record is valid for use with Mandrill
	 *         - valid_after string when the domain's DKIM record will be considered valid for use with Mandrill as a UTC string in
	 *           YYYY-MM-DD HH:MM:SS format. If set, this indicates that the record is valid now, but was previously invalid, and Mandrill will wait
	 *           until the record's TTL elapses to start using it.
	 *         - error string an error describing the DKIM record, or null if the record is correct
	 *     - verified_at string if the domain has been verified, this indicates when that verification occurred as a UTC string in
	 *       YYYY-MM-DD HH:MM:SS format
	 *     - valid_signing boolean whether this domain can be used to authenticate mail, either for itself or as a custom signing domain. If this is
	 *       false but spf and dkim are both valid, you will need to verify the domain before using it to authenticate mail
	 */
	public function checkDomain($domain)
	{
		$params = array("domain" => $domain);

		return $this->master->call('senders/check-domain', $params);
	}

	/**
	 * Sends a verification email in order to verify ownership of a domain.
	 * Domain verification is an optional step to confirm ownership of a domain. Once a
	 * domain has been verified in a Mandrill account, other accounts may not have their
	 * messages signed by that domain unless they also verify the domain. This prevents
	 * other Mandrill accounts from sending mail signed by your domain.
	 *
	 * @param   string  $domain   - a domain name at which you can receive email
	 * @param   string  $mailbox  - a mailbox at the domain where the verification email should be sent
	 *
	 * @return object information about the verification that was sent
	 *     - status string "sent" indicates that the verification has been sent, "already_verified" indicates that the domain has already been
	 *       verified with your account
	 *     - domain string the domain name you provided
	 *     - email string the email address the verification email was sent to
	 */
	public function verifyDomain($domain, $mailbox)
	{
		$params = array("domain" => $domain, "mailbox" => $mailbox);

		return $this->master->call('senders/verify-domain', $params);
	}

	/**
	 * Return more detailed information about a single sender, including aggregates of recent stats
	 *
	 * @param   string  $address  - the email address of the sender
	 *
	 * @return object the detailed information on the sender
	 *     - address string the sender's email address
	 *     - created_at string the date and time that the sender was first seen by Mandrill as a UTC date string in YYYY-MM-DD HH:MM:SS format
	 *     - sent integer the total number of messages sent by this sender
	 *     - hard_bounces integer the total number of hard bounces by messages by this sender
	 *     - soft_bounces integer the total number of soft bounces by messages by this sender
	 *     - rejects integer the total number of rejected messages by this sender
	 *     - complaints integer the total number of spam complaints received for messages by this sender
	 *     - unsubs integer the total number of unsubscribe requests received for messages by this sender
	 *     - opens integer the total number of times messages by this sender have been opened
	 *     - clicks integer the total number of times tracked URLs in messages by this sender have been clicked
	 *     - stats object an aggregate summary of the sender's sending stats
	 *         - today object stats for this sender so far today
	 *             - sent integer the number of emails sent for this sender so far today
	 *             - hard_bounces integer the number of emails hard bounced for this sender so far today
	 *             - soft_bounces integer the number of emails soft bounced for this sender so far today
	 *             - rejects integer the number of emails rejected for sending this sender so far today
	 *             - complaints integer the number of spam complaints for this sender so far today
	 *             - unsubs integer the number of unsubscribes for this sender so far today
	 *             - opens integer the number of times emails have been opened for this sender so far today
	 *             - unique_opens integer the number of unique opens for emails sent for this sender so far today
	 *             - clicks integer the number of URLs that have been clicked for this sender so far today
	 *             - unique_clicks integer the number of unique clicks for emails sent for this sender so far today
	 *         - last_7_days object stats for this sender in the last 7 days
	 *             - sent integer the number of emails sent for this sender in the last 7 days
	 *             - hard_bounces integer the number of emails hard bounced for this sender in the last 7 days
	 *             - soft_bounces integer the number of emails soft bounced for this sender in the last 7 days
	 *             - rejects integer the number of emails rejected for sending this sender in the last 7 days
	 *             - complaints integer the number of spam complaints for this sender in the last 7 days
	 *             - unsubs integer the number of unsubscribes for this sender in the last 7 days
	 *             - opens integer the number of times emails have been opened for this sender in the last 7 days
	 *             - unique_opens integer the number of unique opens for emails sent for this sender in the last 7 days
	 *             - clicks integer the number of URLs that have been clicked for this sender in the last 7 days
	 *             - unique_clicks integer the number of unique clicks for emails sent for this sender in the last 7 days
	 *         - last_30_days object stats for this sender in the last 30 days
	 *             - sent integer the number of emails sent for this sender in the last 30 days
	 *             - hard_bounces integer the number of emails hard bounced for this sender in the last 30 days
	 *             - soft_bounces integer the number of emails soft bounced for this sender in the last 30 days
	 *             - rejects integer the number of emails rejected for sending this sender in the last 30 days
	 *             - complaints integer the number of spam complaints for this sender in the last 30 days
	 *             - unsubs integer the number of unsubscribes for this sender in the last 30 days
	 *             - opens integer the number of times emails have been opened for this sender in the last 30 days
	 *             - unique_opens integer the number of unique opens for emails sent for this sender in the last 30 days
	 *             - clicks integer the number of URLs that have been clicked for this sender in the last 30 days
	 *             - unique_clicks integer the number of unique clicks for emails sent for this sender in the last 30 days
	 *         - last_60_days object stats for this sender in the last 60 days
	 *             - sent integer the number of emails sent for this sender in the last 60 days
	 *             - hard_bounces integer the number of emails hard bounced for this sender in the last 60 days
	 *             - soft_bounces integer the number of emails soft bounced for this sender in the last 60 days
	 *             - rejects integer the number of emails rejected for sending this sender in the last 60 days
	 *             - complaints integer the number of spam complaints for this sender in the last 60 days
	 *             - unsubs integer the number of unsubscribes for this sender in the last 60 days
	 *             - opens integer the number of times emails have been opened for this sender in the last 60 days
	 *             - unique_opens integer the number of unique opens for emails sent for this sender in the last 60 days
	 *             - clicks integer the number of URLs that have been clicked for this sender in the last 60 days
	 *             - unique_clicks integer the number of unique clicks for emails sent for this sender in the last 60 days
	 *         - last_90_days object stats for this sender in the last 90 days
	 *             - sent integer the number of emails sent for this sender in the last 90 days
	 *             - hard_bounces integer the number of emails hard bounced for this sender in the last 90 days
	 *             - soft_bounces integer the number of emails soft bounced for this sender in the last 90 days
	 *             - rejects integer the number of emails rejected for sending this sender in the last 90 days
	 *             - complaints integer the number of spam complaints for this sender in the last 90 days
	 *             - unsubs integer the number of unsubscribes for this sender in the last 90 days
	 *             - opens integer the number of times emails have been opened for this sender in the last 90 days
	 *             - unique_opens integer the number of unique opens for emails sent for this sender in the last 90 days
	 *             - clicks integer the number of URLs that have been clicked for this sender in the last 90 days
	 *             - unique_clicks integer the number of unique clicks for emails sent for this sender in the last 90 days
	 */
	public function info($address)
	{
		$params = array("address" => $address);

		return $this->master->call('senders/info', $params);
	}

	/**
	 * Return the recent history (hourly stats for the last 30 days) for a sender
	 *
	 * @param   string  $address  - the email address of the sender
	 *
	 * @return array the array of history information
	 *     - return[] object the stats for a single hour
	 *         - time string the hour as a UTC date string in YYYY-MM-DD HH:MM:SS format
	 *         - sent integer the number of emails that were sent during the hour
	 *         - hard_bounces integer the number of emails that hard bounced during the hour
	 *         - soft_bounces integer the number of emails that soft bounced during the hour
	 *         - rejects integer the number of emails that were rejected during the hour
	 *         - complaints integer the number of spam complaints received during the hour
	 *         - opens integer the number of emails opened during the hour
	 *         - unique_opens integer the number of unique opens generated by messages sent during the hour
	 *         - clicks integer the number of tracked URLs clicked during the hour
	 *         - unique_clicks integer the number of unique clicks generated by messages sent during the hour
	 */
	public function timeSeries($address)
	{
		$params = array("address" => $address);

		return $this->master->call('senders/time-series', $params);
	}
}
