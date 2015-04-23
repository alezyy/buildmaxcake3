<?php
/**
 *   _____                                                                       
 *  /__   \  ___   _ __     /\/\    ___  _ __   _   _      ___   ___   _ __ ___  
 *    / /\/ / _ \ | '_ \   /    \  / _ \| '_ \ | | | |    / __| / _ \ | '_ ` _ \ 
 *   / /   | (_) || |_) | / /\/\ \|  __/| | | || |_| | _ | (__ | (_) || | | | | |
 *   \/     \___/ | .__/  \/    \/ \___||_| |_| \__,_|(_) \___| \___/ |_| |_| |_|
 *                |_|                                                                                           
 *               
 * @copyright     Copyright (c) Top Menu Web, Inc. (https://www.topmenu.com) & Respective Owners
 * @link          https://www.topmenu.com/ Top Menu Web Inc.
 * @version      2
 *                                                                   
 */


class OrderTestShell extends AppShell {
/**
* uses
*
* @var mixed
* @access public
*/
   public $uses = array(
      'Order'
   );

   private $order_data =<<<EOF
{
   "Order": {
      "subtotal": "$12.75",
      "gst": "0.6375",
      "pst": "1.13794",
      "hst": "0",
      "delivery_charge": "2.5",
      "tip": "2.0",
      "total": "14.53",
      "date": "2011-06-10 07:23:16",
      "first_name": "Caroline",
      "last_name": "Gonzalez",
      "address": "2529 rue de Bellechasse",
      "address2": "",
      "city": "Montreal",
      "state": "Quebec",
      "postal_code": "H1Y 1H9",
      "door_code": "",
      "cross_street": "Bellechasse et Iberville",
      "phone": "514-835-3002",
      "special_instruction": "La sonnette ést brisee donc appellez lorsque le livreur sera sur place",
      "coupon_code": "",
      "coupon_discount": "0",
      "redeemed_points_value": "0",
      "language": "en",
      "status": "unprocessed",
      "type": "pickup",
      "referrer": "https://www.topmenu.com/en/somerestaurant",
      "payment_status": "unpaid",
      "location_id": "528b6c6d-38e0-4b59-974a-660afe51d21f"
   }
}
EOF;


/**
* Object we'll be saving to OrderDetail,
* Please make sure that options is JSON encoded
*
* @var [type]
*/
   private $order_details =<<<EOF
{
   "OrderDetail": [
      {
         "order_id": "",
         "menu_item_id": "",
         "name": "Pad Thai",
         "quantity": "1",
         "price": "12.75",
         "special_instruction": "Some instruction"
      }
   ]
}
EOF;
   /**
   * main function.
   *
   * @access public
   * @return void
   */
   public function main() {

      $data = json_decode($this->order_data, true);

      // Just throwing in the current date for Order.requested_for
      // Adding in a later date would indicate that it's a "future order"
      $data['Order']['requested_for'] = date('Y-m-d H:i:s', strtotime('+2 Minute'));

      // Save the order
      $this->Order->create();
      $this->Order->save($data, false);



      // Get the order ID
      $order_id = $this->Order->getLastInsertID();
      $data = array(
         array(
            "order_id"            => "",
            "menu_item_id"        => "",
            "name"                => "Item With a really really long name",
            "quantity"            => "1",
            "price"               => "12.75",
            "options"             => "Option with a really really really long name;1;1||\nOption2;2;1||\n",
            "special_instruction" => "Some instruction"
         ),
         array(
            "order_id"            => "",
            "menu_item_id"        => "",
            "name"                => "Item",
            "quantity"            => "1",
            "price"               => "12.75",
            "options"             => "Option1;1;1||\nOption2;2;1||\n",
            "special_instruction" => "Some instruction"
         ),
         array(
            "order_id"            => "",
            "menu_item_id"        => "",
            "name"                => "Item",
            "quantity"            => "1",
            "price"               => "12.75",
            "options"             => "Option1;1;1||\nOption2;2;1||\n",
            "special_instruction" => "Some instruction"
         ),
         array(
            "order_id"            => "",
            "menu_item_id"        => "",
            "name"                => "Item",
            "quantity"            => "1",
            "price"               => "12.75",
            "options"             => "Option1;1;1||\nOption2;2;1||\n",
            "special_instruction" => "Some instruction"
         ),
         array(
            "order_id"            => "",
            "menu_item_id"        => "",
            "name"                => "Item",
            "quantity"            => "1",
            "price"               => "12.75",
            "options"             => "Option1;1;1||\nOption2;2;1||\n",
            "special_instruction" => "Some instruction"
         )
      );



      // Save each OrderDetail
      foreach ($data as $record) {
         $this->Order->OrderDetail->create();
         // Don't forget to add in the order_id
         $record['order_id'] = $order_id;
         $this->Order->OrderDetail->save($record);
      }


      // Finish the new order
      // This function causes the ES index for this record to be updated,
      // and it sends the new order to the printer. Be sure *only* to use
      // this on new orders, we don't want to send previous orders to the restaurant
      //
      // In our workflow, this call should happen right after we get authorization
      // from the payment gateway. After the restaurant accepts the order, we'll do
      // a capture. This will take place in Order::processDeviceResponse() later on.
      $this->Order->finishNewOrder($order_id);


      return true;
   }
}