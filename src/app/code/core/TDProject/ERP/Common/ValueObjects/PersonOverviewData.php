<?php

/**
 * TDProject_ERP_Common_ValueObjects_PersonOverviewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/String.php';
require_once 'TDProject/ERP/Common/ValueObjects/PersonValue.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the dashboard view.
 * 
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Common_ValueObjects_PersonOverviewData
    extends TDProject_ERP_Common_ValueObjects_PersonLightValue {
        
    /**
     * Returns the person's full name.
     * 
     * @param TechDivision_Lang_String
     * 		The person's full name
     */
    public function getFullName()
    {
        return new TechDivision_Lang_String(
        	$this->getLastname() .', '. $this->getFirstname()
        );
    }
}