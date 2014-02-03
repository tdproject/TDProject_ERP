<?php

/**
 * TDProject_Core_Controller_Company
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
require_once 'TDProject/ERP/Block/Company/Overview.php';
require_once 'TDProject/ERP/Block/Company/View.php';
require_once 'TDProject/ERP/Controller/Util/WebRequestKeys.php';
require_once 'TDProject/ERP/Controller/Util/MessageKeys.php';
require_once 'TDProject/ERP/Controller/Util/ErrorKeys.php';
require_once 'TDProject/ERP/Common/ValueObjects/CompanyAddressLightValue.php';
require_once 'TDProject/ERP/Common/ValueObjects/CompanyNoteLightValue.php';

/**
 * @category   	TDProject
 * @package    	TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Controller_Company
    extends TDProject_ERP_Controller_Abstract {

	/**
	 * The key for the ActionForward to the company overview template.
	 * @var string
	 */
	const COMPANY_OVERVIEW = "CompanyOverview";

	/**
	 * The key for the ActionForward to the company view template.
	 * @var string
	 */
	const COMPANY_VIEW = "CompanyView";

	/**
	 * The key for the ActionForward to the messages view template.
	 * @var string
	 */
	const MESSAGES_VIEW = "MessagesView";

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load a list with with all companies.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	public function __defaultAction()
	{
		try {
			// replace the default ActionForm
			$this->getContext()->setActionForm(
				new TDProject_ERP_Block_Company_Overview($this->getContext())
			);
            // load and register the company overview data
            $this->_getRequest()->setAttribute(
            	TDProject_ERP_Controller_Util_WebRequestKeys::OVERVIEW_DATA,
            	$this->_getDelegate()->getCompanyOverviewData()
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
		    TDProject_ERP_Controller_Company::COMPANY_OVERVIEW
		);
	}


	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load the company data with the id passed in the
	 * Request for editing it.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	public function editAction()
	{
        try {
            // load the company ID from the request
            if (($companyId = $this->_getRequest()->getAttribute(
                TDProject_ERP_Controller_Util_WebRequestKeys::COMPANY_ID)) == null) {
                $companyId = $this->_getRequest()->getParameter(
                    TDProject_ERP_Controller_Util_WebRequestKeys::COMPANY_ID,
                    FILTER_VALIDATE_INT
                );
            }
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->populate(
                $dto = $this->_getDelegate()->getCompanyViewData(
                    TechDivision_Lang_Integer::valueOf(
                        new TechDivision_Lang_String($companyId)
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
            TDProject_ERP_Controller_Company::COMPANY_VIEW
        );
	}

   /**
     * This method is automatically invoked by the controller and implements
     * the functionality to create a new company.
     *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
     */
    public function createAction() {
        try {
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->initialize(
                $this->_getDelegate()->getCompanyViewData()
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
        // return to the company detail page
        return $this->_findForward(
            TDProject_ERP_Controller_Company::COMPANY_VIEW
        );
    }

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to save the passed company data.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	public function saveAction()
	{
		try {
		    // load the ActionForm
		    $actionForm = $this->_getActionForm();
		    // validate the ActionForm with the company data
            $actionErrors = $actionForm->validate();
            if (($errorsFound = $actionErrors->size()) > 0) {
                $this->_saveActionErrors($actionErrors);
                return $this->createAction();
            }
			// save the company
			$companyId = $this->_getDelegate()->saveCompany($actionForm->repopulate());
			// store the ID of the company in the Request
			$this->_getRequest()->setAttribute(
                TDProject_ERP_Controller_Util_WebRequestKeys::COMPANY_ID,
                $companyId->intValue()
            );
			// create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_ERP_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('companyUpdate.successfull')
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
		// return to the company detail page
        return $this->editAction();
	}

	/**
     * This method is automatically invoked by the controller and implements
     * the functionality to delete the passed company.
     *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
     */
    public function deleteAction()
    {
        try {
            // load the company ID from the request
        	$companyId = $this->_getRequest()->getParameter(
                TDProject_ERP_Controller_Util_WebRequestKeys::COMPANY_ID,
                FILTER_VALIDATE_INT
            );
            // delete the company
            $this->_getDelegate()->deleteCompany(
                TechDivision_Lang_Integer::valueOf(
                    new TechDivision_Lang_String($companyId)
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
        // return to the company overview page
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