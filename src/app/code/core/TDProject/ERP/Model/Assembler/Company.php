<?php

/**
 * TDProject_ERP_Model_Assembler_Company
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
class TDProject_ERP_Model_Assembler_Company
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
        return new TDProject_ERP_Model_Assembler_Company($container);
    }
        
    /**
     * Returns a DTO with the data of the company
     * with the passed ID.
     * 
     * @param TechDivision_Lang_Integer $companyId
     * 		The company ID to return the DTO for
     * @return TDProject_ERP_Common_ValueObjects_CompanyViewData
     * 		The requested DTO
     */
    public function getCompanyViewData(
        TechDivision_Lang_Integer $companyId = null) {
        // load the LocalHome
        $home = TDProject_ERP_Model_Utils_CompanyUtil::getHome($this->getContainer());
		// check if a company ID was passed
		if ($companyId == null) {
    		// if not, initialize a new company
    		$company = $home->epbCreate();
		} else {
		    // if yes, load the company
			$company = $home->findByPrimaryKey($companyId);	
		}
		// initialize the DTO
		$dto = new TDProject_ERP_Common_ValueObjects_CompanyViewData(
		    $company
		);
		// set the available companies
		$dto->setCompanies($this->getCompanyOverviewData());
		// set the available persons
		$dto->setPersons(
		    TDProject_ERP_Model_Assembler_Person::create($this->getContainer())
		    	->getPersonOverviewData()
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
        foreach ($dto->getCompanyAddresses() as $companyAddress) {
        	$dto->getAddressIdFk()->add($companyAddress->getAddressIdFk()->intValue());	
        }
        // set the address type ID's of the related addresses
        foreach ($dto->getCompanyAddresses() as $companyAddress) {
        	$dto->getAddressTypeIdFk()->add(
        		$companyAddress->getAddressIdFk()->intValue(), 
        		$companyAddress->getAddressTypeIdFk()->intValue()
        	);
        }
        // set the ID's of the related persons
        foreach ($dto->getPersons() as $person) {
        	if ($person->getCompanyIdFk() != null && $person->getCompanyIdFk()->equals($dto->getCompanyId())) {
        		$dto->getPersonIdFk()->add($person->getPersonId()->intValue());
        	}
        }
        // return the assembled DTO
		return $dto;
    }

    /**
     * Returns an ArrayList with all companies 
     * assembled as LVO's.
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The requested companies LVO's
     */
    public function getCompanyLightValues() 
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the companies
        $companies = TDProject_ERP_Model_Utils_CompanyUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the companies
        foreach ($companies as $company) {
            $list->add($company->getLightValue());
        }
        // return the ArrayList with the CompanyLightValues
        return $list;
    }

    /**
     * Returns an ArrayList with all companies 
     * assembled as DTO's.
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The requested companies DTO's
     */
    public function getCompanyOverviewData() 
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the companies
        $companies = TDProject_ERP_Model_Utils_CompanyUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the companies
        foreach ($companies as $company) {
            $list->add(
            	new TDProject_ERP_Common_ValueObjects_CompanyOverviewData($company)
            );
        }
        // return the ArrayList with the CompanyOverviewData
        return $list;
    }
}