<?php

/**
 * TDProject_ERP_Block_Person_View_AddressSortComparator
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
class TDProject_ERP_Block_Person_View_AddressSortComparator 
	implements TechDivision_Collections_Interfaces_Comparator {
	
	/**
	 * The address ID's related with the person
	 * @var array
	 */
	protected $_selectedAddresses = array();
		
	/**
	 * Initializes the internal array with ID's with the
	 * data from the passed Collection.
	 * 
	 * @param TechDivision_Collections_Interfaces_Collection $selectedAddresses
	 * 		Collection with the ID's of the related addresses
	 */
	public function __construct(
	    TechDivision_Collections_Interfaces_Collection $selectedAddresses) {
		$this->_selectedAddresses = $selectedAddresses->toArray();
	}
        
	/**
     * (non-PHPdoc)
     * @see TechDivision/Collections/Interfaces/Comparator#compare($o1, $o2)
     */
    public function compare($o1, $o2) {
    	// check if the address ID's are in the array with the related ID's
    	$isAddress1 = in_array(
    	    $o1->getAddressId()->intValue(), $this->_selectedAddresses
    	);
    	$isAddress2 = in_array(
    	    $o2->getAddressId()->intValue(), $this->_selectedAddresses
    	);
    	// if address 1 IS in array and address 2 NOT
    	if ($isAddress1 && !$isAddress2) {
    		return -1;
    	}
    	// if address 2 IS in array and address 1 NOT
    	if ($isAddress2 && !$isAddress1) {
    		return 1;
    	}
    	// if address 1 AND address 2 are IN the array
    	if ($isAddress1 && $isAddress2) {
    		return 0;
    	}
    }
}