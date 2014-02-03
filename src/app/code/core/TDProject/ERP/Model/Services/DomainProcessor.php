<?php

/**
 * TDProject_ERP_Model_Services_DomainProcessor
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package    	TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Model_Services_DomainProcessor
    extends TDProject_ERP_Model_Services_AbstractDomainProcessor
{

	/**
	 * This method returns the logger of the requested
	 * type for logging purposes.
	 *
     * @param string The log type to use
	 * @return TechDivision_Logger_Logger Holds the Logger object
	 * @throws Exception Is thrown if the requested logger type is not initialized or doesn't exist
	 * @deprecated 0.6.17 - 2011/12/19
	 */
    protected function _getLogger(
        $logType = TechDivision_Logger_System::LOG_TYPE_SYSTEM)
    {
    	return $this->getLogger();
    }   
    
    /**
     * This method returns the logger of the requested
     * type for logging purposes.
     *
     * @param string The log type to use
     * @return TechDivision_Logger_Logger Holds the Logger object
     * @since 0.6.18 - 2011/12/19
     */
    public function getLogger(
    	$logType = TechDivision_Logger_System::LOG_TYPE_SYSTEM)
    {
    	return $this->getContainer()->getLogger();
    } 

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#getPersonViewData(TechDivision_Lang_Integer $personId = null)
     */
	public function getPersonViewData(
	    TechDivision_Lang_Integer $personId = null) {
    	try {
    		// assemble and return the initialized DTO
    		return TDProject_ERP_Model_Assembler_Person::create($this->getContainer())
    		    ->getPersonViewData($personId);
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#getPersonOverviewData()
     */
	public function getPersonOverviewData() {
	    try {
    		// assemble and return the initialized ArrayList
    		return TDProject_ERP_Model_Assembler_Person::create($this->getContainer())
    		    ->getPersonOverviewData();
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#savePerson(TDProject_ERP_Common_ValueObjects_PersonLightValue $lvo)
     */
	public function savePerson(
        TDProject_ERP_Common_ValueObjects_PersonViewData $dto) {
		try {
			// begin the transaction
			$this->beginTransaction();
			// lookup person ID
			$personId = $dto->getPersonId();
			// store the person
			if ($personId->equals(new TechDivision_Lang_Integer(0))) {
	            // create a new person
				$person = TDProject_ERP_Model_Utils_PersonUtil::getHome($this->getContainer())
				    ->epbCreate();
				// set the data
				$person->setCompanyIdFk($dto->getCompanyIdFk());
				$person->setUserIdFk($dto->getUserIdFk());
				$person->setSalutationIdFk($dto->getSalutationIdFk());
				$person->setPosition($dto->getPosition());
				$person->setLastname($dto->getLastname());
				$person->setFirstname($dto->getFirstname());
				$person->setTitle($dto->getTitle());
				$person->setEmail($dto->getEmail());
				$person->setPhone($dto->getPhone());
				$person->setTelefax($dto->getTelefax());
				$person->setMobile($dto->getMobile());
				$personId = $person->create();
			} else {
			    // update the person
				$person = TDProject_ERP_Model_Utils_PersonUtil::getHome($this->getContainer())
				    ->findByPrimaryKey($personId);
				$person->setCompanyIdFk($dto->getCompanyIdFk());
				$person->setUserIdFk($dto->getUserIdFk());
				$person->setSalutationIdFk($dto->getSalutationIdFk());
				$person->setPosition($dto->getPosition());
				$person->setLastname($dto->getLastname());
				$person->setFirstname($dto->getFirstname());
				$person->setTitle($dto->getTitle());
				$person->setEmail($dto->getEmail());
				$person->setPhone($dto->getPhone());
				$person->setTelefax($dto->getTelefax());
				$person->setMobile($dto->getMobile());
				$person->update();
			}
			// commit the transaction
			$this->commitTransaction();
			// return the person ID
			return $personId;
		} catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#deletePerson(TechDivision_Lang_Integer $personId)
     */
    public function deletePerson(TechDivision_Lang_Integer $personId) {
        try {
            // start the transaction
            $this->beginTransaction();
            // load the person
            $person = TDProject_ERP_Model_Utils_PersonUtil::getHome($this->getContainer())
                ->findByPrimaryKey($personId);
            // set the deleted flat
            $person->setDeleted(new TechDivision_Lang_Integer(1));
            // update the person
            $person->update();
            // commit the transcation
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#deleteAddress(TechDivision_Lang_Integer $addressId)
     */
    public function deleteAddress(TechDivision_Lang_Integer $addressId) {
        try {
            // start the transaction
            $this->beginTransaction();
            // load the address
            $address = TDProject_ERP_Model_Utils_AddressUtil::getHome($this->getContainer())
                ->findByPrimaryKey($addressId);
            // delete the address
            $address->delete();
            // commit the transcation
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#deleteNote(TechDivision_Lang_Integer $noteId)
     */
    public function deleteNote(TechDivision_Lang_Integer $noteId) {
        try {
            // start the transaction
            $this->beginTransaction();
            // load the note
            $note = TDProject_ERP_Model_Utils_NoteUtil::getHome($this->getContainer())
                ->findByPrimaryKey($noteId);
            // set the deleted flag
            $note->setDeleted(new TechDivision_Lang_Integer(1));
            // update the note
            $note->update();
            // commit the transcation
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#getCompanyViewData(TechDivision_Lang_Integer $companyId = null)
     */
	public function getCompanyViewData(
	    TechDivision_Lang_Integer $companyId = null) {
    	try {
    		// assemble and return the initialized DTO
    		return TDProject_ERP_Model_Assembler_Company::create($this->getContainer())
    		    ->getCompanyViewData($companyId);
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#getCompanyOverviewData()
     */
	public function getCompanyOverviewData() {
	    try {
            // load and return all companies
            return TDProject_ERP_Model_Assembler_Company::create($this->getContainer())
                ->getCompanyOverviewData();
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#saveCompany(TDProject_ERP_Common_ValueObjects_CompanyViewData $dto)
     */
	public function saveCompany(
        TDProject_ERP_Common_ValueObjects_CompanyViewData $dto) {
		try {
			// begin the transaction
			$this->beginTransaction();
			// lookup company ID
			$companyId = $dto->getCompanyId();
			// store the company
			if ($companyId->equals(new TechDivision_Lang_Integer(0))) {
	            // create a new company
				$company = TDProject_ERP_Model_Utils_CompanyUtil::getHome($this->getContainer())
				    ->epbCreate();
				// set the data
				$company->setCompanyIdFk($dto->getCompanyIdFk());
				$company->setName($dto->getName());
				$company->setAdditionalName($dto->getAdditionalName());
				$company->setPhone($dto->getPhone());
				$company->setEmail($dto->getEmail());
				$company->setTelefax($dto->getTelefax());
				$company->setWebsite($dto->getWebsite());
				$company->setCustomerNumber($dto->getCustomerNumber());
				$companyId = $company->create();
			} else {
			    // update the company
				$company = TDProject_ERP_Model_Utils_CompanyUtil::getHome($this->getContainer())
				    ->findByPrimaryKey($companyId);
				$company->setCompanyIdFk($dto->getCompanyIdFk());
				$company->setName($dto->getName());
				$company->setAdditionalName($dto->getAdditionalName());
				$company->setPhone($dto->getPhone());
				$company->setEmail($dto->getEmail());
				$company->setTelefax($dto->getTelefax());
				$company->setWebsite($dto->getWebsite());
				$company->setCustomerNumber($dto->getCustomerNumber());
				$company->update();
			}
			// commit the transaction
			$this->commitTransaction();
			// return the company ID
			return $companyId;
		} catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#deleteCompany(TechDivision_Lang_Integer $companyId)
     */
    public function deleteCompany(TechDivision_Lang_Integer $companyId) {
        try {
            // start the transaction
            $this->beginTransaction();
            // load the company
            $company = TDProject_ERP_Model_Utils_CompanyUtil::getHome($this->getContainer())
                ->findByPrimaryKey($companyId);
            // set the deleted flag
            $company->setDeleted(new TechDivision_Lang_Integer(1));
            // update the company
            $company->update();
            // commit the transcation
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#getAddressViewData(TechDivision_Lang_Integer $addressId = null)
     */
	public function getAddressViewData(
	    TechDivision_Lang_Integer $addressId = null) {
    	try {
    		// assemble and return the initialized DTO
    		return TDProject_ERP_Model_Assembler_Address::create($this->getContainer())
    		    ->getAddressViewData($addressId);
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#saveAddress(TDProject_ERP_Common_ValueObjects_AddressLightValue $lvo)
     */
	public function saveAddress(
        TDProject_ERP_Common_ValueObjects_AddressLightValue $lvo) {
		try {
			// begin the transaction
			$this->beginTransaction();
			// lookup address ID
			$addressId = $lvo->getAddressId();
			// store the address
			if ($addressId->equals(new TechDivision_Lang_Integer(0))) {
	            // create a new address
				$address = TDProject_ERP_Model_Utils_AddressUtil::getHome($this->getContainer())
				    ->epbCreate();
				// set the data
				$address->setCountryIdFk($lvo->getCountryIdFk());
				$address->setState($lvo->getState());
				$address->setStreet($lvo->getStreet());
				$address->setNumber($lvo->getNumber());
				$address->setPostcode($lvo->getPostcode());
				$address->setCity($lvo->getCity());
				$address->setPostOfficeBox($lvo->getPostOfficeBox());
				$addressId = $address->create();
			} else {
			    // update the address
				$address = TDProject_ERP_Model_Utils_AddressUtil::getHome($this->getContainer())
				    ->findByPrimaryKey($addressId);
				$address->setCountryIdFk($lvo->getCountryIdFk());
				$address->setState($lvo->getState());
				$address->setStreet($lvo->getStreet());
				$address->setNumber($lvo->getNumber());
				$address->setPostcode($lvo->getPostcode());
				$address->setCity($lvo->getCity());
				$address->setPostOfficeBox($lvo->getPostOfficeBox());
				$address->update();
			}
			// commit the transaction
			$this->commitTransaction();
			// return the address ID
			return $addressId;
		} catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#relatePersonAddress(TDProject_ERP_Common_ValueObjects_PersonAddressLightValue $lvo)
     */
    public function relatePersonAddress(
        TDProject_ERP_Common_ValueObjects_PersonAddressLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // initialize a new person-address relation
            $personAddress = TDProject_ERP_Model_Utils_PersonAddressUtil::getHome($this->getContainer())
                ->epbCreate();
            // set and save the data
            $personAddress->setAddressTypeIdFk($lvo->getAddressTypeIdFk());
            $personAddress->setPersonIdFk($lvo->getPersonIdFK());
            $personAddress->setAddressIdFk($lvo->getAddressIdFk());
            $personAddress->create();
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#unrelateCompanyAddress(TDProject_ERP_Common_ValueObjects_PersonAddressLightValue $lvo)
     */
    public function unrelatePersonAddress(
        TDProject_ERP_Common_ValueObjects_PersonAddressLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // load the person-address relations
            $personAddressRelations = TDProject_ERP_Model_Utils_PersonAddressUtil::getHome($this->getContainer())
                ->findAllByPersonIdFkAndAddressIdFk(
                	$lvo->getPersonIdFK(), $lvo->getAddressIdFk());
            // delete the relations
            foreach ($personAddressRelations as $personAddress) {
            	$personAddress->delete();
            }
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#relateCompanyAddress(TDProject_ERP_Common_ValueObjects_CompanyAddressLightValue $lvo)
     */
    public function relateCompanyAddress(
        TDProject_ERP_Common_ValueObjects_CompanyAddressLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // initialize a new company-address relation
            $companyAddress = TDProject_ERP_Model_Utils_CompanyAddressUtil::getHome($this->getContainer())
                ->epbCreate();
            // set and save the data
            $companyAddress->setAddressTypeIdFk($lvo->getAddressTypeIdFk());
            $companyAddress->setCompanyIdFk($lvo->getCompanyIdFK());
            $companyAddress->setAddressIdFk($lvo->getAddressIdFk());
            $companyAddress->create();
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#unrelateCompanyAddress(TDProject_ERP_Common_ValueObjects_CompanyAddressLightValue $lvo)
     */
    public function unrelateCompanyAddress(
        TDProject_ERP_Common_ValueObjects_CompanyAddressLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // load the company-address relations
            $companyAddressRelations = TDProject_ERP_Model_Utils_CompanyAddressUtil::getHome($this->getContainer())
                ->findAllByCompanyIdFkAndAddressIdFk(
                	$lvo->getCompanyIdFK(), $lvo->getAddressIdFk());
            // delete the relations
            foreach ($companyAddressRelations as $companyAddress) {
            	$companyAddress->delete();
            }
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#relateCompanyPerson(TDProject_ERP_Common_ValueObjects_PersonLightValue $lvo)
     */
    public function relateCompanyPerson(
        TDProject_ERP_Common_ValueObjects_PersonLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // load person
            $person = TDProject_ERP_Model_Utils_PersonUtil::getHome($this->getContainer())
                ->findByPrimaryKey($lvo->getPersonId());
            // set and update the data
            $person->setCompanyIdFk($lvo->getCompanyIdFk());
            $person->update();
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#unrelateCompanyPerson(TDProject_ERP_Common_ValueObjects_PersonLightValue $lvo)
     */
    public function unrelateCompanyPerson(
        TDProject_ERP_Common_ValueObjects_PersonLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // load person
            $person = TDProject_ERP_Model_Utils_PersonUtil::getHome($this->getContainer())
                ->findByPrimaryKey($lvo->getPersonId());
            // unset and update the data
            $person->setCompanyIdFk(NULL);
            $person->update();
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#getNoteViewData(TechDivision_Lang_Integer $noteId = null)
     */
	public function getNoteViewData(
	    TechDivision_Lang_Integer $noteId = null) {
    	try {
    		// assemble and return the initialized DTO
    		return TDProject_ERP_Model_Assembler_Note::create($this->getContainer())
    		    ->getNoteViewData($noteId);
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getNoteOverviewData()
     */
	public function getNoteOverviewData()
	{
	    try {
    		// assemble and return the ArrayList with the initialized DTO's
    		return TDProject_ERP_Model_Assembler_Note::create($this->getContainer())
    		    ->getNoteOverviewData();
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#saveNote(TDProject_ERP_Common_ValueObjects_NoteLightValue $lvo)
     */
	public function saveNote(
        TDProject_ERP_Common_ValueObjects_NoteLightValue $lvo) {
		try {
			// begin the transaction
			$this->beginTransaction();
			// lookup note ID
			$noteId = $lvo->getNoteId();
			// store the note
			if ($noteId->equals(new TechDivision_Lang_Integer(0))) {
	            // create a new note
				$note = TDProject_ERP_Model_Utils_NoteUtil::getHome($this->getContainer())
				    ->epbCreate();
				// set the data
				$note->setNoteTypeIdFk($lvo->getNoteTypeIdFk());
				$note->setRemindUserIdFk($lvo->getRemindUserIdFk());
				$note->setCreateUserIdFk($lvo->getCreateUserIdFk());
				$note->setRemindAt($lvo->getRemindAt());
				$note->setCreatedAt($lvo->getCreatedAt());
				$note->setSubject($lvo->getSubject());
				$note->setNote($lvo->getNote());
				$note->setFilename($lvo->getFilename());
				$noteId = $note->create();
			} else {
			    // update the note
				$note = TDProject_ERP_Model_Utils_NoteUtil::getHome($this->getContainer())
				    ->findByPrimaryKey($noteId);
				$note->setNoteTypeIdFk($lvo->getNoteTypeIdFk());
				$note->setRemindUserIdFk($lvo->getRemindUserIdFk());
				$note->setRemindAt($lvo->getRemindAt());
				$note->setSubject($lvo->getSubject());
				$note->setNote($lvo->getNote());
				$note->setFilename($lvo->getFilename());
				$note->update();
			}
			// commit the transaction
			$this->commitTransaction();
			// return the note ID
			return $noteId;
		} catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#relatePersonNote(TDProject_ERP_Common_ValueObjects_PersonNoteLightValue $lvo)
     */
    public function relatePersonNote(
        TDProject_ERP_Common_ValueObjects_PersonNoteLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // initialize a new person-note relation
            $personNote= TDProject_ERP_Model_Utils_PersonNoteUtil::getHome($this->getContainer())
                ->epbCreate();
            // set and save the data
            $personNote->setReason($lvo->getReason());
            $personNote->setPersonIdFk($lvo->getPersonIdFK());
            $personNote->setNoteIdFk($lvo->getNoteIdFk());
            $personNote->create();
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#unrelatePersonNote(TDProject_ERP_Common_ValueObjects_PersonNoteLightValue $lvo)
     */
    public function unrelatePersonNote(
        TDProject_ERP_Common_ValueObjects_PersonNoteLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // load the person-note relations
            $personNoteRelations = TDProject_ERP_Model_Utils_PersonNoteUtil::getHome($this->getContainer())
                ->findAllByPersonIdFkAndNoteIdFk(
                	$lvo->getPersonIdFK(), $lvo->getNoteIdFk()
                );
            // delete the relations
            foreach ($personNoteRelations as $personNote) {
            	$personNote->delete();
            }
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#relateCompanyNote(TDProject_ERP_Common_ValueObjects_CompanyNoteLightValue $lvo)
     */
    public function relateCompanyNote(
        TDProject_ERP_Common_ValueObjects_CompanyNoteLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // initialize a new company-note relation
            $companyNote = TDProject_ERP_Model_Utils_CompanyNoteUtil::getHome($this->getContainer())
                ->epbCreate();
            // set and save the data
            $companyNote->setReason($lvo->getReason());
            $companyNote->setCompanyIdFk($lvo->getCompanyIdFK());
            $companyNote->setNoteIdFk($lvo->getNoteIdFk());
            $companyNote->create();
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

    /**
     * (non-PHPdoc)
     * @see TDProject/ERP/Common/Delegates/Interfaces/DomainProcessorDelegate#unrelateCompanyNote(TDProject_ERP_Common_ValueObjects_CompanyNoteLightValue $lvo)
     */
    public function unrelateCompanyNote(
        TDProject_ERP_Common_ValueObjects_CompanyNoteLightValue $lvo) {
        try {
            // begin the transaction
            $this->beginTransaction();
            // load the company-note relations
            $companyNoteRelations = TDProject_ERP_Model_Utils_CompanyNoteUtil::getHome($this->getContainer())
                ->findAllByCompanyIdFkAndNoteIdFk(
                	$lvo->getCompanyIdFK(), $lvo->getNoteIdFk()
                );
            // delete the relations
            foreach ($companyNoteRelations as $companyNote) {
            	$companyNote->delete();
            }
            // commit the transaction
            $this->commitTransaction();
        } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException($e->__toString());
        }
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Core/Common/Delegates/Interfaces/DomainProcessorDelegate#getNoteOverviewData(TechDivision_Lang_Integer $userId)
     */
	public function getNoteOverviewDataByUserId(TechDivision_Lang_Integer $userId) {
	    try {
    		// assemble and return the ArrayList with the initialized DTO's
    		return TDProject_ERP_Model_Assembler_Note::create($this->getContainer())
    		    ->getNoteOverviewDataByUserId($userId);
	    } catch(TechDivision_Model_Interfaces_Exception $e) {
            // log the exception message
            $this->_getLogger()->error($e->__toString());
            // throw a new exception
            throw new TDProject_Core_Common_Exceptions_SystemException(
                $e->__toString()
            );
        }
	}
}