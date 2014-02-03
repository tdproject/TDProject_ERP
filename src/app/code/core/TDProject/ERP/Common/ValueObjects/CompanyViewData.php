<?php

/**
 * TDProject_ERP_Common_ValueObjects_CompanyViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TechDivision/Collections/HashMap.php';
require_once 'TechDivision/Model/Interfaces/Value.php';
require_once 'TDProject/ERP/Common/ValueObjects/CompanyValue.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the table company.
 *
 * Each class member reflects a database field and
 * the values of the related dataset.
 *
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Common_ValueObjects_CompanyViewData 
    extends TDProject_ERP_Common_ValueObjects_CompanyValue 
    implements TechDivision_Model_Interfaces_Value {
    
    /**
     * The companies available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_companies = null;
    
    /**
     * The persons available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_persons = null;
    
    /**
     * The address available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_addresses = null;
    
    /**
     * The address types available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_addressTypes = null;
    
    /**
     * Collection with the company-person relations.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_personIdFk = null;
    
    /**
     * Collection with the company-address relations.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_addressIdFk = null;
    
    /**
     * Collection with the address types of the company-person relations.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_addressTypeIdFk = null;
    
    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_ERP_Common_ValueObjects_PersonValue $vo 
     * 		The array with the virtual members to pass to the parent constructor
     * @return void
     */
    public function __construct(TDProject_ERP_Common_ValueObjects_CompanyValue $vo = null)
    {
        // call the parents constructor
        parent::__construct($vo);
        // initialize the ValueObject with the passed data
        $this->_companies = new TechDivision_Collections_ArrayList();
        $this->_persons = new TechDivision_Collections_ArrayList();
        $this->_addresses = new TechDivision_Collections_ArrayList();
        $this->_addressTypes = new TechDivision_Collections_ArrayList();        
        $this->_personIdFk = new TechDivision_Collections_ArrayList();
        $this->_addressIdFk = new TechDivision_Collections_ArrayList();
        $this->_addressTypeIdFk = new TechDivision_Collections_HashMap();
    }
        
    /**
     * Sets the available companies.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $companies
     * 		The companies available in the system
     * @return void
     */
    public function setCompanies(
        TechDivision_Collections_Interfaces_Collection $companies) {
        $this->_companies = $companies;
    }
        
    /**
     * Returns the available companies.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The companies available in the system
     */
    public function getCompanies()
    {
        return $this->_companies;
    }
        
    /**
     * Sets the available persons.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $persons
     * 		The persons available in the system
     * @return void
     */
    public function setPersons(
        TechDivision_Collections_Interfaces_Collection $persons) {
        $this->_persons = $persons;
    }
        
    /**
     * Returns the available persons.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The persons available in the system
     */
    public function getPersons()
    {
        return $this->_persons;
    }
        
    /**
     * Sets the available addresses.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $addresses
     * 		The addresses available in the system
     * @return void
     */
    public function setAddresses(
        TechDivision_Collections_Interfaces_Collection $addresses) {
        $this->_addresses = $addresses;
    }
        
    /**
     * Returns the available addresses.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The addresses available in the system
     */
    public function getAddresses()
    {
        return $this->_addresses;
    }
        
    /**
     * Sets the available address types.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $addressTypes
     * 		The address types available in the system
     * @return void
     */
    public function setAddressTypes(
        TechDivision_Collections_Interfaces_Collection $addressTypes) {
        $this->_addressTypes = $addressTypes;
    }
        
    /**
     * Returns the available address types.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The address types available in the system
     */
    public function getAddressTypes()
    {
        return $this->_addressTypes;
    }
        
    /**
     * Sets the Collection with the address types of the company-person relations..
     * 
     * @param TechDivision_Collections_Interfaces_Collection $addressTypes
     * 		The Collection with the address types of the company-person relations
     * @return void
     */
    public function setAddressTypeIdFk(
        TechDivision_Collections_Interfaces_Collection $addressTypeIdFk) {
        $this->_addressTypeIdFk = $addressTypeIdFk;
    }
        
    /**
     * Returns the Collection with the address types of the company-person relations..
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with the address types of the company-person relations
     */
    public function getAddressTypeIdFk()
    {
        return $this->_addressTypeIdFk;
    }
        
    /**
     * Sets the Collection with the company-address relations.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $addressTypes
     * 		The Collection with the company-address relations
     * @return void
     */
    public function setAddressIdFk(
        TechDivision_Collections_Interfaces_Collection $addressIdFk) {
        $this->_addressIdFk = $addressIdFk;
    }
        
    /**
     * Returns the Collection with the company-address relations.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with the company-address relations
     */
    public function getAddressIdFk()
    {
        return $this->_addressIdFk;
    }
        
    /**
     * Sets the Collection with the company-person relations.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $addressTypes
     * 		The Collection with the company-person relations
     * @return void
     */
    public function setPersonIdFk(
        TechDivision_Collections_Interfaces_Collection $personIdFk) {
        $this->_personIdFk = $personIdFk;
    }
        
    /**
     * Returns the Collection with the company-person relations.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with the company-person relations
     */
    public function getPersonIdFk()
    {
        return $this->_personIdFk;
    }
}