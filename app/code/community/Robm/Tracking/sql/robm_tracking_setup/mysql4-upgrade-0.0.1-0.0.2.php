<?php
/**
 * User: RobM84 https://github.com/RobM84
 * Date: 2014-10-14
 */

$installer = $this;
$installer->startSetup();
$installer->addAttribute(
    'customer',
    'customer_campaign_params',
    array(
        'type'                      => 'varchar',
        'label'                     => 'Customer Campaign Params',
        'input'                     => 'text',
        'is_used_for_price_rules'   => 0,
        'required'                  => 0,
        'visible'                   => 0,
    )
);
$installer->endSetup();
