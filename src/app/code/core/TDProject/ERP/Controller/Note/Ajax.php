<?php

/**
 * TDProject_Core_Controller_Note_Ajax
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TDProject/Core/Common/ValueObjects/System/UserValue.php';
require_once 'TDProject/Core/Controller/Util/GlobalForwardKeys.php';
require_once 'TDProject/ERP/Controller/Abstract.php';
require_once 'TDProject/ERP/Block/Person/Overview.php';
require_once 'TDProject/ERP/Block/Person/View.php';
require_once 'TDProject/ERP/Controller/Util/WebRequestKeys.php';
require_once 'TDProject/ERP/Controller/Util/MessageKeys.php';
require_once 'TDProject/ERP/Controller/Util/ErrorKeys.php';
require_once 'TDProject/ERP/Common/ValueObjects/PersonNoteLightValue.php';
require_once 'TDProject/ERP/Common/ValueObjects/CompanyNoteLightValue.php';

/**
 * @category   	TDProject
 * @package    	TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Controller_Note_Ajax
    extends TDProject_ERP_Controller_Abstract {

    /**
     * This method is automatically invoked by the controller and implements
     * the functionality to relate a newly created note with the actual
     * person.
     *
     * @return ActionForward Returns a ActionForward
     */
    public function relatePersonNoteAction()
    {
        try {
            // load the note ID from the request
            $noteId = TechDivision_Lang_Integer::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                    	TDProject_ERP_Controller_Util_WebRequestKeys::NOTE_ID,
                    	FILTER_VALIDATE_INT
                    )
                )
            );
            // load the person ID from the request
            $personIdFk = TechDivision_Lang_Integer::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                    	TDProject_ERP_Controller_Util_WebRequestKeys::PERSON_ID_FK,
                    	FILTER_VALIDATE_INT
                    )
                )
            );
            // initialize a new LVO
            $lvo = new TDProject_ERP_Common_ValueObjects_PersonNoteLightValue();
            $lvo->setPersonIdFk($personIdFk);
            $lvo->setNoteIdFk($noteId);
            $lvo->setReason(new TechDivision_Lang_String(date('Y-m-d H:i:s')));
            // save the person-note relations
            $this->_getDelegate()->relatePersonNote($lvo);
            // create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_ERP_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('personNoteRelate.successfull')
                )
            );
            // save the ActionMessages in the request
            $this->_saveActionMessages($actionMessages);
        } catch(Exception $e) {
            // create and add and save the error
            $errors = new TechDivision_Controller_Action_Errors();
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_ERP_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
            // adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
        }
        // return the ActionForward to the system messages
        return $this->_findForward(
			TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_MESSAGES
		);
    }

    /**
     * This method is automatically invoked by the controller and implements
     * the functionality to unrelate a note with the actual person.
     *
     * @return ActionForward Returns a ActionForward
     */
    public function unrelatePersonNoteAction()
    {
        try {
            // load the note ID from the request
            $noteId = TechDivision_Lang_Integer::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                    	TDProject_ERP_Controller_Util_WebRequestKeys::NOTE_ID,
                    	FILTER_VALIDATE_INT
                    )
                )
            );
            // load the person ID from the request
            $personIdFk = TechDivision_Lang_Integer::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                    	TDProject_ERP_Controller_Util_WebRequestKeys::PERSON_ID_FK,
                    	FILTER_VALIDATE_INT
                    )
                )
            );
            // initialize a new LVO
            $lvo = new TDProject_ERP_Common_ValueObjects_PersonNoteLightValue();
            $lvo->setPersonIdFk($personIdFk);
            $lvo->setNoteIdFk($noteId);
            $lvo->setReason(new TechDivision_Lang_String(date('Y-m-d H:i:s')));
            // delete the person-address relations
            $this->_getDelegate()->unrelatePersonNote($lvo);
            // create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_ERP_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('personNoteUnrelate.successfull')
                )
            );
            // save the ActionMessages in the request
            $this->_saveActionMessages($actionMessages);
        } catch(Exception $e) {
            // create and add and save the error
            $errors = new TechDivision_Controller_Action_Errors();
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_ERP_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
            // adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
        }
        // return the ActionForward to the system messages
        return $this->_findForward(
			TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_MESSAGES
		);
    }

    /**
     * This method is automatically invoked by the controller and implements
     * the functionality to relate a newly created note with the actual
     * company.
     *
     * @return ActionForward Returns a ActionForward
     */
    public function relateCompanyNoteAction()
    {
        try {
            // load the note ID from the request
            $noteId = TechDivision_Lang_Integer::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                    	TDProject_ERP_Controller_Util_WebRequestKeys::NOTE_ID,
                    	FILTER_VALIDATE_INT
                    )
                )
            );
            // load the company ID from the request
            $companyIdFk = TechDivision_Lang_Integer::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                    	TDProject_ERP_Controller_Util_WebRequestKeys::COMPANY_ID_FK,
                    	FILTER_VALIDATE_INT
                    )
                )
            );
            // initialize a new LVO
            $lvo = new TDProject_ERP_Common_ValueObjects_CompanyNoteLightValue();
            $lvo->setCompanyIdFk($companyIdFk);
            $lvo->setNoteIdFk($noteId);
            $lvo->setReason(new TechDivision_Lang_String(date('Y-m-d H:i:s')));
            // save the company-note relations
            $this->_getDelegate()->relateCompanyNote($lvo);
            // create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_ERP_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('companyNoteRelate.successfull')
                )
            );
            // save the ActionMessages in the request
            $this->_saveActionMessages($actionMessages);
        } catch(Exception $e) {
            // create and add and save the error
            $errors = new TechDivision_Controller_Action_Errors();
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_ERP_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
            // adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
        }
        // return the ActionForward to the system messages
        return $this->_findForward(
			TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_MESSAGES
		);
    }

    /**
     * This method is automatically invoked by the controller and implements
     * the functionality to unrelate a note with the actual company.
     *
     * @return ActionForward Returns a ActionForward
     */
    public function unrelateCompanyNoteAction()
    {
        try {
            // load the note ID from the request
            $noteId = TechDivision_Lang_Integer::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                    	TDProject_ERP_Controller_Util_WebRequestKeys::NOTE_ID,
                    	FILTER_VALIDATE_INT
                    )
                )
            );
            // load the company ID from the request
            $companyIdFk = TechDivision_Lang_Integer::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                    	TDProject_ERP_Controller_Util_WebRequestKeys::COMPANY_ID_FK,
                    	FILTER_VALIDATE_INT
                    )
                )
            );
            // initialize a new LVO
            $lvo = new TDProject_ERP_Common_ValueObjects_CompanyNoteLightValue();
            $lvo->setCompanyIdFk($companyIdFk);
            $lvo->setNoteIdFk($noteId);
            $lvo->setReason(new TechDivision_Lang_String(date('Y-m-d H:i:s')));
            // delete the person-address relations
            $this->_getDelegate()->unrelateCompanyNote($lvo);
            // create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_ERP_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('companyNoteUnrelate.successfull')
                )
            );
            // save the ActionMessages in the request
            $this->_saveActionMessages($actionMessages);
        } catch(Exception $e) {
            // create and add and save the error
            $errors = new TechDivision_Controller_Action_Errors();
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_ERP_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
            // adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
        }
        // return the ActionForward to the system messages
        return $this->_findForward(
			TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_MESSAGES
		);
    }

    /**
	 * Tries to load the Block class specified as path parameter
	 * in the ActionForward. If a Block was found and the class
	 * can be instanciated, the Block was registered to the Request
	 * with the path as key.
	 *
	 * @param TechDivision_Controller_Action_Forward $actionForward
	 * 		The ActionForward to initialize the Block for
	 * @return void
	 */
	protected function _getBlock(
	    TechDivision_Controller_Action_Forward $actionForward) {
	    // check if the class required to initialize the Block is included
	    if (!class_exists($path = $actionForward->getPath())) {
	        return;
	    }
	    // initialize the messages and add the Block
	    $page = new $path($this->getContext());
	    // register the Block in the Request
	    $this->_getRequest()->setAttribute($path, $page);
	}

}