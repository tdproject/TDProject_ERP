<?php

/**
 * TDProject_ERP_Block_Note_Overview
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Formatter/Date.php';
require_once 'TDProject/Core/Block/Widget/Form/Abstract/Overview.php';
require_once 'TDProject/Core/Block/Widget/Grid.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions/Edit.php';
require_once 'TDProject/Core/Block/Widget/Grid/Column/Actions/Delete.php';
require_once 'TDProject/Core/Block/Widget/Button/New.php';

/**
 * @category    TDProject
 * @package     TDProject_ERP
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Block_Note_Overview
	extends TDProject_Core_Block_Widget_Form_Abstract_Overview {

    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form_Overview::prepareGrid()
     */
    public function prepareGrid() {
    	// instanciate the grid
    	$grid = new TDProject_Core_Block_Widget_Grid(
    	    $this,
    	    'grid',
    	    $this->translate('note.overview.grid.label.notes')
    	);
    	// set the collection with the data to render
    	$grid->setCollection($this->getCollection());
    	// add the columns
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'noteId',
    	    	$this->translate(
    	    		'note.overview.grid.notes.column.label.id'
    	    	),
    	        10
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'subject',
    	    	$this->translate(
    	    		'note.overview.grid.notes.column.label.subject'
    	    	),
    	        35
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'noteTypeName',
    	    	$this->translate(
    	    		'note.overview.grid.notes.column.label.note-type-name'
    	    	),
    	        10
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'createUserUsername',
    	    	$this->translate(
    	    		'note.overview.grid.notes.column.label.create-user-username'
    	    	),
    	        10
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'remindUserUsername',
    	    	$this->translate(
    	    		'note.overview.grid.notes.column.label.remind-user-username'
    	    	),
    	        10
    	    )
    	);
    	$grid->addColumn(
    	    new TDProject_Core_Block_Widget_Grid_Column(
    	    	'remindAt',
    	    	$this->translate(
    	    		'note.overview.grid.notes.column.label.remind-at'
    	    	),
    	        10
    	    )
    	)
    	->setFormatter(TDProject_Core_Formatter_Date::get());
    	// add the actions
    	$action = new TDProject_Core_Block_Widget_Grid_Column_Actions(
    		'actions',
    	    	$this->translate(
    	    		'note.overview.grid.notes.column.label.actions'
    	    	),
    	    15
    	);
    	$action->addAction(
    	    new TDProject_Core_Block_Widget_Grid_Column_Actions_Edit(
    	    	$this->getContext(), 'noteId', '?path=/note&method=edit'
    	    )
    	);
    	$action->addAction(
    	    new TDProject_Core_Block_Widget_Grid_Column_Actions_Delete(
    	   		$this->getContext(), 'noteId', '?path=/note&method=delete'
    	    )
    	);
    	$grid->addColumn($action);
    	// return the initialized instance
    	return $grid;
    }
}