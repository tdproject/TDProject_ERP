<?php

/**
 * TDProject_ERP_Model_Assembler_Person
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
class TDProject_ERP_Model_Assembler_Person
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
        return new TDProject_ERP_Model_Assembler_Person($container);
    }
        
    /**
     * Returns a DTO with the data of the person
     * with the passed ID.
     * 
     * @param TechDivision_Lang_Integer $personId
     * 		The person ID to return the DTO for
     * @return TDProject_ERP_Common_ValueObjects_PersonViewData
     * 		The requested DTO
     */
    public function getPersonViewData(
        TechDivision_Lang_Integer $personId =  null) {       
		// check if a peson id was passed
		if(!empty($personId)) { // if yes, load the person
			$lvo = TDProject_ERP_Model_Utils_PersonUtil::getHome($this->getContainer())
			    ->findByPrimaryKey($personId);
		} else {
    		// if not, initialize a new person
    		$lvo = TDProject_ERP_Model_Utils_PersonUtil::getHome($this->getContainer())
    		    ->epbCreate();		
		}
		// initialize the DTO
		$dto = new TDProject_ERP_Common_ValueObjects_PersonViewData($lvo);
		// set the available salutations
		$dto->setSalutations(
		    TDProject_ERP_Model_Assembler_Salutation::create($this->getContainer())
		    	->getSalutationOverviewData()
		);
		// set the available addresses
		$dto->setAddresses(
		    TDProject_ERP_Model_Assembler_Address::create($this->getContainer())
		    	->getAddressOverviewData()
		);
		// set the available address types
		$dto->setAddressTypes(
		    TDProject_ERP_Model_Assembler_AddressType::create($this->getContainer())
		    	->getAddressTypeOverviewData()
		);
		// set the address ID's of the related addresses
        foreach ($dto->getPersonAddresses() as $personAddress) {
        	$dto->getAddressIdFk()->add($personAddress->getAddressIdFk()->intValue());	
        }
        // set the address type ID's of the related addresses
        foreach ($dto->getPersonAddresses() as $personAddress) {
        	$dto->getAddressTypeIdFk()->add(
        		$personAddress->getAddressIdFk()->intValue(), 
        		$personAddress->getAddressTypeIdFk()->intValue()
        	);
        }
		// set the available companies
		$dto->setCompanies(
		    TDProject_ERP_Model_Assembler_Company::create($this->getContainer())
		        ->getCompanyOverviewData()
		);
		// set the available users
		$dto->setUsers(
		    TDProject_Core_Model_Assembler_User::create($this->getContainer())
		        ->getUserOverviewData()
		);
		// return the initialized DTO
		return $dto;  
    }

    /**
     * Returns an ArrayList with all persons 
     * assembled as DTO's.
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The requested person DTO's
     */
    public function getPersonOverviewData() {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the persons
        $persons = TDProject_ERP_Model_Utils_PersonUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the persons
        foreach ($persons as $person) {
            $list->add(
            	new TDProject_ERP_Common_ValueObjects_PersonOverviewData($person)
            );
        }
        // return the ArrayList with the PersonOverviewData instances
        return $list;
    }

    /**
     * Returns an ArrayList with all persons 
     * assembled as LVO's.
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The requested person LVO's
     */
    public function getPersonLightValues() {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the persons
        $persons = TDProject_ERP_Model_Utils_PersonUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the persons
        foreach ($persons as $person) {
            $list->add($person->getLightValue());
        }
        // return the ArrayList with the PersonLightValues
        return $list;
    }
}