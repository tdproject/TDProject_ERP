<?php

/**
 * TDProject_ERP_Controller_Note
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TDProject/Core/Controller/Util/GlobalForwardKeys.php';
require_once 'TDProject/ERP/Controller/Abstract.php';
require_once 'TDProject/ERP/Controller/Util/WebRequestKeys.php';
require_once 'TDProject/ERP/Controller/Util/WebSessionKeys.php';
require_once 'TDProject/ERP/Controller/Util/MessageKeys.php';
require_once 'TDProject/ERP/Controller/Util/ErrorKeys.php';
require_once 'TDProject/ERP/Block/Note/View.php';
require_once 'TDProject/ERP/Block/Note/Overview.php';
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
class TDProject_ERP_Controller_Note
    extends TDProject_ERP_Controller_Abstract {

	/**
	 * The key for the ActionForward to the note overview template.
	 * @var string
	 */
	const NOTE_OVERVIEW = "NoteOverview";

	/**
	 * The key for the ActionForward to the note view template.
	 * @var string
	 */
	const NOTE_VIEW = "NoteView";

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load a list with with all notes.
	 *
	 * @return void
	 */
	public function __defaultAction()
	{
		try {
			// replace the default ActionForm
			$this->getContext()->setActionForm(
				new TDProject_ERP_Block_Note_Overview($this->getContext())
			);
            // load and register the note overview data
            $this->_getRequest()->setAttribute(
            	TDProject_ERP_Controller_Util_WebRequestKeys::OVERVIEW_DATA,
            	$this->_getDelegate()->getNoteOverviewData()
            );
		} catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(new TechDivision_Controller_Action_Error(
                TDProject_ERP_Controller_Util_Errorkeys::SYSTEM_ERROR, $e->__toString())
            );
			// adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
		// go to the standard page
		return $this->_findForward(
		    TDProject_ERP_Controller_Note::NOTE_OVERVIEW
		);
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load the address data with the id passed in the
	 * Request for editing it.
	 *
	 * @return void
	 */
	public function editAction()
	{
        try {
            // load the note ID from the request
            if (($noteId = $this->_getRequest()->getAttribute(
                TDProject_ERP_Controller_Util_WebRequestKeys::NOTE_ID)) == null) {
                $noteId = $this->_getRequest()->getParameter(
                    TDProject_ERP_Controller_Util_WebRequestKeys::NOTE_ID
                );
            }
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->populate(
                $dto = $this->_getDelegate()->getNoteViewData(
                    TechDivision_Lang_Integer::valueOf(
                        new TechDivision_Lang_String($noteId)
                    )
                )
            );
            // register the DTO in the Request
            $this->_getRequest()->setAttribute(
                TDProject_ERP_Controller_Util_WebRequestKeys::VIEW_DATA,
                $dto
            );
        } catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
                    TDProject_ERP_Controller_Util_Errorkeys::SYSTEM_ERROR,
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
        // return to the address detail page
        return $this->_findForward(
            TDProject_ERP_Controller_Note::NOTE_VIEW
        );
	}

   /**
     * This method is automatically invoked by the controller and implements
     * the functionality to create a new note.
     *
	 * @return void
     */
    public function createAction()
    {
        try {
            // initialize the ActionForm with the data from the DTO
            $dto = $this->_getDelegate()->getNoteViewData();
            // load the ActionForm
            $actionForm = $this->_getActionForm();
            // set the Collections
	    	$actionForm->setNoteTypes($dto->getNoteTypes());
	    	$actionForm->setPersons($dto->getPersons());
	    	$actionForm->setUsers($dto->getUsers());
	    	$actionForm->setCompanies($dto->getCompanies());
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
        // return to the note detail page
        return $this->_findForward(
            TDProject_ERP_Controller_Note::NOTE_VIEW
        );
    }

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to save the passed note data.
	 *
	 * @return void
	 */
	public function saveAction()
	{
		try {
		    // load the ActionForm
		    $actionForm = $this->_getActionForm();
		    // validate the ActionForm with the note data
            $actionErrors = $actionForm->validate();
            if (($errorsFound = $actionErrors->size()) > 0) {
                $this->_saveActionErrors($actionErrors);
                return $this->createAction();
            }
            // save the passed note
            $noteId = $this->_getDelegate()->saveNote(
                $actionForm->repopulate(
                    $this->_getSystemUser()->getUserId()
                )
            );
			// save the note and store the ID in the Request
			$this->_getRequest()->setAttribute(
                TDProject_ERP_Controller_Util_WebRequestKeys::NOTE_ID,
                $noteId->intValue()
            );
			// create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_ERP_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('noteUpdate.successfull')
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
		// return to the note detail page
        return $this->editAction();
	}

	/**
     * This method is automatically invoked by the controller and implements
     * the functionality to delete the passed note.
     *
	 * @return void
     */
    public function deleteAction()
    {
        try {
            // load the note ID from the request
        	$noteId = $this->_getRequest()->getParameter(
                TDProject_ERP_Controller_Util_WebRequestKeys::NOTE_ID,
                FILTER_VALIDATE_INT
            );
            // delete the note
            $this->_getDelegate()->deleteNote(
                TechDivision_Lang_Integer::valueOf(
                    new TechDivision_Lang_String($noteId)
                )
            );
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
        // return to the note overview page
        return $this->__defaultAction();
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
	    // initialize the page and add the Block
	    $page = new TDProject_Core_Block_Page($this->getContext());
	    $page->setPageTitle($this->_getPageTitle());
	    $page->addBlock($this->getContext()->getActionForm());
	    // register the Block in the Request
	    $this->_getRequest()->setAttribute($path, $page);
	}
}