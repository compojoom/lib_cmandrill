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
 * Class CMandrillUrls
 *
 * @since  3.0
 */
class CMandrillUrls
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
	 * Get the 100 most clicked URLs
	 *
	 * @return array the 100 most clicked URLs and their stats
	 *     - return[] object the individual URL stats
	 *         - url string the URL to be tracked
	 *         - sent integer the number of emails that contained the URL
	 *         - clicks integer the number of times the URL has been clicked from a tracked email
	 *         - unique_clicks integer the number of unique emails that have generated clicks for this URL
	 */
	public function getList()
	{
		$params = array();

		return $this->master->call('urls/list', $params);
	}

	/**
	 * Return the 100 most clicked URLs that match the search query given
	 *
	 * @param   string  $q  - a search query
	 *
	 * @return array the 100 most clicked URLs matching the search query
	 *     - return[] object the URL matching the query
	 *         - url string the URL to be tracked
	 *         - sent integer the number of emails that contained the URL
	 *         - clicks integer the number of times the URL has been clicked from a tracked email
	 *         - unique_clicks integer the number of unique emails that have generated clicks for this URL
	 */
	public function search($q)
	{
		$params = array("q" => $q);

		return $this->master->call('urls/search', $params);
	}

	/**
	 * Return the recent history (hourly stats for the last 30 days) for a url
	 *
	 * @param   string  $url  - an existing URL
	 *
	 * @return array the array of history information
	 *     - return[] object the information for a single hour
	 *         - time string the hour as a UTC date string in YYYY-MM-DD HH:MM:SS format
	 *         - sent integer the number of emails that were sent with the URL during the hour
	 *         - clicks integer the number of times the URL was clicked during the hour
	 *         - unique_clicks integer the number of unique clicks generated for emails sent with this URL during the hour
	 */
	public function timeSeries($url)
	{
		$params = array("url" => $url);

		return $this->master->call('urls/time-series', $params);
	}
}
