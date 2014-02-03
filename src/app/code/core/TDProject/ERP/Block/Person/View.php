<?php

/**
 * TDProject_Core_Block_Person_View
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Controller/Action/Error.php';
require_once 'TechDivision/Controller/Action/Errors.php';
require_once 'TechDivision/Collections/CollectionUtils.php';
require_once 'TechDivision/Collections/Interfaces/Collection.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TechDivision/Collections/Dictionary.php';
require_once 'TDProject/Core/Controller/Util/ErrorKeys.php';
require_once 'TDProject/Core/Block/Widget/Element/Input/Hidden.php';
require_once 'TDProject/ERP/Block/Abstract/Person.php';
require_once 'TDProject/ERP/Common/ValueObjects/PersonViewData.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Checkbox.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Select.php';
require_once 'TDProject/ERP/Block/Person/View/Address.php';
require_once 'TDProject/ERP/Block/Person/View/AddressSortComparator.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions/JavaScript.php';

/**
 * @category    TDProject
 * @package     TDProject_ERP
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Block_Person_View
	extends TDProject_ERP_Block_Abstract_Person {

    /**
     * The available salutations.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_salutations = null;

    /**
     * The available companies.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_companies = null;

    /**
     * The available users.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_users = null;

    /**
     * The person's addresses.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_addresses = null;

    /**
     * The available address types.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_addressTypes = null;

    /**
     * Enter description here ...
     * @var TechDivision_Collections_ArrayList
     */
    protected $_addressIdFk = array();

    /**
     * Enter description here ...
     * @var TechDivision_Collections_HashMap
     */
    protected $_addressTypeIdFk = array();

    /**
     * Getter method for the available companies.
     *
     * @return TechDivision_Lang_Integer The available companies
     */
    public function getCompanies() {
        return $this->_companies;
    }

    /**
     * Setter method for the available companies.
     *
     * @param TechDivision_Collections_Interfaces_Collection $companies The available companies
     * @return void
     */
    public function setCompanies(
        TechDivision_Collections_Interfaces_Collection $companies) {
        $this->_companies = $companies;
    }

    /**
     * Getter method for the available salutations.
     *
     * @return TechDivision_Lang_Integer The available salutations
     */
    public function getSalutations()
    {
        return $this->_salutations;
    }

    /**
     * Setter method for the available salutations.
     *
     * @param TechDivision_Collections_Interfaces_Collection $salutations The available salutations
     * @return void
     */
    public function setSalutations(
        TechDivision_Collections_Interfaces_Collection $salutations) {
        $this->_salutations = $salutations;
    }

    /**
     * Getter method for the available users.
     *
     * @return TechDivision_Lang_Integer The available users
     */
    public function getUsers()
    {
        return $this->_users;
    }

    /**
     * Setter method for the available users.
     *
     * @param TechDivision_Collections_Interfaces_Collection $users The available users
     * @return void
     */
    public function setUsers(
        TechDivision_Collections_Interfaces_Collection $users) {
        $this->_users = $users;
    }

    /**
     * Getter method for the person's addresses.
     *
     * @return TechDivision_Lang_Integer The person's addresses
     */
    public function getAddresses()
    {
    	return $this->_addresses;
    }

    /**
     * Setter method for the person's addresss.
     *
     * @param TechDivision_Collections_Interfaces_Collection $persons The person's addresses.
     * @return void
     */
    public function setAddresses(
        TechDivision_Collections_Interfaces_Collection $addresses) {
        $this->_addresses = $addresses;
    }

    /**
     * Getter method for the available address types.
     *
     * @return TechDivision_Collections_Interfaces_Collection The available address types
     */
    public function getAddressTypes()
    {
        return $this->_addressTypes;
    }

    /**
     * Setter method for the available address types.
     *
     * @param TechDivision_Collections_Interfaces_Collection $addressTypes The available address types.
     * @return void
     */
    public function setAddressTypes(
        TechDivision_Collections_Interfaces_Collection $addressTypes) {
        $this->_addressTypes = $addressTypes;
    }

    /**
     * Getter method for the selected person-address relations.
     *
     * @return array The selected person-address relations
     */
    public function getAddressIdFk()
    {
        return $this->_addressIdFk;
    }

    /**
     * Setter method for the selected person-address relations.
     *
     * @param array $addressIdFk The selected person-address relations.
     * @return void
     */
    public function setAddressIdFk(array $addressIdFk)
    {
    	foreach ($addressIdFk as $value) {
        	$this->_addressIdFk->add((integer) $value);
    	}
    }

    /**
     * Getter method for the address types of the selected
     * person-address relations.
     *
     * @return array
     * 		The selected address types of the selected person-address relations
     */
    public function getAddressTypeIdFk()
    {
        return $this->_addressTypeIdFk;
    }

    /**
     * Setter method for the address types of the selected person-address relations.
     *
     * @param array $addressTypeIdFk The address types of the selected person-address relations.
     * @return void
     */
    public function setAddressTypeIdFk(array $addressTypeIdFk)
    {
    	foreach ($addressTypeIdFk as $key => $value) {
        	$this->_addressTypeIdFk->add((integer) $key, (integer) $value);
    	}
    }

    /**
     * Sorts the addresses according if the address is related
     * with the company or not.
     *
     * @return TDProject_ERP_Block_Person_View
     * 		The instance itself
     */
    protected function _sortAddresses()
    {
    	// sort the addresses
        TechDivision_Collections_CollectionUtils::sort(
    		$this->_addresses,
        	new TDProject_ERP_Block_Person_View_AddressSortComparator(
        		$this->getAddressIdFk()
        	)
        );
        // return the instance
        return $this;
    }

    /**
     * Returns the callback URL after creating/editing an
     * address.
     *
     * @return string The URL with the callback method added
     */
    public function getCallbackUrl($method = 'edit')
    {
        // initialize the params to add to the URL
        $params = array(
            TechDivision_Controller_Action_Controller::ACTION_PATH => '/person',
            TDProject_ERP_Controller_Util_WebRequestKeys::METHOD => $method,
            TDProject_ERP_Controller_Util_WebRequestKeys::PERSON_ID =>
                $this->_dto->getPersonId()
        );
        // create and return the URL
        return $this->getUrl($params);
    }

    /**
     * Resets all member variables to their
     * default values.
     *
     * @return void
     */
    public function reset()
    {
    	parent::reset();
        $this->_companies = new TechDivision_Collections_ArrayList();
        $this->_salutations = new TechDivision_Collections_ArrayList();
        $this->_users = new TechDivision_Collections_ArrayList();
        $this->_addresses = new TechDivision_Collections_ArrayList();
        $this->_addressTypes = new TechDivision_Collections_ArrayList();
        $this->_addressIdFk = new TechDivision_Collections_ArrayList();
        $this->_addressTypeIdFk = new TechDivision_Collections_HashMap();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Company::repopulate()
     */
    public function repopulate()
    {
		// initialize a new DTO
		$dto = new TDProject_ERP_Common_ValueObjects_PersonViewData();
		// filling it with the person data from the Request
		$dto->setPersonId($this->getPersonId());
		$dto->setSalutationIdFk($this->getSalutationIdFk());
		$userIdFk = $this->getUserIdFk();
		if (!$userIdFk->equals(new TechDivision_Lang_Integer(0))) {
		    $dto->setUserIdFk($userIdFk);
		}
		$companyIdFk = $this->getCompanyIdFk();
		if (!$companyIdFk->equals(new TechDivision_Lang_Integer(0))) {
		    $dto->setCompanyIdFk($companyIdFk);
		}
		$dto->setPosition($this->getPosition());
		$dto->setFirstname($this->getFirstname());
		$dto->setLastname($this->getLastname());
		$dto->setTitle($this->getTitle());
		$dto->setEmail($this->getEmail());
		$dto->setPhone($this->getPhone());
		$dto->setTelefax($this->getTelefax());
		$dto->setMobile($this->getMobile());
		$dto->setAddressIdFk($this->getAddressIdFk());
		$dto->setAddressTypeIdFk($this->getAddressTypeIdFk());
		// return the initialized DTO
		return $dto;
    }

    /**
     * Initializes the ActionForm with the values
     * of the passed DTO.
     *
     * @param TDProject_ERP_Common_ValueObjects_PersonViewData $dto
     * 		The DTO with the data to initialize the ActionForm with
     * @return void
     * @see TDProject_ERP_Block_Person_View::populate();
     */
    public function initialize(
        TDProject_ERP_Common_ValueObjects_PersonViewData $dto) {
        $this->_companies = $dto->getCompanies();
        $this->_salutations = $dto->getSalutations();
        $this->_users = $dto->getUsers();
        $this->_addresses = $dto->getAddresses();
        $this->_addressTypes = $dto->getAddressTypes();
        $this->_addressIdFk = $dto->getAddressIdFk();
        $this->_addressTypeIdFk = $dto->getAddressTypeIdFk();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Person::populate()
     */
    public function populate(
        TDProject_ERP_Common_ValueObjects_PersonViewData $dto) {
    	parent::populate($dto);
    	$this->initialize($dto);
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Person::getDeleteUrl()
     */
    public function getDeleteUrl()
    {
    	return '?path=' .
    	    $this->getPath() .
    	    '&method=delete&personId=' .
    	    $this->getPersonId();
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout() {
    	// initialize the tabs
    	$tabs = $this->addTabs(
    		'tabs',
    		$this->translate('person.view.tabs.label.person')
    	);
        // add the tab for the person data
        $tabs->addTab(
        	'person',
        	$this->translate('person.view.tab.label.base-data')
        )
    	->addFieldset(
    		'person',
    		$this->translate('person.view.fieldset.label.base-data')
    	)
    	->addElement(
    	    $this->getElement(
    	    	'select',
    	    	'salutationIdFk',
    	    	$this->translate('person.view.label.salutation')
    	    )->setOptions($this->getSalutations())
    	)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'firstname',
		    	$this->translate('person.view.label.firstname')
		    )
		)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'lastname',
		    	$this->translate('person.view.label.lastname')
		    )->setMandatory()
		)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'title',
		    	$this->translate('person.view.label.title')
		    )
		)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'position',
		    	$this->translate('person.view.label.position')
		    )
		)
    	->addElement(
    	    $this->getElement(
    	    	'select',
    	    	'companyIdFk',
    	    	$this->translate('person.view.label.company')
    	    )->setOptions($this->getCompanies())->setDummyOption()
    	);
        // add the tab for the contact data
        $tabs->addTab(
        	'contact-data',
        	$this->translate('person.view.tab.label.contact-data')
        )
    	->addFieldset(
    		'contact-dat',
    		$this->translate('person.view.fieldset.label.contact-data')
    	)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'email',
		    	$this->translate('person.view.label.email')
		    )
		)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'phone',
		    	$this->translate('person.view.label.phone')
		    )
		)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'telefax',
		    	$this->translate('person.view.label.telefax')
		    )
		)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'mobile',
		    	$this->translate('person.view.label.mobile')
		    )
		);
        // add the tab for the account data
        $tabs->addTab(
        	'account',
        	$this->translate('person.view.tab.label.account')
        )
        ->addFieldset(
        	'account',
        	$this->translate('person.view.fieldset.label.account')
        )
	    ->addElement(
	        $this->getElement(
	        	'select',
	        	'userIdFk',
	        	$this->translate('person.view.label.account')
	        )->setOptions($this->getUsers())->setDummyOption()
	    );
	    /**
	     * Add the button to create a new address and
	     * the tab for the address data if in edit mode
	     */
    	if (!$this->getPersonId()->equals(new TechDivision_Lang_Integer(0))) {
			// add the tab for the address data
		    $tabAddress =
		        $tabs->addTab(
		        	'address',
		        	$this->translate('person.view.tab.label.address')
		        )
		    	->addGrid($this->_prepareAddressGrid())
		    	->addBlock(
		    	    new TDProject_ERP_Block_Person_View_Address(
		    	        $this->getContext()
		    	    )
		    	);
		    // add the button to create a new address
    		$button = new TDProject_Core_Block_Widget_Button(
    		    $this->getContext(),
    		    'createAddress',
    		    $this->translate('person.view.button.label.new-address')
    		);
    		$button
    			->setOnClick('createAddress(); return false;')
    			->bindToTab($tabAddress);
			// add the button to the toolbar
			$this->getToolbar()->addButton($button);
    	}
	    // return the instance itself
	    return parent::prepareLayout();
    }

    /**
     * Initializes and returns the grid for the addresses.
     *
     * @return TDProject_Core_Block_Widget_Grid
     * 		The initialized grid
     */
    protected function _prepareAddressGrid() {
    	// instanciate the grid
    	$grid = new TDProject_Core_Block_Widget_Grid(
    	    $this,
    	    'addressGrid',
    	    $this->translate('person.view.grid.label.addresses')
    	);
    	// set the collection with the data to render
    	$grid->setCollection($this->_sortAddresses()->getAddresses());
    	// add the columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column_Checkbox(
    	    	'addressIdFk', '', 5)
    	    )
    		->setCheckedUrl(
    			'?path=/person/ajax&method=relatePersonAddress&personId=' .
    		    $this->getPersonId()
    		)
    		->setUncheckedUrl(
    			'?path=/person/ajax&method=unrelatePersonAddress&personId=' .
    		    $this->getPersonId()
    		)
    		->setProperty('addressId')
    		->setSourceCollection($this->getAddressIdFk())
    		->setTargetProperty('addressId');
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'addressId',
    	    	$this->translate(
    	    		'person.view.grid.addresses.column.label.id'
    	    	),
    	        5
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'fullAddress',
    	    	$this->translate(
    	    		'person.view.grid.addresses.column.label.address'
    	    	),
    	        70
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column_Select(
    	    	'addressTypeIdFk',
    	    	$this->translate(
    	    		'person.view.grid.addresses.column.label.type'
    	    	),
    	        10
    	    )
    	)
		->setOptions($this->getAddressTypes())
		->setOptionProperty('addressTypeIdFk')
		->setSourceCollection($this->getAddressTypeIdFk())
		->setTargetProperty('addressId');
    	// add the actions
    	$action = new TDProject_Core_Block_Widget_Grid_Column_Actions(
    		'actions',
	    	$this->translate(
	    		'person.view.grid.addresses.column.label.actions'
	    	),
    	    10
    	);
    	// to avoid the usual redirect, because using AJAX in this case
    	$action->setOnChange('javascript:void(0);');
    	$action->addAction(
    		new TDProject_Core_Block_Widget_Grid_Column_Actions_JavaScript(
    		    $this->getContext(),
    			'addressId',
    	    	$this->translate(
    	    		'person.view.grid.addresses.column.label.action.edit'
    	    	),
    			'return loadAddress($(this).val());'
    		)
    	);
    	$grid->addColumn($action);
    	// return the initialized instance
    	return $grid;
    }

    /**
     * This method checks if the values in the member variables
     * holds valiid data. If not, a ActionErrors container will
     * be initialized an for every incorrect value a ActionError
     * object with the apropriate error message will be added.
     *
     * @return ActionErrors
     * 		Returns a ActionErrors container with ActionError objects
     */
    function validate()
    {
        // initialize the ActionErrors
        $errors = new TechDivision_Controller_Action_Errors();
        // check if a lastname was entered
        if ($this->_lastname->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_ERP_Controller_Util_ErrorKeys::LASTNAME,
                    $this->translate('lastname.none')
                )
            );
        }
        // check if a email was entered
        if ($this->_email->length() > 0) {
	        // if yes, check if a valid email was entered
	        if (filter_var($this->_email, FILTER_VALIDATE_EMAIL) === false) {
	            $errors->addActionError(
	                new TechDivision_Controller_Action_Error(
    	                TDProject_ERP_Controller_Util_ErrorKeys::EMAIL,
    	                $this->translate('email.invalid')
	                )
	            );
	        }
        }
        // return the ActionErrors
        return $errors;
    }
}