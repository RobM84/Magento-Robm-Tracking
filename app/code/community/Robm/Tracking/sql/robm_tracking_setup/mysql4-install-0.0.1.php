<?php
/**
 * User: RobM84 https://github.com/RobM84
 * Date: 2014-10-14
 */

$installer = Mage::getResourceModel('sales/setup', 'sales_setup');
$installer->startSetup();

$options = array( 
    'label'    => 'Order Campaign Params',
    'type'     => Varien_Db_Ddl_Table::TYPE_VARCHAR, 
    'visible'  => true, 
    'required' => false 
);

$installer->addAttribute('order', 'order_campaign_params', $options);

$installer->endSetup();
