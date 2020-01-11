<?php
/**
 * @author RobM84 https://github.com/RobM84
 * Date: 2014-10-14
 */
class Robm_Tracking_Helper_Data extends Mage_Core_Helper_Abstract
{
    const CUSTOMER_CAMPAIGN_PARAMS = 'customer_campaign_params';
    const TRACKING_COOKIE_LIFETIME = 15552000;

    /**
     * Get UTM parameters to save it in array-key.
     * 
     * @return Array
     */
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

    /**
     * Find the `utm_source` key from session and coockies to return the value.
     *
     * ```php
     * Mage::helper('robm_tracking')->getUtmSource();
     * ```
     * 
     * @return String
     */
    public function getUtmSource()
    {
        $session = Mage::getSingleton('customer/session');
        $campaignString = $session->getData(self::CUSTOMER_CAMPAIGN_PARAMS);

        if(is_null($campaignString)) {
            $cookie = Mage::getSingleton('core/cookie');
            $campaignString = $cookie->get(self::CUSTOMER_CAMPAIGN_PARAMS);
        }

        $utmSource = '';
        $campaignStringArray = explode('|', $campaignString);
        foreach ($campaignStringArray as $campaignParam) {
            if (!empty($campaignParam) && strpos($campaignParam, '=')) {
                $keyValuePair = explode('=', $campaignParam);
                if ($keyValuePair[0] == 'utm_source') {
                    $utmSource = strtolower($keyValuePair[1]);
                    break;
                }
            }
        }

        return $utmSource;
    }

    /**
     * Find the `utm_source` key from session to return the value.
     *
     * ```php
     * Mage::helper('robm_tracking')->getUtmSourceSession();
     * ```
     * 
     * @return String
     */
    public function getUtmSourceSession()
    {
        $session = Mage::getSingleton('customer/session');
        $campaignString = $session->getData(self::CUSTOMER_CAMPAIGN_PARAMS);

        $utmSource = '';
        $campaignStringArray = explode('|', $campaignString);
        foreach ($campaignStringArray as $campaignParam) {
            if (!empty($campaignParam) && strpos($campaignParam, '=')) {
                $keyValuePair = explode('=', $campaignParam);
                if ($keyValuePair[0] == 'utm_source') {
                    $utmSource = strtolower($keyValuePair[1]);
                    break;
                }
            }
        }

        return $utmSource;
    }
}