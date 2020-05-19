<?php
class Robm_Tracking_Block_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $this->_getValue($row);
        if(!$value || !unserialize($value)){
            return '';
        }

        $unserialized = unserialize($value);
        if(!isset($unserialized['utm_source'])){
            return '';
        }

        return $unserialized['utm_source'];

    }
}