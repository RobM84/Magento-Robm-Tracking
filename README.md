Magento customer and order tracking
===================================

A tracking module which retrieves utm  URL parameters and saves them on registration and order.
Five tracking parameters are saved from the URL to the session and later saved on the order and customer account.

**The five parameters are:**
* utm_source
* utm_medium
* utm_content
* utm_campaign
* utm_term

More information in: https://support.google.com/analytics/answer/1033867?hl=en.

## Install

1. Download the zip file of this project.
1. Unzip from the project folder (and merge folders).

## Usage

* User hits you site with tracking parameters: www.yoursite.com?utm_source=abc&utm_medium=def&utm_content=ghi&utm_campaign=jkl&utm_term=mno
* The parameters are saved to session and cookie
* When the customer signes up, the tracking string is saved in `customer_entity_varchar` table as attribute `customer_campaign_params`. When the customer places an order, the tracking string is saved in the `sales_flat_order` table in the `order_campaign_params` column.
  * `utm_source=abc|utm_medium=def|utm_content=ghi|utm_campaign=jkl|utm_term=mno`
  * Only the paramter utm_source is mandatory, the other paramters can be empty
  * The tracking string then looks like that: `utm_source=abc|utm_medium=|utm_content=|utm_campaign=|utm_term=`
