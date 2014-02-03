<?php

/**
 * TDProject_ERP_Model_Services_Predicates_IsPersonNote
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Predicate.php';
require_once 'TDProject/ERP/Model/Entities/PersonNote.php';
require_once 'TDProject/ERP/Common/ValueObjects/PersonNoteLightValue.php';

/**
 * @category   	TDProject
 * @package    	TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Model_Services_Predicates_IsPersonNote 
	implements TechDivision_Collections_Interfaces_Predicate {

	/**
	 * The LVO to check against.
	 * @var TDProject_ERP_Model_Entities_PersonNote
	 */
	protected $_personAddress = null;
	    
	/**
	 * Passes the LVO to check against.
	 * 
	 * @param TDProject_ERP_Model_Entities_PersonNote $personNote
	 * 		The entity to check against
	 * @return void
	 */
	public function __construct(
	    TDProject_ERP_Model_Entities_PersonNote $personNote) {
	    $this->_personNote = $personNote;
	}
	
	/**
	 * Checks if the person ID of the passed instance is equal
	 * to the internal entity's one.
	 * 
	 * @param TDProject_ERP_Common_ValueObjects_PersonNoteLightValue $lvo
	 * 		The LVO to check
	 * @return boolean TRUE if the person ID's are equal, else FALSE
	 */
	protected function _evaluate(
	    TDProject_ERP_Common_ValueObjects_PersonNoteLightValue $lvo) {
	    // check if the person ID's are equal
	    return $this->_personNote->getPersonIdFk()->equals($lvo->getPersonIdFk());
	}
	
	/**
	 * Checks if the person ID of the passed instance is equal
	 * to the internal entity's one.
	 * 
	 * @param TDProject_ERP_Common_ValueObjects_PersonNoteLightValue $object
	 * 		The LVO to check
	 * @return boolean TRUE if the person ID's are equal, else FALSE
	 * @see TDProject/ERP/Model/Services/Predicates/IsPersonNote#_evaluate(TDProject_ERP_Common_ValueObjects_PersonNoteLightValue $lvo)
	 * @see TechDivision/Collections/Interfaces/Predicate#evaluate($object)
	 */
	public function evaluate($object) 
	{
	    return $this->_evaluate($object);
	}
}