<?php

/**
 * TDProject_ERP_Model_Assembler_Note
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
class TDProject_ERP_Model_Assembler_Note
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
        return new TDProject_ERP_Model_Assembler_Note($container);
    }

    /**
     * Returns a DTO with the data of the note
     * with the passed ID.
     *
     * @param TechDivision_Lang_Integer $noteId
     * 		The note ID to return the DTO for
     * @return TDProject_ERP_Common_ValueObjects_NoteViewData
     * 		The requested DTO
     */
    public function getNoteViewData(
        TechDivision_Lang_Integer $noteId = null) {
        // load the LocalHome
        $home = TDProject_ERP_Model_Utils_NoteUtil::getHome($this->getContainer());
		// check if a note ID was passed
		if ($noteId == null) {
    		// if not, initialize a new note
    		$note = $home->epbCreate();
		} else {
		    // if yes, load the note
			$note = $home->findByPrimaryKey($noteId);
		}
		// initialize the DTO
		$dto = new TDProject_ERP_Common_ValueObjects_NoteViewData(
		    $note
		);
		// set the available users
		$dto->setUsers(
		    TDProject_Core_Model_Assembler_User::create($this->getContainer())
		        ->getUserOverviewData()
		);
		// set the available persons
		$dto->setPersons(
		    TDProject_ERP_Model_Assembler_Person::create($this->getContainer())
		        ->getPersonOverviewData()
		);
		// set the available companies
		$dto->setCompanies(
		    TDProject_ERP_Model_Assembler_Company::create($this->getContainer())
		        ->getCompanyOverviewData()
		);
		// set the available users
		$dto->setNoteTypes(
		    TDProject_ERP_Model_Assembler_NoteType::create($this->getContainer())
		        ->getNoteTypeOverviewData()
		);
        // set the address type ID's of the related persons
        foreach ($dto->getPersonNotes() as $personNote) {
        	$dto->getPersonIdFk()->add($personNote->getPersonIdFk()->intValue());
        }
        // set the address type ID's of the related companies
        foreach ($dto->getCompanyNotes() as $companyNote) {
        	$dto->getCompanyIdFk()->add($companyNote->getCompanyIdFk()->intValue());
        }
        // return the assembled DTO
		return $dto;
    }

    /**
     * Returns an ArrayList with initialized and assembled
     * note VO's for the note overview.
     *
     * @param TechDivision_Lang_Integer $userId
     * 		The user ID to load the notes for
     * @return TechDivision_Collections_ArrayList
     * 		ArrayList with the assembled note DTO's
     */
    public function getNoteOverviewData()
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the available notes
        $notes = TDProject_ERP_Model_Utils_NoteUtil::getHome($this->getContainer())
            ->findAll();
        // assemble and return the notes
        return $this->_getNoteOverviewData($notes);
    }

    /**
     * Returns an ArrayList with initialized and assembled
     * note DTO's for the note widget in the dashboard.
     *
     * @param TechDivision_Lang_Integer $userId
     * 		The user ID to load the notes for
     * @return TechDivision_Collections_ArrayList
     * 		ArrayList with the assembled note DTO's
     */
    public function getNoteOverviewDataByUserId(TechDivision_Lang_Integer $userId)
    {
        // load the notes for the user with the passed ID
        $notes = TDProject_ERP_Model_Utils_NoteUtil::getHome($this->getContainer())
            ->findAllByRemindUserIdFk($userId);
        // assemble and return the notes
        return $this->_getNoteOverviewData($notes);
    }

    /**
     * Assembles the passed notes and returns an ArrayList
     * with the initialized NoteOverviewData DTO's.
     *
     * @param TechDivision_Collections_Interfaces_Collection $notes
     * 		The notes to assemble
     * @return TechDivision_Collections_ArrayList
     * 		The assembled notes as NoteOverviewData DTO's
     */
    protected function _getNoteOverviewData(
        TechDivision_Collections_Interfaces_Collection $notes) {
        // initialize the ArrayList for the DTO's
        $list = new TDProject_ERP_Common_ValueObjects_Collections_Note();
        // initialize the Home for assembling the users
        $uh = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer());
        // assemble the notes
        foreach ($notes as $note) {
            // initialize the DTO itself
            $dto = new TDProject_ERP_Common_ValueObjects_NoteOverviewData(
                $note
            );
            // set the user to be reminded
            $dto->setRemindUser(
                $uh->findByPrimaryKey($note->getRemindUserIdFk())->getLightValue()
            );
            // set the user who created the note
            $dto->setCreateUser(
                $uh->findByPrimaryKey($note->getCreateUserIdFk())->getLightValue()
            );
            // add the DTO to the ArrayList
            $list->add($dto);
        }
        // return the ArrayList with the DTO's
        return $list;
    }

    /**
     * Returns an ArrayList with all notes
     * assembled as LVO's.
	 *
     * @return TechDivision_Collections_ArrayList
     * 		The assembled note enitities
     */
    public function getNoteLightValues()
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the notes
        $notes = TDProject_ERP_Model_Utils_NoteUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the entities
        foreach ($notes as $note) {
            $list->add($note->getLightValue());
        }
        // return the ArrayList with the NoteLightValues
        return $list;
    }
}