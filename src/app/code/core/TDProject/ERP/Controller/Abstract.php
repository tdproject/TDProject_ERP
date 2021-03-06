<?php

/**
 * TDProject_ERP_Controller_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package    	TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
abstract class TDProject_ERP_Controller_Abstract
    extends TDProject_Core_Controller_Abstract 
{

	/**
	 * This method returns the delegate for calling
	 * the backend functions.
	 *
	 * @return TDProject_ERP_Model_Services_DomainProcessor
	 * 		The requested processor
	 */
	protected function _getDelegate()
	{
        return TDProject_ERP_Common_Delegates_DomainProcessorDelegateUtil::getDelegate($this->getApp());
	}
}