<?php
/**
 * @package    Cmandrill
 * @author     Daniel Dimitrov <daniel@compojoom.com>
 * @date       03.10.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

if (!defined('CMANDRILL_INCLUDED'))
{
	define('CMANDRILL_INCLUDED', '3.0.0');

	// Register the CMandrill autoloader
	require_once __DIR__ . '/autoloader/autoloader.php';
	CMandrillAutoloader::init();
}
