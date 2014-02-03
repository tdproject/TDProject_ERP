<?php

/**
 * TDProject_ERP_Common_ValueObjects_CountryOverviewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/ERP/Common/ValueObjects/CountryLightValue.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element/Select/Option.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the company overview.
 * 
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Common_ValueObjects_CountryOverviewData
    extends TDProject_ERP_Common_ValueObjects_CountryLightValue
    implements TDProject_Core_Interfaces_Block_Widget_Element_Select_Option {

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionValue()
	 */
   	public function getOptionValue() {
   		return $this->getCountryId();
   	}
   	
   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionLabel()
   	 */
   	public function getOptionLabel() {
   		return $this->getName();
   	}
   	
   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::isSelected()
   	 */
   	public function isSelected(TechDivision_Lang_Object $value = null) {
   		return $this->getCountryId()->equals($value);
   	}
}