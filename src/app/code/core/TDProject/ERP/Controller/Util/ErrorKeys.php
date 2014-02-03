<?php

/**
 * TDProject_ERP_Controller_Util_ErrorKeys
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Controller_Util_ErrorKeys
{
	/**
	 * Private constructor for marking
	 * the class as utiltiy.
	 *
	 * @return void
	 */
	private final function __construct() { /* Class is a utility class */ }
	
	/**
	 * The key for the system error.
	 * @var string
	 */
	const SYSTEM_ERROR = "systemError";

	/**
	 * The key for a lastname.
	 * @var string
	 */
	const LASTNAME = "lastname";

	/**
	 * The key for a name.
	 * @var string
	 */
	const NAME = "name";

	/**
	 * The key for the city.
	 * @var string
	 */
	const CITY = "city";

	/**
	 * The key for the postcode.
	 * @var string
	 */
	const POSTCODE = "postcode";

	/**
	 * The key for the email.
	 * @var string
	 */
	const EMAIL = "email";

	/**
	 * The key for the subject.
	 * @var string
	 */
	const SUBJECT = "subject";

	/**
	 * The key for the note.
	 * @var string
	 */
	const NOTE = "note";

	/**
	 * The key for the date to remind.
	 * @var string
	 */
	const REMIND_AT = "remindAt";
}