<?php
/**
 * User: RobM84 https://github.com/RobM84
 * Date: 2014-10-14
 */

class Robm_Tracking_Helper_Data extends Mage_Core_Helper_Abstract
{
    const CUSTOMER_CAMPAIGN_PARAMS = 'customer_campaign_params';
    const TRACKING_COOKIE_LIFETIME = 15552000;

    public function getCampaignParamsArray()
    {
        $request = Mage::app()->getRequest();
        $campaignParams = array(
            'utm_source' => utf8_encode($request->getParam('utm_source')),
            'utm_medium' => utf8_encode($request->getParam('utm_medium')),
            'utm_content' => utf8_encode($request->getParam('utm_content')),
            'utm_campaign' => utf8_encode($request->getParam('utm_campaign')),
            'utm_term' => utf8_encode($request->getParam('utm_term')),
        );

        return $campaignParams;
    }

    public function getUtmSource()
    {
        $session = Mage::getSingleton('customer/session');
        $campaignString = $session->getData(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS);
        if(is_null($campaignString)) {
            $cookie = Mage::getSingleton('core/cookie');
            $campaignString = $cookie->get(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS);
        }

        $utmSource = '';
        $campaignStringArray = explode("|", $campaignString);
        foreach ($campaignStringArray as $campaignParam) {
            if (!empty($campaignParam) && strpos($campaignParam, "=")) {
                $keyValuePair = explode("=", $campaignParam);
                if ($keyValuePair[0] == 'utm_source') {
                    $utmSource = strtolower($keyValuePair[1]);
                    break;
                }
            }
        }

        return $utmSource;
    }


    public function getUtmSourceSession()
    {
        $session = Mage::getSingleton('customer/session');
        $campaignString = $session->getData(Robm_Tracking_Helper_Data::CUSTOMER_CAMPAIGN_PARAMS);

        $utmSource = '';
        $campaignStringArray = explode("|", $campaignString);
        foreach ($campaignStringArray as $campaignParam) {
            if (!empty($campaignParam) && strpos($campaignParam, "=")) {
                $keyValuePair = explode("=", $campaignParam);
                if ($keyValuePair[0] == 'utm_source') {
                    $utmSource = strtolower($keyValuePair[1]);
                    break;
                }
            }
        }

        return $utmSource;
    }
}