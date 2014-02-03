<?php

/**
 * TDProject_ERP_Block_Dashboard_Widget_Note
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TDProject/Application.php';
require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TDProject/Core/Controller/Util/WebRequestKeys.php';
require_once 'TDProject/ERP/Common/ValueObjects/NoteOverviewData.php';
require_once 'TDProject/ERP/Controller/Util/WebRequestKeys.php';

/**
 * @category    TDProject
 * @package     TDProject_ERP
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Block_Dashboard_Widget_Note
    extends TDProject_Core_Block_Abstract {

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context) {
        // set the template name
        $this->_setTemplate(
        	'www/design/erp/templates/dashboard/widget/note.phtml'
        );
        // call the parent constructor
        parent::__construct($context);
    }

    /**
     * Assembles and returns the serialized data.
     *
     * @return TechDivision_Collections_ArrayList
     * 		The assembled NoteOverviewData DTO's
     */
    public function getDataSource()
    {
        // initialize the params of the URL to invoke to load the notes
        $params = array(
            TechDivision_Controller_Action_Controller::ACTION_PATH =>
            	'/note/json',
            TDProject_ERP_Controller_Util_WebRequestKeys::METHOD =>
            	'__default',
            TDProject_Core_Controller_Util_WebRequestKeys::USER_ID =>
                $this->getSystemUser()->getUserId()
        );
        // invoke the URL and read the serialized data
        return $this->getUrl($params);
    }
}