<?php

/**
 * TDProject_Core_Controller_Person
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
require_once 'TDProject/ERP/Common/ValueObjects/PersonAddressLightValue.php';
require_once 'TDProject/ERP/Common/ValueObjects/PersonNoteLightValue.php';

/**
 * @category   	TDProject
 * @package    	TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Controller_Address
    extends TDProject_ERP_Controller_Abstract {

	/**
	 * The key for the ActionForward to the address view template.
	 * @var string
	 */
	const ADDRESS_VIEW = "AddressView";

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load the address data with the id passed in the
	 * Request for editing it.
	 *
	 * @return void
	 */
	public function editAction() {
        try {
            // load the person ID from the request
            $addressId = $this->_getRequest()->getAttribute(
                TDProject_ERP_Controller_Util_WebRequestKeys::ADDRESS_ID
            );
            if ($addressId == null) {
                $addressId = $this->_getRequest()->getParameter(
                    TDProject_ERP_Controller_Util_WebRequestKeys::ADDRESS_ID
                );
            }
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->populate(
                $dto = $this->_getDelegate()->getAddressViewData(
                    TechDivision_Lang_Integer::valueOf(
                        new TechDivision_Lang_String($addressId)
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
        // return to the company detail page
        return $this->_findForward(
            TDProject_ERP_Controller_Address::ADDRESS_VIEW
        );
	}

    /**
     * This method is automatically invoked by the controller and implements
     * the functionality to create a new address.
     *
	 * @return void
     */
    public function createAction() {
        try {
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->initialize(
                $this->_getDelegate()->getAddressViewData()
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
        // return to the address detail page
        return $this->_findForward(
            TDProject_ERP_Controller_Address::ADDRESS_VIEW
        );
    }

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to save the passed address data.
	 *
	 * @return void
	 */
	public function saveAction() {
		try {
		    // load the ActionForm
		    $actionForm = $this->_getActionForm();
		    // validate the ActionForm with the address data
            $actionErrors = $actionForm->validate();
            if (($errorsFound = $actionErrors->size()) > 0) {
                $this->_saveActionErrors($actionErrors);
                return $this->createAction();
            }
			// save the address
			$addressId = $this->_getDelegate()
			    ->saveAddress($actionForm->repopulate());
			// store the ID of the address in the Request
			$this->_getRequest()->setAttribute(
                TDProject_ERP_Controller_Util_WebRequestKeys::ADDRESS_ID,
                $addressId->intValue()
            );
			// create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_ERP_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('addressUpdate.successfull')
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
		// return to the address detail page
        return $this->editAction();
	}

	/**
     * This method is automatically invoked by the controller and implements
     * the functionality to delete the passed address.
     *
	 * @return void
     */
    public function deleteAction() {
        try {
            // load the address ID from the request
        	$addressId = $this->_getRequest()->getParameter(
                TDProject_Core_Controller_Util_WebRequestKeys::ADDRESS_ID,
                FILTER_VALIDATE_INT
            );
            // delete the person
            $this->_getDelegate()->deleteAddress(
                TechDivision_Lang_Integer::valueOf(
                    new TechDivision_Lang_String($addressId)
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
        // return to the address overview page
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
	    // register the Block in the Request
	    $this->_getRequest()
	        ->setAttribute($path, $this->getContext()->getActionForm());
	}
}