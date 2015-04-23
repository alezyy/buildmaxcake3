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


class ItemTreeShell extends AppShell {
/**
* uses
*
* @var mixed
* @access public
*/
   public $uses = array(
      'MenuItemOption',
      'MenuItemOptionValue',
      'MenuCategory'
   );

   /**
   * main function.
   *
   * @access public
   * @return void
   */
   public function main() {

      die('Function deprecated');

      $option_ids = array();

      // Menu Item Options

      $results = $this->MenuCategory->find('all');

      foreach ($results as $result) {

         $lft  = 0;
         $rght = 1;

         $options = $this->MenuItemOption->find('all', array(
            'conditions' => array(
               'MenuItemOption.menu_category_id' => $result['MenuCategory']['id']
            )
         ));

         foreach ($options as $option) {
            $option_ids[] = $option['MenuItemOption']['id'];
            $data = array(
               'MenuItemOption' => array(
                  'id' => $option['MenuItemOption']['id'],
                  'lft' => $lft,
                  'rght' => $rght
               )
            );
            $this->MenuItemOption->save($data, false);
            $lft  += 2;
            $rght += 2;
         }
      }

      // Menu Item Option Values


      foreach ($option_ids as $option_id) {
         $lft  = 0;
         $rght = 1;

         $results = $this->MenuItemOptionValue->find('all', array(
            'conditions' => array(
               'MenuItemOptionValue.menu_item_option_id' => $option_id
            )
         ));

         foreach ($results as $result) {
            $data = array(
               'MenuItemOptionValue' => array(
                  'id' => $result['MenuItemOptionValue']['id'],
                  'lft' => $lft,
                  'rght' => $rght
               )
            );
            $this->MenuItemOptionValue->save($data, false);
            $lft  += 2;
            $rght += 2;
         }
      }

      return true;
   }
}