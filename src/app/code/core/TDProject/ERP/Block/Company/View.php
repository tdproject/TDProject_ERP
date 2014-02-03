<?php

/**
 * TDProject_Core_Block_Company_View
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
require_once 'TDProject/ERP/Block/Abstract/Company.php';
require_once 'TDProject/ERP/Common/ValueObjects/CompanyViewData.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Checkbox.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Select.php';
require_once 'TDProject/ERP/Block/Company/View/Address.php';
require_once 'TDProject/ERP/Block/Company/View/AddressSortComparator.php';
require_once 'TDProject/ERP/Block/Company/View/PersonSortComparator.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions/JavaScript.php';

/**
 * @category    TDProject
 * @package     TDProject_ERP
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Block_Company_View
	extends TDProject_ERP_Block_Abstract_Company {

    /**
     * The available companies.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_companies = null;

    /**
     * The company's employees.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_persons = null;

    /**
     * The company's addresses.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_addresses = null;

    /**
     * The ID's of the related addresses.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_addressIdFk = array();

    /**
     * The ID's of the related persons.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_personIdFk = array();

    /**
     * The ID's of the related address types.
     * @var TechDivision_Collections_HashMap
     */
    protected $_addressTypeIdFk = array();

    /**
     * Getter method for the available companies.
     *
     * @return TechDivision_Lang_Integer The available companies
     */
    public function getCompanies()
    {
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
     * Getter method for the company's employees.
     *
     * @return TechDivision_Lang_Integer The company's employees
     */
    public function getPersons()
    {
        return $this->_persons;
    }

    /**
     * Setter method for the company's employees.
     *
     * @param TechDivision_Collections_Interfaces_Collection $persons The company's employees.
     * @return void
     */
    public function setPersons(
        TechDivision_Collections_Interfaces_Collection $persons) {
        $this->_person = $persons;
    }

    /**
     * Getter method for the company's addresses.
     *
     * @return TechDivision_Lang_Integer The company's addresses
     */
    public function getAddresses()
    {
        return $this->_addresses;
    }

    /**
     * Setter method for the company's addresss.
     *
     * @param TechDivision_Collections_Interfaces_Collection $persons The company's addresses.
     * @return void
     */
    public function setAddresses(
        TechDivision_Collections_Interfaces_Collection $addresses) {
        $this->_addresses = $addresses;
    }

    /**
     * Getter method for the company-address relations.
     *
     * @return TechDivision_Lang_Integer The company-address relations
     */
    public function getCompanyAddresses()
    {
        return $this->_companyAddresses;
    }

    /**
     * Setter method for the company-address relations.
     *
     * @param TechDivision_Collections_Interfaces_Collection $persons The company-address relations.
     * @return void
     */
    public function setCompanyAddresses(
        TechDivision_Collections_Interfaces_Collection $companyAddresses) {
        $this->_companyAddresses = $companyAddresses;
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
        foreach ($addressTypes as $addressType) {
            $this->_addressTypes->add($addressType->trsl($this));
        }
    }

    /**
     * Getter method for the selected company-address relations.
     *
     * @return array The selected company-address relations
     */
    public function getAddressIdFk()
    {
        return $this->_addressIdFk;
    }

    /**
     * Setter method for the selected company-address relations.
     *
     * @param array $addressIdFk The selected company-address relations.
     * @return void
     */
    public function setAddressIdFk(array $addressIdFk)
    {
    	foreach ($addressIdFk as $value) {
        	$this->_addressIdFk->add((integer) $value);
    	}
    }

    /**
     * Getter method for the selected company-address relations.
     *
     * @return array The selected company-address relations
     */
    public function getPersonIdFk()
    {
        return $this->_personIdFk;
    }

    /**
     * Setter method for the selected company-address relations.
     *
     * @param array $personIdFk The selected company-address relations.
     * @return void
     */
    public function setPersonIdFk(array $personIdFk)
    {
    	foreach ($personIdFk as $value) {
        	$this->_personIdFk->add((integer) $value);
    	}
    }

    /**
     * Getter method for the address types of the selected
     * company-address relations.
     *
     * @return array
     * 		The selected address types of the selected company-address relations
     */
    public function getAddressTypeIdFk()
    {
        return $this->_addressTypeIdFk;
    }

    /**
     * Setter method for the address types of the selected company-address
     * relations.
     *
     * @param array $addressTypeIdFk
     * 		The address types of the selected company-address relations.
     * @return void
     */
    public function setAddressTypeIdFk(array $addressTypeIdFk)
    {
    	foreach ($addressTypeIdFk as $key => $value) {
        	$this->_addressTypeIdFk->add((integer) $key, (integer) $value);
    	}
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Company::reset()
     */
    public function reset()
    {
    	parent::reset();
        $this->_companies = new TechDivision_Collections_ArrayList();
        $this->_addresses = new TechDivision_Collections_ArrayList();
        $this->_persons = new TechDivision_Collections_ArrayList();
        $this->_companyAddresses = new TechDivision_Collections_ArrayList();
        $this->_addressTypes = new TechDivision_Collections_ArrayList();
        $this->_personIdFk = new TechDivision_Collections_ArrayList();
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
		$dto = new TDProject_ERP_Common_ValueObjects_CompanyViewData();
		// filling it with the company data from the Request
		$dto->setCompanyId($this->getCompanyId());
		$companyIdFk = $this->getCompanyIdFk();
		if (!$companyIdFk->equals(new TechDivision_Lang_Integer(0))) {
		    $dto->setCompanyIdFk($companyIdFk);
		}
		$dto->setName($this->getName());
		$dto->setAdditionalName($this->getAdditionalName());
		$dto->setEmail($this->getEmail());
		$dto->setPhone($this->getPhone());
		$dto->setTelefax($this->getTelefax());
		$dto->setWebsite($this->getWebsite());
		$dto->setAddressIdFk($this->getAddressIdFk());
		$dto->setAddressTypeIdFk($this->getAddressTypeIdFk());
		$dto->setPersonIdFk($this->getPersonIdFk());
		$dto->setCustomerNumber($this->getCustomerNumber());
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
        TDProject_ERP_Common_ValueObjects_CompanyViewData $dto) {
        $this->_companies = $dto->getCompanies();
        $this->_addresses = $dto->getAddresses();
        $this->_persons = $dto->getPersons();
        $this->_companyAddresses = $dto->getCompanyAddresses();
        $this->_addressTypes = $dto->getAddressTypes();
        $this->_addressIdFk = $dto->getAddressIdFk();
        $this->_addressTypeIdFk = $dto->getAddressTypeIdFk();
        $this->_personIdFk = $dto->getPersonIdFk();
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Company::populate()
     */
    public function populate(
        TDProject_ERP_Common_ValueObjects_CompanyViewData $dto) {
    	parent::populate($dto);
    	$this->initialize($dto);
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Company::getDeleteUrl()
     */
    public function getDeleteUrl()
    {
    	return '?path=' .
    	    $this->getPath() .
    	    '&method=delete&companyId=' .
    	    $this->getCompanyId();
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {
    	// initialize the tabs
    	$tabs = $this->addTabs(
    		'tabs',
    		$this->translate('company.view.tabs.label.company')
    	);
        // add the tab for the company data
        $tabCompany = $tabs->addTab(
        	'company',
        	$this->translate('company.view.tab.label.base-data')
        );
        // add fieldset for company base data
        $tabCompany
        	->addFieldset(
        		'company',
        		$this->translate('company.view.fieldset.label.base-data')
        	)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'name',
    		    	$this->translate('company.view.label.name')
    		    )->setMandatory()
    		)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'additionalName',
    		    	$this->translate('company.view.label.additional-name')
    		    )
    		)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'email',
    		    	$this->translate('company.view.label.email')
    		    )
    		)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'phone',
    		    	$this->translate('company.view.label.phone')
    		    )
    		)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'telefax',
    		    	$this->translate('company.view.label.telefax')
    		    )
    		)
    		->addElement(
    		    $this->getElement(
    		    	'textfield',
    		    	'website',
    		    	$this->translate('company.view.label.website')
    		    )
    		)
        	->addElement(
        	    $this->getElement(
        	    	'select',
        	    	'companyIdFk',
        	    	$this->translate('company.view.label.related-company')
        	    )->setOptions($this->getCompanies())->setDummyOption()
        	);
		// add fieldset for storing data of specific external
		// systems, e. g. a ERP system
	    $tabCompany
        	->addFieldset(
        		'external',
        		$this->translate('company.view.fieldset.label.external')
        	)
        	->addElement(
        	    $this->getElement(
        	    	'textfield',
        	    	'customerNumber',
        	    	$this->translate('company.view.label.customer-number')
        	    )
        	);

		/**
	     * Add the button to create a new address and
	     * the tab for the address and person relation data if in edit mode
	     */
    	if (!$this->getCompanyId()->equals(new TechDivision_Lang_Integer(0))) {
		    // add the tab for the company's employees
			$tabs->addTab(
				'employees',
				$this->translate('company.view.tab.label.employees')
			)
		    ->addGrid($this->_prepareEmployeeGrid());
		    // add the tab for the company's addresses
			$tabAddress = $tabs->addTab(
				'address',
				$this->translate('company.view.tab.label.addresses')
			)
		    ->addGrid($this->_prepareAddressGrid())
		    ->addBlock(
		        new TDProject_ERP_Block_Company_View_Address(
		            $this->getContext()
		        )
		    );
			// add the button to create a new address
	    	$button = new TDProject_Core_Block_Widget_Button(
	    	    $this->getContext(),
	    	    'createAddress',
	    	    $this->translate('company.view.button.label.new-address')
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
     * Initializes and returns the grid for the employees.
     *
     * @return TDProject_Core_Block_Widget_Grid
     * 		The initialized grid
     */
    protected function _prepareEmployeeGrid()
    {
    	// instanciate the grid
    	$grid = new TDProject_Core_Block_Widget_Grid(
    	    $this,
    	    'employeeGrid',
    	    $this->translate('company.view.grid.label.employees')
    	);
    	// set the collection with the data to render
    	$grid->setCollection($this->getPersons());
    	// add the columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column_Checkbox(
    	    	'personIdFk', '', 5
    	    )
    	)
		->setCheckedUrl(
			'?path=/company/ajax&method=relateCompanyPerson&companyId=' .
		    $this->getCompanyId()
		)
		->setUncheckedUrl(
			'?path=/company/ajax&method=unrelateCompanyPerson&companyId=' .
		    $this->getCompanyId()
		)
		->setProperty('personId')
		->setSourceCollection($this->getPersonIdFk())
		->setTargetProperty('personId');
		// add the grid's columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'personId',
    	    	$this->translate(
    	    		'company.view.grid.employees.column.label.id'
    	    	),
    	        5
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'fullName',
    	    	$this->translate(
    	    		'company.view.grid.employees.column.label.name'
    	    	),
    	        35
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'email',
    	    	$this->translate(
    	    		'company.view.grid.employees.column.label.email'
    	    	),
    	        20
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'phone',
    	    	$this->translate(
    	    		'company.view.grid.employees.column.label.phone'
    	    	),
    	        20
    	    )
    	);
    	// add the actions
    	$action = new TDProject_Core_Block_Widget_Grid_Column_Actions(
    		'actions',
	    	$this->translate(
	    		'company.view.grid.employees.column.label.actions'
	    	),
    	    15
    	);
    	$action->addAction(
    	    new TDProject_Core_Block_Widget_Grid_Column_Actions_Edit(
    	    	$this->getContext(), 'personId', '?path=/person&method=edit'
    	    )
    	);
    	$grid->addColumn($action);
    	// return the initialized instance
    	return $grid;
    }

    /**
     * Initializes and returns the grid for the addresses.
     *
     * @return TDProject_Core_Block_Widget_Grid
     * 		The initialized grid
     */
    protected function _prepareAddressGrid()
    {
    	// instanciate the grid
    	$grid = new TDProject_Core_Block_Widget_Grid(
    	    $this,
    	    'addressGrid',
    	    $this->translate('company.view.grid.label.addresses')
    	);
    	// set the collection with the data to render
    	$grid->setCollection($this->getAddresses());
    	// add the columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column_Checkbox(
    	    	'addressIdFk', '', 5
    	    )
    	)
		->setCheckedUrl(
			'?path=/company/ajax&method=relateCompanyAddress&companyId=' .
		    $this->getCompanyId()
		)
		->setUncheckedUrl(
			'?path=/company/ajax&method=unrelateCompanyAddress&companyId=' .
		    $this->getCompanyId()
		)
		->setProperty('addressId')
		->setSourceCollection($this->getAddressIdFk())
		->setTargetProperty('addressId');
		// add the grid's columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'addressId',
    	    	$this->translate(
    	    		'company.view.grid.addresses.column.label.id'
    	    	),
    	        5
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'fullAddress',
    	    	$this->translate(
    	    		'company.view.grid.addresses.column.label.address'
    	    	),
    	        60
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column_Select(
    	    	'addressTypeIdFk',
    	    	$this->translate(
    	    		'company.view.grid.addresses.column.label.type'
    	    	),
    	        15
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
	    		'company.view.grid.addresses.column.label.actions'
	    	),
    	    15
    	);
    	// to avoid the usual redirect, because using AJAX in this case
    	$action->setOnChange('javascript:void(0);');
    	$action->addAction(
    		new TDProject_Core_Block_Widget_Grid_Column_Actions_JavaScript(
    		    $this->getContext(),
    			'addressId',
    	    	$this->translate(
    	    		'company.view.grid.addresses.column.label.action.edit'
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
     * @return ActionErrors Returns a ActionErrors container with ActionError objects
     */
    public function validate()
    {
        // initialize the ActionErrors
        $errors = new TechDivision_Controller_Action_Errors();
        // check if a firstname was entered
        if ($this->_name->length() == 0) {
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_ERP_Controller_Util_ErrorKeys::NAME,
                    $this->translate('name.none')
                )
            );
        }
        // check if a email was entered
        if ($this->_email->length() > 0) {
	        // if yees, check if a valid email was entered
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