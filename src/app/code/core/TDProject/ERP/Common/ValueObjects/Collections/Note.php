<?php

/**
 * TDProject_ERP_Common_ValueObjects_Collections_Note
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Common/ValueObjects/Collections/Abstract.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the note overview.
 *
 * @category   	TDProject
 * @package     TDProject_Project
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Common_ValueObjects_Collections_Note
    extends TDProject_Core_Common_ValueObjects_Collections_Abstract  {

    /**
     * This method adds the passed object with the passed key
     * to the ArrayList.
     *
     * @param TDProject_ERP_Common_ValueObjects_NoteOverviewData $dto
     * 		The DTO that should be added to the Collection
     * @return TDProject_ERP_Common_ValueObjects_Collections_Note
     * 		The instance
     */
    public function add(TDProject_ERP_Common_ValueObjects_NoteOverviewData $dto)
    {
		// set the item in the array
        $this->_items[$this->_count++] = $dto;
		// return the instance
		return $this;
    }

    /**
     * Returns a JSON encoded representation of the
     * ArrayList and its items.
  	 *
  	 * @return string The JSON representation
     */
    public function toJson()
    {
        // create the stdClass instance
        $stdClass = new stdClass();
        // initialize a new array
        $list = array();
        // iterate over the items
        foreach ($this->_items as $dto) {
            $list[] = $dto->toArray();
        }
        // add the array as member
        $stdClass->aaData = $list;
        // return the JSON representation
        return json_encode($stdClass);
    }
}