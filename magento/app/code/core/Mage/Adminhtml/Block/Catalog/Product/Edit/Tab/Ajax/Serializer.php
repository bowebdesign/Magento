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
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 *
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Ajax_Serializer extends Mage_Core_Block_Template
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('catalog/product/edit/serializer.phtml');
        return $this;
    }

    public function getProductsJSON()
    {
        $result = array();
        if ($this->getProducts()) {
            $isEntityId = $this->getIsEntityId();
            foreach ($this->getProducts() as $product) {
                $id = $isEntityId ? $product->getEntityId() : $product->getId();
                $result[$id] = $product->toArray(array('qty', 'position'));
            }
        }
        return $result ? Zend_Json_Encoder::encode($result) : '{}';
    }

    /**
     * Initialize grid block under the "Related Products", "Up-sells", "Cross-sells" sections
     *
     * @param string $blockName
     * @param string $getProductFunction
     * @param string $inputName
     */
    public function initSerializerBlock($blockName, $getProductFunction, $inputName)
    {
        if ($block = $this->getLayout()->getBlock($blockName)) {
            $this->setGridBlock($block)
                ->setProducts(Mage::registry('current_product')->$getProductFunction())
                ->setInputElementName($inputName);
        }
    }
}