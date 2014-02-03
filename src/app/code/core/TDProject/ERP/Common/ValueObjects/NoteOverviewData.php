<?php

/**
 * TDProject_ERP_Common_ValueObjects_NoteOverviewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/ERP/Common/ValueObjects/NoteValue.php';
require_once 'TDProject/Core/Common/ValueObjects/UserLightValue.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the dashboard view.
 *
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_ERP_Common_ValueObjects_NoteOverviewData
    extends TDProject_ERP_Common_ValueObjects_NoteValue {

    /**
     * The user to be reminded.
     * @var TDProject_Core_Common_ValueObjects_UserLightValue
     */
    protected $_remindUser = null;

    /**
     * The user that created the note.
     * @var TDProject_Core_Common_ValueObjects_UserLightValue
     */
    protected $_createUser = null;

    /**
     * Sets the user to be reminded.
     *
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $lvo
     * 		The LVO with the user to be reminded
     */
    public function setRemindUser(
        TDProject_Core_Common_ValueObjects_UserLightValue $lvo) {
        $this->_remindUser = $lvo;
    }

    /**
     * Returns the user to be reminded.
     *
     * @param TDProject_Core_Common_ValueObjects_UserLightValue
     * 		The LVO with the user to be reminded
     */
    public function getRemindUser()
    {
        return $this->_remindUser;
    }

    /**
     * Returns the username of the user to be reminded.
     *
     * @return TechDivision_Lang_String
     * 		The username of the user to be reminded
     */
    public function getRemindUserUsername()
    {
    	return $this->getRemindUser()->getUsername();
    }

    /**
     * Sets the user who created the note.
     *
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $lvo
     * 		The LVO with the user who created the note
     */
    public function setCreateUser(
        TDProject_Core_Common_ValueObjects_UserLightValue $lvo) {
        $this->_createUser = $lvo;
    }

    /**
     * Returns the user who created the note.
     *
     * @return TDProject_Core_Common_ValueObjects_UserLightValue
     * 		The LVO with the user who created the note
     */
    public function getCreateUser()
    {
        return $this->_createUser;
    }

    /**
     * Returns the username of the user that
     * created the note.
     *
     * @return TechDivision_Lang_String
     * 		The username of the user that created the note
     */
    public function getCreateUserUsername()
    {
    	return $this->getCreateUser()->getUsername();
    }

    /**
     * Returns the name of the note's type.
     *
     * @return TechDivision_Lang_String
     * 		The name of the note's type
     */
    public function getNoteTypeName()
    {
    	return $this->getNoteType()->getName();
    }

    /**
     * Cast's the instance to an array.
     *
     * @return array The casted instance
     */
    public function toArray()
    {
        // return the instance
        return array(
            $this->getNoteId()->intValue(),
            $this->getSubject()->stringValue(),
            $this->getNoteTypeName()->stringValue(),
            $this->getCreateUserUsername()->stringValue(),
            TDProject_Core_Formatter_Date::get()
                ->format($this->getRemindAt())->stringValue()
        );
    }
}