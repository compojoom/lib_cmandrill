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
 * Class CmandrillInternal
 *
 * @since  3.0
 */
class CmandrillInternal
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
}
