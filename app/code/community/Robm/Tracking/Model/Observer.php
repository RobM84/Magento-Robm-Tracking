<?php
/**
 * User: RobM84 https://github.com/RobM84
 * Date: 2014-10-14
 */

class Robm_Tracking_Model_Observer
{
    public function setCampaignParamsToSessionAndCookie()
    {
        $request = Mage::app()->getRequest();

        $utmSource = $request->getParam('utm_source');
        if ($utmSource) {
            $campaignParams = Mage::helper("robm_tracking")->getCampaignParamsArray();


            $campaignString = '';
            foreach ($campaignParams as $key => $value) {
                $campaignString .= $key . '=' . $value . '|';
            }

            // set data to customer session
            $session = Mage::getSingleton('customer/session');
            $session->setData(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS, $campaignString);

            // set cookie containing data
            $expire = time() + Robm_Tracking_Helper_Data::TRACKING_COOKIE_LIFETIME;
            $cookie = Mage::getSingleton('core/cookie');
            $cookie->set(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS, $campaignString, $expire, '/');

            $db = Mage::getSingleton('core/resource')->getConnection('core_write');
            try {
                $db->insertOnDuplicate($db->getTableName('robm_tracking'), array('date' => date('Y-m-d'), 'utm_source' => $utmSource, 'clicks' => 1), array('clicks' => new Zend_Db_Expr('`clicks` +1')));
            } catch (Exception $e) {
                Mage::logException($e);
            }

            return true;
        }

        return false;
    }
 

    public function addTrackingToCustomerCreate(Varien_Event_Observer $observer) {
        $cookie = Mage::getSingleton('core/cookie');
        $campaignString = $cookie->get(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS);
        if(is_null($campaignString) || $campaignString == '') {
            $campaignString = 'untracked';
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
            $campaignString = 'untracked';
        }

        $orderObject = $observer->getEvent()->getOrder();
        $orderObject->setOrderCampaignParams($campaignString);

        return $this;
    }
}