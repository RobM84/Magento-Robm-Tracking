<?php
/**
 * Created by PhpStorm.
 * User: robinmueller
 * Date: 08.01.14
 * Time: 11:57
 */

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('sales_flat_order')} ADD `order_campaign_params` VARCHAR(255) NULL;");
$installer->endSetup();