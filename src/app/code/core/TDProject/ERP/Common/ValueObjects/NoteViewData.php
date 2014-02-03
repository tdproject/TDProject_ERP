<?php

/**
 * TDProject_ERP_Common_ValueObjects_NoteViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TechDivision/Model/Interfaces/Value.php';
require_once 'TDProject/ERP/Common/ValueObjects/NoteValue.php';
require_once 'TDProject/ERP/Model/Entities/Note.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the table address.
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
class TDProject_ERP_Common_ValueObjects_NoteViewData 
    extends TDProject_ERP_Common_ValueObjects_NoteValue 
    implements TechDivision_Model_Interfaces_Value {
    
    /**
     * The persons available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_persons = null;
    
    /**
     * The companies available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_companies = null;
    
    /**
     * The users available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_users = null;
    
    /**
     * The note types available in the system.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_noteTypes = null;
    
    /**
     * Collection with the note-person relations.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_personIdFk = null;
    
    /**
     * Collection with the note-company relations.
     * @var TechDivision_Collections_Interfaces_Collection
     */
    protected $_companyIdFk = null;
    
    /**
     * The constructor intializes the DTO with the
     * values passed as parameter.
     *
     * @param TDProject_ERP_Model_Entities_Note $note 
     * 		The array with the virtual members to pass to the parent constructor
     * @return void
     */
    public function __construct(TDProject_ERP_Model_Entities_Note $note)
    {
        // call the parents constructor
        parent::__construct($note);
        // initialize the ValueObject with the passed data
        $this->_persons = new TechDivision_Collections_ArrayList();
        $this->_companies = new TechDivision_Collections_ArrayList();
        $this->_users = new TechDivision_Collections_ArrayList();
        $this->_noteTypes = new TechDivision_Collections_ArrayList();       
        $this->_personIdFk = new TechDivision_Collections_ArrayList();       
        $this->_companyIdFk = new TechDivision_Collections_ArrayList();
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
     * Sets the available users.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $users
     * 		The users available in the system
     * @return void
     */
    public function setUsers(
        TechDivision_Collections_Interfaces_Collection $users) {
        $this->_users = $users;
    }
        
    /**
     * Returns the available users.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The users available in the system
     */
    public function getUsers()
    {
        return $this->_users;
    }
        
    /**
     * Sets the available note types.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $noteTypes
     * 		The note types available in the system
     * @return void
     */
    public function setNoteTypes(
        TechDivision_Collections_Interfaces_Collection $noteTypes) {
        $this->_noteTypes = $noteTypes;
    }
        
    /**
     * Returns the available note types.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The note types available in the system
     */
    public function getNoteTypes()
    {
        return $this->_noteTypes;
    }
        
    /**
     * Sets the Collection with the note-person relations.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $personIdFk
     * 		The Collection with the note-person relations
     * @return void
     */
    public function setPersonIdFk(
        TechDivision_Collections_Interfaces_Collection $personIdFk) {
        $this->_personIdFk = $personIdFk;
    }
        
    /**
     * Returns the Collection with the note-person relations.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with the note-person relations
     */
    public function getPersonIdFk()
    {
        return $this->_personIdFk;
    }
        
    /**
     * Sets the Collection with the note-company relations.
     * 
     * @param TechDivision_Collections_Interfaces_Collection $companyIdFk
     * 		The Collection with the note-company relations
     * @return void
     */
    public function setCompanyIdFk(
        TechDivision_Collections_Interfaces_Collection $companyIdFk) {
        $this->_companyIdFk = $companyIdFk;
    }
        
    /**
     * Returns the Collection with the note-company relations.
     * 
     * @return TechDivision_Collections_Interfaces_Collection
     * 		The Collection with the note-company relations
     */
    public function getCompanyIdFk()
    {
        return $this->_companyIdFk;
    }
}