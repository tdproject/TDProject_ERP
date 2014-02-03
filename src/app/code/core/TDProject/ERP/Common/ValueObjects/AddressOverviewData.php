<?php

/**
 * TDProject_ERP_Common_ValueObjects_AddressOverviewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/String.php';
require_once 'TDProject/ERP/Common/ValueObjects/AddressValue.php';
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
class TDProject_ERP_Common_ValueObjects_AddressOverviewData
    extends TDProject_ERP_Common_ValueObjects_AddressLightValue
    implements TDProject_Core_Interfaces_Block_Widget_Element_Select_Option
{
	
	/**
	 * The address country name.
	 * @var TechDivision_Lang_String
	 */
	protected $_countryName = null;		
		
	/**
	 * The constructor intializes the DTO with the
	 * values passed as parameter.
	 * 
	 * @param array $array Holds the array with the virtual members to pass to the AbstractDTO's constructor
	 * @return void
	 */
	public function __construct(TDProject_ERP_Common_ValueObjects_AddressLightValue $lvo = null) 
	{
		
		parent::__construct($lvo);
		
		$this->_countryName = new TechDivision_Lang_String();
	}

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionValue()
	 */
   	public function getOptionValue()
   	{
   		return $this->getAddressId();
   	}
   	
   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionLabel()
   	 */
   	public function getOptionLabel()
   	{
   		return $this->getFullAddress();
   	}
   	
   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::isSelected()
   	 */
   	public function isSelected(TechDivision_Lang_Object $value = null) {
   		return $this->getAddressId()->equals($value);
   	}
   	
   	/**
   	 * Set the country name.
   	 * 
   	 * @param TechDivision_Lang_String $countryName The country name
   	 */
   	public function setCountryName(TechDivision_Lang_String $countryName)
   	{
   		$this->_countryName = $countryName;
   	}
   	
   	/**
   	 * Returns the country name.
   	 * 
   	 * @return TechDivision_Lang_String The country name
   	 */
   	public function getCountryName()
   	{
   		return $this->_countryName;
   	}
   	
   	/**
   	 * Returns the full concatenated address.
   	 * 
   	 * @return TechDivision_Lang_String
   	 * 		The full concatenated address
   	 */
   	public function getFullAddress() {
        // initialize the array for the name parts
        $address = array();
        // add the address parts
        $address[] = $this->getStreet()->stringValue();
        $address[] = $this->getPostcode()->stringValue();
        $address[] = $this->getCity()->stringValue();
        $address[] = $this->getCountryName()->stringValue();
        // implode the parts and return the concatenated address
        return new TechDivision_Lang_String(implode(', ', $address));
   	}
}