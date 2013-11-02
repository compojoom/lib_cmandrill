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
 * Class CMandrillWhitelists
 *
 * @since  3.0
 */
class CmandrillWhitelists
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
	 * Adds an email to your email rejection whitelist. If the address is
	 * currently on your blacklist, that blacklist entry will be removed
	 * automatically.
	 *
	 * @param   string  $email  - an email address to add to the whitelist
	 *
	 * @return object a status object containing the address and the result of the operation
	 *     - email string the email address you provided
	 *     - whether boolean the operation succeeded
	 */
	public function add($email)
	{
		$params = array("email" => $email);

		return $this->master->call('whitelists/add', $params);
	}

	/**
	 * Retrieves your email rejection whitelist. You can provide an email
	 * address or search prefix to limit the results. Returns up to 1000 results.
	 *
	 * @param   string  $email  - an optional email address or prefix to search by
	 *
	 * @return array up to 1000 whitelist entries
	 *     - return[] object the information for each whitelist entry
	 *         - email string the email that is whitelisted
	 *         - detail string a description of why the email was whitelisted
	 *         - created_at string when the email was added to the whitelist
	 */
	public function getList($email = null)
	{
		$params = array("email" => $email);

		return $this->master->call('whitelists/list', $params);
	}

	/**
	 * Removes an email address from the whitelist.
	 *
	 * @param   string  $email  - the email address to remove from the whitelist
	 *
	 * @return object a status object containing the address and whether the deletion succeeded
	 *     - email string the email address that was removed from the blacklist
	 *     - deleted boolean whether the address was deleted successfully
	 */
	public function delete($email)
	{
		$params = array("email" => $email);

		return $this->master->call('whitelists/delete', $params);
	}
}
