<?php

/**
 * TDProject_ERP_Controller_Note_Json
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
class TDProject_ERP_Controller_Note_Json
    extends TDProject_ERP_Controller_Abstract {

	/**
	 * The key for the ActionForward to the task view.
	 * @var string
	 */
	const JSON = "Json";

	/**
	 * This method is automatically invoked by the controller, loads
	 * the data for the note widget in the dashboard and adds the data
	 * to the Context.
	 *
	 * @return void
	 */
	public function __defaultAction()
	{
	    try {
            // load the user ID from the Request
	        $userId = $this->_getRequest()->getParameter(
                TDProject_Core_Controller_Util_WebRequestKeys::USER_ID,
                FILTER_VALIDATE_INT
            );
    	    // load the notes for the dashboard widget
            $dtos = $this->_getDelegate()->getNoteOverviewDataByUserId(
	            TechDivision_Lang_Integer::valueOf(
	                new TechDivision_Lang_String($userId)
	            )
	        );
    		// register the notes in the Request
    		$this->_getRequest()->setAttribute(
                TDProject_ERP_Controller_Util_WebRequestKeys::JSON_RESULT, $dtos
            );
	    } catch (Exception $e) {
			// create action errors container
			$errors = new TechDivision_Controller_Action_Errors();
			// add error to container
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
			        TDProject_Core_Controller_Util_ErrorKeys::SYSTEM_ERROR,
			        $e->__toString()
			    )
			);
			// save container in request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}

		// set the ActionForward in the Context
		return $this->_findForward(
		    TDProject_ERP_Controller_Note_Json::JSON
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
	    // if yes, create a new instance
	    $reflectionClass = new ReflectionClass($path);
	    $page = $reflectionClass->newInstance($this->getContext());
	    // add the Block with the ActionMessages and ActionErrors
	    $page->addBlock(new TDProject_Core_Block_Action($this->getContext()));
	    // register the Block in the Request
	    $this->_getRequest()->setAttribute($path, $page);
	}
}