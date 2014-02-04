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
 * Class CmandrillQuery
 *
 * @since  3.0
 */
class CmandrillQuery
{
	public $apikey;

	public $ch;

	public $root;

	public $debug = false;

	public static $error_map = array(
		"ValidationError" => "CMandrillExceptionsValidation",
		"Invalid_Key" => "CMandrillExceptionsInvalidKey",
		"PaymentRequired" => "CMandrillExceptionsPaymentRequired",
		"Unknown_Subaccount" => "CMandrillExceptionsPaymentRequired",
		"Unknown_Template" => "CMandrillExceptionsUnknownTemplate",
		"ServiceUnavailable" => "CMandrillExceptionsUnknownTemplate",
		"Unknown_Message" => "CMandrillExceptionsUnknowMessage",
		"Invalid_Tag_Name" => "CMandrillExceptionsInvalidTagname",
		"Invalid_Reject" => "CMandrillExceptionsInvalidReject",
		"Unknown_Sender" => "CMandrillExceptionsUnknownSender",
		"Unknown_Url" => "CMandrillExceptionsUnknownUrl",
		"Invalid_Template" => "CMandrillExceptionsInvalidTemplate",
		"Unknown_Webhook" => "CMandrillExceptionsUnknownWebhook",
		"Unknown_InboundDomain" => "CMandrillExceptionsUnknowInbounddomain",
		"Unknown_Export" => "CMandrillExceptionsUnknownExport",
		"IP_ProvisionLimit" => "CMandrillExceptionsIpProvisionlimit",
		"Unknown_Pool" => "CMandrillExceptionsUnknownPool",
		"Unknown_IP" => "CMandrillExceptionsUnknownIp",
		"Invalid_EmptyDefaultPool" => "CMandrillExceptionsInvalidEmptydefaultpool",
		"Invalid_DeleteDefaultPool" => "CMandrillExceptionsInvalidDeleteDefaultpool",
		"Invalid_DeleteNonEmptyPool" => "CMandrillExceptionsInvalidNonemptypool"
	);

	/**
	 * The Constructor
	 *
	 * @param   string  $apikey  - the API key for Mandrill
	 * @param   bool    $ssl     - true if we should use ssl url
	 * @param   bool    $cache   - true if we should cache the response
	 *
	 * @throws CMandrillExceptionsError
	 * @internal param array $options - config options
	 *
	 * @internal param bool $ssl - true if we should use https uri
	 */
	public function __construct($apikey = null, $ssl = true, $cache = false)
	{
		if (!$apikey)
		{
			$apikey = getenv('MANDRILL_APIKEY');
		}

		if (!$apikey)
		{
			$apikey = $this->readConfigs();
		}

		if (!$apikey)
		{
			throw new CMandrillExceptionsError('You must provide a Mandrill API key');
		}

		$this->apikey = $apikey;

		$this->root = $this->setRoot($ssl);
		$this->cache = $cache;

		$this->templates = new CmandrillTemplates($this);
		$this->exports = new CmandrillExports($this);
		$this->users = new CmandrillUsers($this);
		$this->rejects = new CmandrillRejects($this);
		$this->inbound = new CmandrillInbound($this);
		$this->tags = new CmandrillTags($this);
		$this->messages = new CmandrillMessages($this);
		$this->whitelists = new CmandrillWhitelists($this);
		$this->ips = new CmandrillIps($this);
		$this->internal = new CmandrillInternal($this);
		$this->subaccounts = new CmandrillSubaccounts($this);
		$this->urls = new CmandrillUrls($this);
		$this->webhooks = new CmandrillWebhooks($this);
		$this->senders = new CmandrillSenders($this);
	}

	/**
	 * Calls the mandrill API
	 *
	 * @param   string  $url     - the url to call
	 * @param   object  $params  - the params
	 *
	 * @return mixed
	 *
	 * @throws CMandrillExceptionsError
	 * @throws mixed
	 * @throws CMandrillExceptionsHttpError
	 */
	public function call($url, $params)
	{
		$result = false;
		$params['key'] = $this->apikey;
		$params = json_encode($params);

		// Cache only if requested
		if ($this->cache)
		{
			// Enable caching
			$cacheObj = JFactory::getCache('lib_cmandrill', 'output');
			$cacheObj->setCaching(true);
			$id = md5($url.$params);
			$result = $cacheObj->get($id);
		}

		// So have we already cached the response?
		if (!$result)
		{
			$this->ch = $ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, 'lib_cmandrill-PHP/1.0.0');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_TIMEOUT, 600);

			curl_setopt($ch, CURLOPT_URL, $this->root . $url . '.json');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);

			$response_body = curl_exec($ch);
			$info = curl_getinfo($ch);

			if (curl_error($ch))
			{
				throw new CMandrillExceptionsHttpError("API call to $url failed: " . curl_error($ch));
			}

			curl_close($this->ch);

			$result = json_decode($response_body);

			if ($result === null)
			{
				throw new CMandrillExceptionsError('We were unable to decode the JSON response from the Mandrill API: ' . $response_body);
			}

			if (floor($info['http_code'] / 100) >= 4)
			{
				throw $this->castError($result);
			}
		}

		if ($this->cache)
		{
			$cacheObj->store($result, $id);
		}

		return $result;
	}

	/**
	 * Gets the API url
	 *
	 * @param   bool  $ssl  - should we use https address
	 *
	 * @return string
	 */
	private static function setRoot($ssl)
	{
		$scheme = 'http';

		if ($ssl)
		{
			$scheme = 'https';
		}

		$url = $scheme . '://mandrillapp.com/api/1.0/';

		return $url;
	}

	/**
	 * Read Mandrills config
	 *
	 * @return bool|string
	 */
	public function readConfigs()
	{
		$paths = array('~/.mandrill.key', '/etc/mandrill.key');

		foreach ($paths as $path)
		{
			if (file_exists($path))
			{
				$apikey = trim(file_get_contents($path));

				if ($apikey)
				{
					return $apikey;
				}
			}
		}

		return false;
	}

	/**
	 * Casts an error to the appropriate Exception
	 *
	 * @param   array  $result  - the result
	 *
	 * @return mixed
	 *
	 * @throws CMandrillExceptionsError
	 */
	public function castError($result)
	{
		if ($result->status !== 'error' || !$result->name)
		{
			throw new CMandrillExceptionsError('We received an unexpected error: ' . json_encode($result));
		}

		$class = (isset(self::$error_map[$result->name])) ? self::$error_map[$result->name] : 'Mandrill_Error';

		return new $class($result->message, $result->code);
	}
}
