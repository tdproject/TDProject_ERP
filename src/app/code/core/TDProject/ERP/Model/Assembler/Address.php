<?php

/**
 * TDProject_ERP_Model_Assembler_Address
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Model_Assembler_Address 
    extends TDProject_Core_Model_Assembler_Abstract {

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_ERP_Model_Assembler_Address($container);
    }
        
    /**
     * Returns a DTO with the data of the address
     * with the passed ID.
     * 
     * @param TechDivision_Lang_Integer $addressId
     * 		The address ID to return the DTO for
     * @return TDProject_ERP_Common_ValueObjects_AddressViewData
     * 		The requested DTO
     */
    public function getAddressViewData(
        TechDivision_Lang_Integer $addressId = null) {
        // load the LocalHome
        $home = TDProject_ERP_Model_Utils_AddressUtil::getHome($this->getContainer());
		// check if a address ID was passed
		if ($addressId == null) {
    		// if not, initialize a new address
    		$address = $home->epbCreate();
		} else {
		    // if yes, load the address
			$address = $home->findByPrimaryKey($addressId);	
		}
		// initialize the DTO
		$dto = new TDProject_ERP_Common_ValueObjects_AddressViewData(
		    $address
		);
		// set the available countries
		$dto->setCountries(
		    TDProject_ERP_Model_Assembler_Country::create($this->getContainer())
		        ->getCountryOverviewData()
		);
        // return the assembled DTO
		return $dto;
    } 

    /**
     * Returns an ArrayList with all addresses 
     * assembled as DTO's.
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The requested address DTO's
     */
    public function getAddressOverviewData() 
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the addresses
        $addresses = TDProject_ERP_Model_Utils_AddressUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the addresses
        foreach ($addresses as $address) {
        	// assemble the address
        	$dto = new TDProject_ERP_Common_ValueObjects_AddressOverviewData(
        		$address
        	);
        	$dto->setCountryName($address->getCountry()->getName());
            $list->add($dto);
        }
        // return the ArrayList with the AddressOverviewData instances
        return $list;
    }
}