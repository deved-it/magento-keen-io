<?php
/**
 *
 * Deved_KeenIo Module
 *
 * Copyright (c) 2015 Deved Sas
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

use KeenIO\Client\KeenIOClient;
class Deved_KeenIo_Model_Observer {

    protected $projectId;
    protected $writeKey;

    public function __construct()
    {
        $this->projectId = Mage::getStoreConfig("keenio_section/keenio_group/project_id");
        $this->writeKey = Mage::getStoreConfig("keenio_section/keenio_group/write_key");
    }

    public function sendNewOrder(Varien_Event_Observer $observer){
      $this->loadLibraries();
      $params = Mage::app()->getFrontController()->getRequest()->getParams();
      $order = $observer->getEvent()->getOrder();
      $items = $order->getAllItems();
      foreach ($items as &$item)
      {
        $item = $item->toArray();
      }
      $shipping_address = $order->getShippingAddress()->getData();
      $order = $order->toArray();
      $order['items'] = $items;
      $order['shipping_address'] = $shipping_address;

      Mage::log('Order intercepted');
      //use Keen IO Client to send order data
      if ($this->projectId && $this->writeKey)
      {
          try
          {

              $client = KeenIOClient::factory([
                  'projectId' => $this->projectId,
                  'writeKey'  => $this->writeKey
              ]);
              $client->addEvent('orders', $order);
              
          } catch (Exception $e) {
              Mage::logException($e);
          }

      }
    }

    /**
     * Attempt to load libraries from vendor directories
     */
    protected function loadLibraries()
    {
        $files = array(
            Mage::getBaseDir().'/vendor/autoload.php'
        );
        foreach ($files as $file) {
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }

}
