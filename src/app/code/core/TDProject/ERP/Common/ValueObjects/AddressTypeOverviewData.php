<?php

/**
 * TDProject_ERP_Common_ValueObjects_AddressTypeOverviewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element/Select/Option.php';
require_once 'TDProject/ERP/Common/ValueObjects/AddressTypeLightValue.php';

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
class TDProject_ERP_Common_ValueObjects_AddressTypeOverviewData
    extends TDProject_ERP_Common_ValueObjects_AddressTypeLightValue
    implements TDProject_Core_Interfaces_Block_Widget_Element_Select_Option {

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option
	 * 			::getOptionValue()
	 */
   	public function getOptionValue()
   	{
   		return $this->getAddressTypeId();
   	}

   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option
   	 * 			::getOptionLabel()
   	 */
   	public function getOptionLabel()
   	{
   		return $this->getName();
   	}

   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option
   	 * 			::isSelected()
   	 */
   	public function isSelected(TechDivision_Lang_Object $value = null)
   	{
   		return $this->getAddressTypeId()->equals($value);
   	}
}