<?php

/**
 * TDProject_ERP_Model_Assembler_NoteType
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Model_Assembler_NoteType 
    extends TDProject_Core_Model_Assembler_Abstract {

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_ERP_Model_Assembler_NoteType($container);
    }
    
    /**
     * Returns an ArrayList with all note types 
     * assembled as DTO's.
     * 
     * @return TechDivision_Collections_ArrayList
     * 		The requested note type DTO's
     */
    public function getNoteTypeOverviewData() 
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the note types
        $noteTypes = TDProject_ERP_Model_Utils_NoteTypeUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the address types
        foreach ($noteTypes as $noteType) {
            $list->add(new TDProject_ERP_Common_ValueObjects_NoteTypeOverviewData($noteType));
        }
        // return the ArrayList with the NoteTypeOverviewData instances
        return $list;
    }

    /**
     * Returns an ArrayList with all note types 
     * assembled as LVO's.
	 *
     * @return TechDivision_Collections_ArrayList
     * 		The assembled note type enitities
     */
    public function getNoteTypeLightValues() 
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the note types
        $noteTypes = TDProject_ERP_Model_Utils_NoteTypeUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the entities
        foreach ($noteTypes as $noteType) {
            $list->add($noteType->getLightValue());
        }
        // return the ArrayList with the NoteTypeLightValues
        return $list;
    }
}