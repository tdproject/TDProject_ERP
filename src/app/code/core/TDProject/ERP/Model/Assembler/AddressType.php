<?php

/**
 * TDProject_ERP_Model_Assembler_Address
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
class TDProject_ERP_Model_Assembler_AddressType
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
        return new TDProject_ERP_Model_Assembler_AddressType($container);
    }

    /**
     * Returns an ArrayList with all address types
     * assembled as DTO's.
     *
     * @return TechDivision_Collections_ArrayList
     * 		The requested address type DTO's
     */
    public function getAddressTypeOverviewData()
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the address types
        $addressTypes = TDProject_ERP_Model_Utils_AddressTypeUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the address types
        foreach ($addressTypes as $addressType) {
            $list->add(
                new TDProject_ERP_Common_ValueObjects_AddressTypeOverviewData(
                    $addressType
                )
            );
        }
        // return the ArrayList with the AddressTypeOverviewData instances
        return $list;
    }
}