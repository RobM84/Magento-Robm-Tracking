<?php
/**
 * User: RobM84 https://github.com/RobM84
 * Date: 2014-10-14
 */

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('sales_flat_order')} ADD `order_campaign_params` VARCHAR(255) NULL;");
$installer->endSetup();