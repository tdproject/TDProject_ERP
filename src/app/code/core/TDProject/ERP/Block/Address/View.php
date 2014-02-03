<?php

/**
 * TDProject_Core_Block_Address_View
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Form/Ajax/Abstract.php';
require_once 'TDProject/Core/Block/Widget/Button.php';

/**
 * @category    TDProject
 * @package     TDProject_ERP
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Block_Address_View
    extends TDProject_Core_Block_Widget_Form_Ajax_Abstract {

    /**
     * Form variable for the addressId.
     * @var TechDivision_Lang_Integer
     */
    protected $_addressId = null;

    /**
     * Form variable for the countryIdFk.
     * @var TechDivision_Lang_Integer
     */
    protected $_countryIdFk = null;

    /**
     * Form variable for the street.
     * @var TechDivision_Lang_String
     */
    protected $_street = null;

    /**
     * Form variable for the number.
     * @var TechDivision_Lang_String
     */
    protected $_number = null;

    /**
     * Form variable for the state.
     * @var TechDivision_Lang_String
     */
    protected $_state = null;

    /**
     * Form variable for the postcode.
     * @var TechDivision_Lang_String
     */
    protected $_postcode = null;

    /**
     * Form variable for the city.
     * @var TechDivision_Lang_String
     */
    protected $_city = null;

    /**
     * Form variable for the postOfficeBox.
     * @var TechDivision_Lang_String
     */
    protected $_postOfficeBox = null;

    /**
     * The available countries.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_countries = null;

    /**
     * Getter method for variable addressId.
     *
     * @return TechDivision_Lang_Integer The addressId
     */
    public function getAddressId()
    {
        return $this->_addressId;
    }

    /**
     * Setter method for variable addressId.
     *
     * @param integer $string The addressId
     * @return void
     */
    public function setAddressId($string)
    {
        $this->_addressId = TechDivision_Lang_Integer::valueOf(
            new TechDivision_Lang_String($string)
        );
    }

    /**
     * Getter method for variable countryIdFk.
     *
     * @return TechDivision_Lang_Integer The countryIdFk
     */
    public function getCountryIdFk()
    {
        return $this->_countryIdFk;
    }

    /**
     * Setter method for variable countryIdFk.
     *
     * @param $string The countryIdFk
     * @return void
     */
    public function setCountryIdFk($string)
    {
        $this->_countryIdFk = TechDivision_Lang_Integer::valueOf(
            new TechDivision_Lang_String($string)
        );
    }

    /**
     * Getter method for variable street.
     *
     * @return TechDivision_Lang_String The street
     */
    public function getStreet()
    {
        return $this->_street;
    }

    /**
     * Setter method for variable street.
     *
     * @param string $string The street
     * @return void
     */
    public function setStreet($string)
    {
        $this->_street = new TechDivision_Lang_String($string);
    }

    /**
     * Getter method for variable number.
     *
     * @return TechDivision_Lang_String The number
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * Setter method for variable number.
     *
     * @param string $string The number
     * @return void
     */
    public function setNumber($string)
    {
        $this->_number = new TechDivision_Lang_String($string);
    }

    /**
     * Getter method for variable state.
     *
     * @return TechDivision_Lang_String The state
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Setter method for variable state.
     *
     * @param string $string The state
     * @return void
     */
    public function setState($string)
    {
        $this->_state = new TechDivision_Lang_String($string);
    }

    /**
     * Getter method for variable postcode.
     *
     * @return TechDivision_Lang_String The postcode
     */
    public function getPostcode()
    {
        return $this->_postcode;
    }

    /**
     * Setter method for variable postcode.
     *
     * @param string $string The postcode
     * @return void
     */
    public function setPostcode($string)
    {
        $this->_postcode = new TechDivision_Lang_String($string);
    }

    /**
     * Getter method for variable city.
     *
     * @return TechDivision_Lang_String The city
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * Setter method for variable city.
     *
     * @param string $string The city
     * @return void
     */
    public function setCity($string)
    {
        $this->_city = new TechDivision_Lang_String($string);
    }

    /**
     * Getter method for variable postOfficeBox.
     *
     * @return TechDivision_Lang_String The postOfficeBox
     */
    public function getPostOfficeBox()
    {
        return $this->_postOfficeBox;
    }

    /**
     * Setter method for variable postOfficeBox.
     *
     * @param string $string The postOfficeBox
     * @return void
     */
    public function setPostOfficeBox($string)
    {
        $this->_postOfficeBox = new TechDivision_Lang_String($string);
    }

    /**
     * Getter method for the available countries.
     *
     * @return TechDivision_Lang_Integer The available countries
     */
    public function getCountries()
    {
        return $this->_countries;
    }

    /**
     * Setter method for the available countries.
     *
     * @param TechDivision_Collections_Interfaces_Collection $countries The available countries
     * @return void
     */
    public function setCountries(
        TechDivision_Collections_Interfaces_Collection $countries) {
        $this->_countries = $countries;
    }

    /**
     * Resets all member variables to their
     * default values.
     *
     * @return void
     */
    public function reset()
    {
    	$this->_addressId = new TechDivision_Lang_Integer(0);
    	$this->_countryIdFk = new TechDivision_Lang_Integer(0);
        $this->_street = new TechDivision_Lang_String();
        $this->_number = new TechDivision_Lang_String();
        $this->_state = new TechDivision_Lang_String();
        $this->_postcode = new TechDivision_Lang_String();
        $this->_city = new TechDivision_Lang_String();
        $this->_postOfficeBox= new TechDivision_Lang_String();
        $this->_countries = new TechDivision_Collections_ArrayList();
    }

    /**
     * Populates the ActionForm with the values
     * of the passed DTO.
     *
     * @param TDProject_ERP_Common_ValueObjects_AddressViewData $dto
     * 		The DTO with the data to initialize the ActionForm with
     * @return void
     * @see TDProject_ERP_Block_Address_View::populate()
     */
    public function initialize(
        TDProject_ERP_Common_ValueObjects_AddressViewData $dto) {
        $this->_countries = $dto->getCountries();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Address_View::populate()
     */
    public function populate(
        TDProject_ERP_Common_ValueObjects_AddressViewData $dto) {
    	$this->_addressId = $dto->getAddressId();
    	$this->_countryIdFk = $dto->getCountryIdFk();
        $this->_street = $dto->getStreet();
        $this->_number = $dto->getNumber();
        $this->_state = $dto->getState();
        $this->_postcode = $dto->getPostcode();
        $this->_city = $dto->getCity();
        $this->_postOfficeBox = $dto->getPostOfficeBox();
        // initialize the ActionForm
        $this->initialize($dto);
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Company::repopulate()
     */
    public function repopulate()
    {
		// initialize a new DTO
		$dto = new TDProject_ERP_Common_ValueObjects_AddressViewData();
		// filling it with the address data from the Request
		$dto->setAddressId($this->getAddressId());
		$dto->setCountryIdFk($this->getCountryIdFk());
		$dto->setStreet($this->getStreet());
		$dto->setNumber($this->getNumber());
		$dto->setState($this->getState());
		$dto->setPostcode($this->getPostcode());
		$dto->setCity($this->getCity());
		$dto->setPostOfficeBox($this->getPostOfficeBox());
		// return the initialized DTO
		return $dto;
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {
    	// add the hidden element with the address ID
        $this->addElement($this->getElement('hidden', 'addressId'));
    	// initialize the fieldset
    	$fieldset = new TDProject_Core_Block_Widget_Fieldset(
    	    $this->getContext(),
    	    'address',
    	    $this->translate('address.view.fieldset.label.edit-address')
    	);
    	// add the elements
    	$fieldset
        	->addElement(
        	    $this->getElement(
        	    	'textfield',
        	    	'street',
        	    	$this->translate('address.view.label.street')
        	    )
        	)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'number',
    		    	$this->translate('address.view.label.house-number')
    		    )
    		)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'state',
    		    	$this->translate('address.view.label.state')
    		    )
    		)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'postcode',
    		    	$this->translate('address.view.label.postcode')
    		    )->setMandatory()
    		)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'city',
    		    	$this->translate('address.view.label.city')
    		    )->setMandatory()
    		)
    		->addElement(
    		    $this->getElement(
        		    'textfield',
        		    'postOfficeBox',
        		    $this->translate('address.view.label.post-office-box')
    		    )
    		)
        	->addElement(
        	    $this->getElement(
        	    	'select',
        	    	'countryIdFk',
        	    	$this->translate('address.view.label.country')
        	    )->setOptions($this->getCountries())
        	);
        // add the fieldset
        $this->addBlock($fieldset);
        // add the button to the Toolbar
        $this->getToolbar()->addButton(
        	$button = new TDProject_Core_Block_Widget_Button(
        	    $this->getContext(),
        	    'saveAddress',
        	    $this->translate('address.view.button.label.save-address')
        	)
        );
        // set the buttons click event
        $button->setOnClick(
        	'$("#' . $this->getFormName() . '").submit(); return false;'
        );
        $button->setIcon('ui-icon-disk');
	    // return the instance itself
	    return parent::prepareLayout();
    }

    /**
     * This method checks if the values in the member variables
     * holds valiid data. If not, a ActionErrors container will
     * be initialized an for every incorrect value a ActionError
     * object with the apropriate error message will be added.
     *
     * @return ActionErrors Returns a ActionErrors container with ActionError objects
     */
    function validate()
    {
        // initialize the ActionErrors
        $errors = new TechDivision_Controller_Action_Errors();
        // check if a postcode was entered
        if ($this->_postcode->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_ERP_Controller_Util_ErrorKeys::POSTCODE,
                    $this->translate('postcode.none')
                )
            );
        }
        // check if a city was entered
        if ($this->_city->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_ERP_Controller_Util_ErrorKeys::CITY,
                    $this->translate('city.none')
                )
            );
        }
        // return the ActionErrors
        return $errors;
    }
}