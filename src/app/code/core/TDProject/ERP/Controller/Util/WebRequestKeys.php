<?php

/**
 * TDProject_ERP_Controller_Util_WebRequestKeys
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Common/Util/WebRequestKeys.php';

/**
 * @category   	TDProject
 * @package    	TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Controller_Util_WebRequestKeys
	extends TDProject_Common_Util_WebRequestKeys {

	/**
	 * The Request parameter key with the person ID.
	 * @var string
	 */
	const PERSON_ID = "personId";

	/**
	 * The Request parameter key with the person ID as foreign key.
	 * @var string
	 */
	const PERSON_ID_FK = "personIdFk";

	/**
	 * The Request parameter key with the company ID.
	 * @var string
	 */
	const COMPANY_ID = "companyId";

	/**
	 * The Request parameter key with the company ID as foreign key.
	 * @var string
	 */
	const COMPANY_ID_FK = "companyIdFk";

	/**
	 * The Request parameter key with the employee ID's array.
	 * @var string
	 */
	const EMPLOYEES = "employees";

	/**
	 * The Request parameter key with the address ID.
	 * @var string
	 */
	const ADDRESS_ID = "addressId";

	/**
	 * The Request parameter key with the address ID as foreign key.
	 * @var string
	 */
	const ADDRESS_ID_FK = "addressIdFk";

	/**
	 * The Request parameter key with the address type ID.
	 * @var string
	 */
	const ADDRESS_TYPE_ID = "addressTypeId";

	/**
	 * The Request parameter key with the address type ID as foreign key.
	 * @var string
	 */
	const ADDRESS_TYPE_ID_FK = "addressTypeIdFk";

	/**
	 * The Request parameter key with the address ID's array.
	 * @var string
	 */
	const ADDRESS = "address";

	/**
	 * The Request parameter key with the address type ID's array.
	 * @var string
	 */
	const ADDRESS_TYPES = "addressTypes";

	/**
	 * The Request parameter key for a callback method.
	 * @var string
	 */
	const CALLBACK = "__callback";

	/**
	 * The Request parameter key for the Controller method to invoke.
	 * @var string
	 */
	const METHOD = "method";

	/**
	 * The Request parameter key with the note ID.
	 * @var string
	 */
	const NOTE_ID = "noteId";

	/**
	 * The Request parameter key for the person ID's.
	 * @var string
	 */
	const PERSONS = "persons";

	/**
	 * The Request parameter key for the company ID's.
	 * @var string
	 */
	const COMPANIES = "companies";

	/**
	 * The Request parameter key for the note reason.
	 * @var string
	 */
	const REASON = "reason";

	/**
	 * The Request parameter key for the note reasons.
	 * @var string
	 */
	const REASONS = "reasons";

	/**
	 * The Request parameter key for the result of a JSON operation.
	 * @var string
	 */
	const JSON_RESULT = "jsonResult";
}