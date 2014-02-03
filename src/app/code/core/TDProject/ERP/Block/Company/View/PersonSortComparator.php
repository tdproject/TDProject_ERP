<?php

/**
 * TDProject_ERP_Block_Company_View_PersonSortComparator
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Comparator.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the company overview.
 * 
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Block_Company_View_PersonSortComparator 
	implements TechDivision_collections_Interfaces_Comparator {
	
	/**
	 * The person ID's related with the company
	 * @var array
	 */
	protected $_selectedPersons = array();
		
	/**
	 * Initializes the internal array with ID's with the
	 * data from the passed Collection.
	 * 
	 * @param TechDivision_Collections_Interfaces_Collection $selectedPersons
	 * 		Collection with the ID's of the related persons
	 */
	public function __construct(
	    TechDivision_Collections_Interfaces_Collection $selectedPersons) {
		$this->_selectedPersons = $selectedPersons->toArray();
	}
        
	/**
     * (non-PHPdoc)
     * @see TechDivision/Collections/Interfaces/Comparator#compare($o1, $o2)
     */
    public function compare($o1, $o2) {
    	// check if the person ID's are in the array with the related ID's
    	$isPerson1 = in_array(
    	    $o1->getPersonId()->intValue(), $this->_selectedPersons
    	);
    	$isPerson2 = in_array(
    	    $o2->getPersonId()->intValue(), $this->_selectedPersons
    	);
    	// if person 1 IS in array and person 2 NOT
    	if ($isPerson1 && !$isPerson2) {
    		return -1;
    	}
    	// if person 2 IS in array and person 1 NOT
    	if ($isPerson2 && !$isPerson1) {
    		return 1;
    	}
    	// if person 1 AND person 2 are IN the array
    	if ($isPerson1 && $isPerson2) {
    		return 0;
    	}
    }
}