<?php

/**
 * TDProject_ERP_Block_Note_View
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'Zend/Locale/Format.php';
require_once 'TDProject/ERP/Block/Abstract/Note.php';
require_once 'TDProject/ERP/Controller/Util/WebRequestKeys.php';
require_once 'TDProject/ERP/Common/ValueObjects/NoteViewData.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Checkbox.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Select.php';

/**
 * @category    TDProject
 * @package     TDProject_ERP
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Block_Note_View
	extends TDProject_ERP_Block_Abstract_Note {

    /**
     * The note's users.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_users = null;

    /**
     * The note's receivers.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_persons = null;

    /**
     * The note's companies.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_companies = null;

    /**
     * The note type's.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_noteTypes = null;

    /**
     * The ID's of the selected persons.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_personIdFk = null;

    /**
     * The ID's of the selected companies.
     * @var TechDivision_Collections_ArrayList
     */
    protected $_companyIdFk = null;

    /**
     * Getter method for the note's users.
     *
     * @return TechDivision_Collections_Interfaces_Collection The note's users
     */
    public function getUsers()
    {
        return $this->_users;
    }

    /**
     * Setter method for the notes's users.
     *
     * @param TechDivision_Collections_Interfaces_Collection $persons The notes's users.
     * @return void
     */
    public function setUsers(
        TechDivision_Collections_Interfaces_Collection $users) {
        $this->_users = $users;
    }

    /**
     * Getter method for the note's persons.
     *
     * @return TechDivision_Collections_Interfaces_Collection The note's persons
     */
    public function getPersons()
    {
        return $this->_persons;
    }

    /**
     * Setter method for the notes's persons.
     *
     * @param TechDivision_Collections_Interfaces_Collection $persons The notes's persons.
     * @return void
     */
    public function setPersons(
        TechDivision_Collections_Interfaces_Collection $persons) {
        $this->_person = $persons;
    }

    /**
     * Getter method for the notes's companies.
     *
     * @return TechDivision_Collections_Interfaces_Collection The notes's companies
     */
    public function getCompanies()
    {
        return $this->_companies;
    }

    /**
     * Setter method for the company's addresss.
     *
     * @param TechDivision_Collections_Interfaces_Collection $compaies The note's companies.
     * @return void
     */
    public function setCompanies(
        TechDivision_Collections_Interfaces_Collection $companies) {
        $this->_companies = $companies;
    }

    /**
     * Getter method for the available note types.
     *
     * @return TechDivision_Collections_Interfaces_Collection The available note types
     */
    public function getNoteTypes()
    {
        return $this->_noteTypes;
    }

    /**
     * Setter method for the available note types.
     *
     * @param TechDivision_Collections_Interfaces_Collection $noteTypes The available note types.
     * @return void
     */
    public function setNoteTypes(
        TechDivision_Collections_Interfaces_Collection $noteTypes) {
        $this->_noteTypes = $noteTypes;
    }

    /**
     * Getter method for the selected note-person relations.
     *
     * @return array The selected note-person relations
     */
    public function getPersonIdFk()
    {
        return $this->_personIdFk;
    }

    /**
     * Setter method for the selected note-person relations.
     *
     * @param array $personIdFk The selected note-person relations.
     * @return void
     */
    public function setPersonIdFk(array $personIdFk)
    {
    	foreach ($personIdFk as $value) {
        	$this->_personIdFk->add((integer) $value);
    	}
    }

    /**
     * Getter method for the selected note-company relations.
     *
     * @return array The selected note-company relations
     */
    public function getCompanyIdFk()
    {
        return $this->_companyIdFk;
    }

    /**
     * Setter method for the selected note-company relations.
     *
     * @param array $personIdFk The selected note-company relations.
     * @return void
     */
    public function setCompanyIdFk(array $companyIdFk)
    {
    	foreach ($companyIdFk as $value) {
        	$this->_companyIdFk->add((integer) $value);
    	}
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Note::setRemindAt()
     */
    public function setRemindAt($string)
    {
    	$this->_remindAt = new TechDivision_Lang_String($string);
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Note::populate()
     */
    public function populate(
        TDProject_ERP_Common_ValueObjects_NoteViewData $dto) {
    	parent::populate($dto);
    	$this->_noteTypes = $dto->getNoteTypes();
    	$this->_persons = $dto->getPersons();
    	$this->_users = $dto->getUsers();
    	$this->_companies = $dto->getCompanies();
        $this->_personIdFk = $dto->getPersonIdFk();
        $this->_companyIdFk = $dto->getCompanyIdFk();
        // overwrite the remind date
        $this->_remindAt = new Zend_Date(
            $dto->getRemindAt()->intValue(), Zend_Date::TIMESTAMP
        );
    }

    /**
     * (non-PHPdoc)
     * @see TDProject_ERP_Block_Abstract_Company::reset()
     */
    public function reset()
    {
    	parent::reset();
        $this->_noteTypes = new TechDivision_Collections_ArrayList();
        $this->_persons = new TechDivision_Collections_ArrayList();
        $this->_users = new TechDivision_Collections_ArrayList();
        $this->_companies = new TechDivision_Collections_ArrayList();
        $this->_personIdFk = new TechDivision_Collections_ArrayList();
        $this->_companyIdFk = new TechDivision_Collections_ArrayList();
        $this->_remindAt = new TechDivision_Lang_String();
    }

	/**
	 * Initializes and returns a new LVO
	 * with the data from the ActionForm.
	 *
	 * @return TDProject_Project_Common_ValueObjects_ProjectLightValue
	 * 		The initialized LVO
	 */
	public function repopulate(TechDivision_Lang_Integer $createUserIdFk)
	{
		// initialize a new LVO
		$lvo = new TDProject_ERP_Common_ValueObjects_NoteLightValue();
		// filling it with the note data from the ActionForm
		$lvo->setNoteId($this->getNoteId());
		$lvo->setNoteTypeIdFk($this->getNoteTypeIdFk());
		$lvo->setRemindUserIdFk($this->getRemindUserIdFk());
		$lvo->setCreateUserIdFk($createUserIdFk);
		$lvo->setCreatedAt(new TechDivision_Lang_Integer(time()));
		$lvo->setSubject($this->getSubject());
		$lvo->setNote($this->getNote());
		// create a new date instance
		$remindAt = new Zend_Date($this->getRemindAt());
		// convert the date and set the timestamp in the LVO
		$lvo->setRemindAt(
			new TechDivision_Lang_Integer((integer) $remindAt->getTimestamp())
		);
		// return the initialized LVO
		return $lvo;
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {
    	// add the tabs container
    	$tabs = $this->addTabs(
    		'tabs',
    		$this->translate('note.view.tabs.label.note')
    	);
    	// add the tab for the company data
        $tabs->addTab(
        	'note',
        	$this->translate('note.view.tab.label.note')
        )
    	->addFieldset(
    		'note',
    		$this->translate('note.view.fieldset.label.details')
    	)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'subject',
		    	$this->translate('note.view.label.subject')
		    )->setMandatory()
		)
		->addElement(
		    $this->getElement(
		    	'textfield',
		    	'remindAt',
		    	$this->translate('note.view.label.remind-at')
		    )->setMandatory()
		)
		->addElement(
		    $this->getElement(
		    	'textarea',
		    	'note',
		    	$this->translate('note.view.label.note')
		    )->setMandatory()
		)
		->addElement(
		    $this->getElement(
		    	'select',
		    	'remindUserIdFk',
		    	$this->translate('note.view.label.remind-user')
		    )->setOptions($this->getUsers())
		)
		->addElement(
		    $this->getElement(
		    	'select',
		    	'noteTypeIdFk',
		    	$this->translate('note.view.label.note-type')
		    )->setOptions($this->getNoteTypes())
		);
		// check if a new note was created or an existing one will be edited
    	if (!$this->getNoteId()->equals(new TechDivision_Lang_Integer(0))) {
	        // add the person and the overview
			$tabs->addTab(
				'personen',
				$this->translate('note.view.tab.label.persons')
		    )
			->addGrid($this->_preparePersonGrid());
	        // add the company and the overview
			$tabs->addTab(
				'companies',
				$this->translate('note.view.tab.label.companies')
		    )
			->addGrid($this->_prepareCompanyGrid());
    	}
        // call the parent constructor and return the instance itself
        return parent::prepareLayout();
    }

    /**
     * Initializes and returns the grid for the persons.
     *
     * @return TDProject_Core_Block_Widget_Grid
     * 		The initialized grid
     */
    protected function _preparePersonGrid()
    {
    	// instanciate the grid
    	$grid = new TDProject_Core_Block_Widget_Grid(
    	    $this,
    	    'personGrid',
    	    $this->translate('note.view.grid.label.persons')
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
    		'?path=/note/ajax&method=relatePersonNote&noteId=' .
    	    $this->getNoteId()
    	)
    	->setUncheckedUrl(
    		'?path=/note/ajax&method=unrelatePersonNote&noteId=' .
    	    $this->getNoteId()
    	)
    	->setProperty('personId')
    	->setSourceCollection($this->getPersonIdFk())
    	->setTargetProperty('personId');
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'personId',
    	    	$this->translate(
    	    		'note.view.grid.persons.column.label.id'
    	        ),
    	        5
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'fullName',
    	    	$this->translate(
    	    		'note.view.grid.persons.column.label.full-name'
    	        ),
    	        60
    	    )
    	);
    	// return the initialized instance
    	return $grid;
    }

    /**
     * Initializes and returns the grid for the companies.
     *
     * @return TDProject_Core_Block_Widget_Grid
     * 		The initialized grid
     */
    protected function _prepareCompanyGrid()
    {
    	// instanciate the grid
    	$grid = new TDProject_Core_Block_Widget_Grid(
    	    $this,
    	    'companyGrid',
    	    $this->translate('note.view.grid.label.companies')
    	);
    	// set the collection with the data to render
    	$grid->setCollection($this->getCompanies());
    	// add the columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column_Checkbox(
    	    	'companyIdFk', '', 5
    	    )
    	)
    	->setCheckedUrl(
    		'?path=/note/ajax&method=relateCompanyNote&noteId=' .
    	    $this->getNoteId()
    	)
    	->setUncheckedUrl(
    		'?path=/note/ajax&method=unrelateCompanyNote&noteId=' .
    	    $this->getNoteId()
    	)
    	->setProperty('companyId')
    	->setSourceCollection($this->getCompanyIdFk())
    	->setTargetProperty('companyId');
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'companyId',
    	    	$this->translate(
    	    		'note.view.grid.companies.column.label.id'
    	        ),
    	        5
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'name',
    	    	$this->translate(
    	    		'note.view.grid.companies.column.label.name'
    	        ),
    	        60
    	    )
        );
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
		// check if a subject was entered
		if ($this->_subject->length() == 0) {
			$errors->addActionError(
				new TechDivision_Controller_Action_Error(
					TDProject_ERP_Controller_Util_ErrorKeys::SUBJECT,
					$this->translate('subject.none')
				)
			);
		}
		// check if a note was entered
		if ($this->_note->length() == 0) {
			$errors->addActionError(
				new TechDivision_Controller_Action_Error(
					TDProject_ERP_Controller_Util_ErrorKeys::NOTE,
					$this->translate('note.none')
				)
			);
		}
		// check if a valid date to remind was entered
		if (!Zend_Locale_Format::checkDateFormat($this->_remindAt)) {
			$errors->addActionError(
				new TechDivision_Controller_Action_Error(
					TDProject_ERP_Controller_Util_ErrorKeys::REMIND_AT,
					$this->translate('remindAt.invalid')
				)
			);
		}
		// return the ActionErrors
		return $errors;
	}
}