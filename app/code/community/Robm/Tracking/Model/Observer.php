<?php
/**
 * @author RobM84 https://github.com/RobM84
 * Date: 2014-10-14
 */
class Robm_Tracking_Model_Observer
{
    public function setCampaignParamsToSessionAndCookie()
    {
        $request = Mage::app()->getRequest();

        $utmSource = $request->getParam('utm_source');
        if ($utmSource) {
            $campaignParams = Mage::helper('robm_tracking')->getCampaignParamsArray();


            $campaignString = array();
            $campaignString = serialize($campaignParams);

            // set data to customer session
            $session = Mage::getSingleton('customer/session');
            $session->setData(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS, $campaignString);

            // set cookie containing data
            $expire = time() + Robm_Tracking_Helper_Data::TRACKING_COOKIE_LIFETIME;
            $cookie = Mage::getSingleton('core/cookie');
            $cookie->set(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS, $campaignString, $expire);


            return true;
        }

        return false;
    }
 

    public function addTrackingToCustomerCreate(Varien_Event_Observer $observer) {
        $cookie = Mage::getSingleton('core/cookie');
        $campaignString = $cookie->get(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS);
        if(is_null($campaignString) || $campaignString == '') {
            $campaignString = serialize(array());
        }

        $customerObject = $observer->getEvent()->getDataObject();
        if($customerObject->isObjectNew()) {
            $customerObject->setCustomerCampaignParams($campaignString);
        }

        return $this;
    }

    public function addTrackingToOrderCreate(Varien_Event_Observer $observer) {
        $cookie = Mage::getSingleton('core/cookie');
        $campaignString = $cookie->get(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS);
        if(is_null($campaignString) || $campaignString == '') {
            $campaignString = serialize(array());
        }

        $orderObject = $observer->getEvent()->getOrder();
        $orderObject->setOrderCampaignParams($campaignString);

        return $this;
    }

    public function addInfoToOrder(Varien_Event_Observer $observer)
    {
        $giftOptionsBlock = $observer->getBlock();
        if ($giftOptionsBlock->getNameInLayout() !== 'order_info') {
            // not interested in other blocks than gift_options
            return;
        }

        $customInfoBlock = Mage::app()->getLayout()->createBlock(
            'adminhtml/template',
            'custom_order_info',
            array(
                'template' => 'robm_tracking/sales/order/view/utm.phtml',
                'order' => Mage::registry('current_order'),
            )
        );

        $giftOptionsHtml = $observer->getTransport()->getHtml();
        $customHtml  = $customInfoBlock->toHtml();

        $observer->getTransport()->setHtml($customHtml . $giftOptionsHtml);
    }
}