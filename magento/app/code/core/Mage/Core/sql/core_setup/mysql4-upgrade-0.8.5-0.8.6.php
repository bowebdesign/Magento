<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Core
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */


/**
 * Add default website
 *
 * @category   Mage
 * @package    Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('core_website'), 'is_default', 'tinyint(1) unsigned default 0');
$select = $installer->getConnection()->select()
    ->from($installer->getTable('core_website'))
    ->where('website_id > ?', 0)
    ->order('website_id')
    ->limit(1);
$row = $installer->getConnection()->fetchRow($select);

if ($row) {
    $whereBind = $installer->getConnection()->quoteInto('website_id=?', $row['website_id']);
    $installer->getConnection()->update($installer->getTable('core_website'),
        array('is_default' => 1),
        $whereBind
    );
}

$installer->endSetup();
