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
 * @version 	  2
 *                                                                   
 */
App::uses('AppModel', 'Model');
App::uses('ValidationException', 'Lib/Error/Exception');
App::uses('WarningException', 'Lib/Error/Exception');
App::uses('PHPExcel', 'Vendor/PHPExcel');
App::import('Component', 'SessionComponent');

/**
 * Order Model
 */
class Order extends AppModel {

    public $actsAs = array(
        'Email',
        'Containable',
        'Diacritics',
        'Elasticsearch.Searchable' => array(
            'index_find_params' => array(
                'fields'    => array(
                    'subtotal',
                    'gst',
                    'pst',
                    'hst',
                    'delivery_charge',
                    'tip',
                    'total',
                    'first_name',
                    'last_name',
                    'phone',
                    'special_instruction',
                    'coupon_code',
                    'coupon_discount',
                    'Order.coupon_offered_by',
                    'language',
                    'type',
                    'referrer',
                    'method_of_payment',
                    'gateway_status',
                    'device_status',
                    'overall_status',
                    'requested_for',
                    'expected_delivery_time',
                    'created'
                ),
                'contain'   => array(
                    'Location'    => array(
                        'fields' => array(
                            'id',
                            'name',
                            'url',
                        )
                    ),
                    'User'        => array(
                        'fields' => array(
                            'id',
                            'email'
                        ),
                    ),
                    'OrderDetail' => array(
                        'fields' => array(
                            'id',
                            'order_id',
                            'menu_item_id',
                            'name',
                            'quantity',
                            'price',
                            'options',
                            'special_instruction'
                        )
                    )
                ),
                'recursive' => 1
            )
        )
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'location_id'   => array(
            'uuid' => array(
                'rule' => array('uuid'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'points_earned' => array(
            'numeric' => array(
                'rule'    => array('numeric'),
                'message' => 'Must be numeric!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'first_name'    => array(
            'notempty' => array(
                'rule'    => array('notempty'),
                'message' => 'Must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'last_name'     => array(
            'notempty' => array(
                'rule'    => array('notempty'),
                'message' => 'Must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'address'       => array(
            'notempty' => array(
                'rule'    => array('notempty'),
                'message' => 'Must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'city'          => array(
            'notempty' => array(
                'rule'    => array('notempty'),
                'message' => 'Must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
//			'state' => array(
//				'notempty' => array(
//					'rule' => array('notempty'),
//					'message' => 'Must not be empty!',
//					//'allowEmpty' => false,
//					//'required' => false,
//					//'last' => false, // Stop validation after this rule
//					//'on' => 'create', // Limit validation to 'create' or 'update' operations
//				),
//			),
        'postal_code'   => array(
            'notempty'    => array(
                'rule'    => array('notempty'),
                'message' => 'Must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'postal_code' => array(
                'rule'       => "/^(?:[a-zA-Z][0-9][a-zA-Z] {0,1}[0-9][a-zA-Z][0-9])|(?:\d{5}([\-]?\d{4})?)$/",
                'message'    => 'Postal code format must be: H0H 0H0',
                'allowEmpty' => false,
                'required'   => false
            )
        ),
        'phone'         => array(
            'notempty' => array(
                'rule'    => array('notempty'),
                'message' => 'Must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'email'         => array(
            'email' => array(
                'rule'    => array('email'),
                'message' => 'Must be a valid email address',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'language'      => array(
            'notempty' => array(
                'rule'    => array('notempty'),
                'message' => 'Must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'status'        => array(
            'notempty' => array(
                'rule'    => array('notempty'),
                'message' => 'Must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Location' => array(
            'className'  => 'Location',
            'foreignKey' => 'location_id',
        ),
        'User'     => array(
            'className'  => 'User',
            'foreignKey' => 'user_id',
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'OrderDetail' => array(
            'className'    => 'OrderDetail',
            'foreignKey'   => 'order_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
        'DeviceOrder' => array(
            'className'    => 'DeviceOrder',
            'foreignKey'   => 'order_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
        'ReviewCode'  => array(
            'className'    => 'ReviewCode',
            'foreignKey'   => 'order_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
    );
    public $hasOne  = array(
        'Coupon' => array(
            'className'  => 'Coupon',
            'foreignKey' => 'code',
        ),
        'Rating' => array(
            'className'  => 'Rating',
            'foreignKey' => 'order_id'
        )
    );

    /**
     * Default sorting order
     * @var array
     */
    public $order = array('Order.created' => 'DESC');

    /**
     * Virtual Fields
     */
    public $virtualFields = array('total_after_discount' => 'Order.total - IFNULL(Order.coupon_discount, 0)');

    /**
     * Construct -- Build our virtual fields, and set the display name based
     * on language
     *
     */
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->displayField .= (empty($this->langSuffix) ? 'fr' : $this->langSuffix);
    }

    // public function afterSave($created) {
    // 	parent::afterSave($created);
    // }

    /**
     * It will trigger an update to ES with all associated data,
     * as well as send the new order to the printer.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function finishNewOrder($id) {
        $this->id = $id;
        if ($this->exists()) {
            $this->saveField('created', date('Y-m-d H:i:s'));

            $this->DeviceOrder->sendOrder($this->find('first', array(
                    'conditions' => array(
                        'Order.id'            => $id,
                        'Order.device_status' => 'unprocessed'
                    ),
                    'contain'    => array(
                        'OrderDetail',
                        'Location'
                    ),
                    'fields'     => array(
                        'Order.subtotal',
                        'Order.gst',
                        'Order.pst',
                        'Order.hst',
                        'Order.delivery_charge',
                        'Order.tip',
                        'Order.total',
                        'Order.user_id',
                        'Order.first_name',
                        'Order.last_name',
                        'Order.address',
                        'Order.address2',
                        'Order.city',
                        'Order.state',
                        'Order.postal_code',
                        'Order.cross_street',
                        'Order.phone',
                        'Order.special_instruction',
                        'Order.coupon_code',
                        'Order.coupon_discount',
                        'Order.coupon_offered_by',
                        'Order.language',
                        'Order.method_of_payment',
                        'Order.gateway_status',
                        'Order.device_status',
                        'Order.overall_status',
                        'Order.type',
                        'Order.referrer',
                        'Order.requested_for',
                        'Order.expected_delivery_time',
                        'Order.created',
                        'Location.id',
                        'Location.name',
                        'Location.url',
                    ),
                    'recursive'  => 1
            )));
        }
    }

    /**
     * Before we save, if the _en field isn't set (on a new record)
     * set it to the same as _fr
     * 
     */
    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (isset($this->data['Order']['first_name']) && isset($this->data['Order']['last_name'])) {
            $this->data['Order']['name'] = $this->data['Order']['first_name'] . ' ' . $this->data['Order']['last_name'];
        }

        // Sanitize the special instructions field for the printers
        if (!empty($this->data['Order']['special_instruction'])) {
            $this->data['Order']['special_instruction'] = $this->remove_accents($this->data['Order']['special_instruction']);
            $this->data['Order']['special_instruction'] = preg_replace("/[^\w ]/", "?", $this->data['Order']['special_instruction']);
        }
    }

    /**
     * afterFind
     * @param  array  $results Results
     * @param  boolean $primary Is this the primary model?
     * @return array           Results
     */
    public function afterFind($results, $primary = false) {
        // foreach ($results as $key => $result) {
        // 	if (isset($result['Order']['total'])) {
        // 		$results[$key]['Order']['total'] = '$' . number_format((double) $result['Order']['total'], 2);
        // 	}
        // 	if (isset($result['Order']['subtotal'])) {
        // 		$results[$key]['Order']['subtotal'] = '$' . number_format((double) $result['Order']['subtotal'], 2);
        // 	}
        // }

        return $results;
    }

    /**
     * Before Save
     * @param  array  $options
     */
    public function beforeValidate($options = array()) {
        if (isset($this->data['Order']['total'])) {
            $this->data['Order']['total'] = number_format((double) $this->data['Order']['total'], 2);
        }
        if (isset($result['Order']['subtotal'])) {
            $this->data['Order']['subtotal'] = number_format((double) $this->data['Order']['subtotal'], 2);
        }
        return true;
    }

    /**
     * Updates the given order (calculate totals and quatities)
     * 
     * @param array $order array of full order
     * @throws ValidationException Throws exceptions for offline devices, multiple locations in one order incomplete items array
     * 
     * @returns mixe Array representing the order model or FALSE on failure
     */
    public function updateCurrent($order) {

        $deliveryArea = ClassRegistry::init('DeliveryArea');
        $locationId   = $order['Order']['location_id'];

        // set the Order Model with the data in array		
        $this->data = $order['Order'];

        // Make sure we have a numeric value in those fields
        $this->data['subtotal']        = 0;
        $this->data['delivery_charge'] = 0;
        $this->data['total']           = 0;
        $this->data['gst']             = 0;
        $this->data['qst']             = 0;

        // CALCULATE SUBTOTAL

        if (!empty($order['OrderDetail'])) {

            foreach ($order['OrderDetail'] as $key => &$od) {
                if ($od['quantity'] > 0) {
                    $od['subtotal'] = $od['price'];          // set this item subtotal
                    // add options cost				
                    if (!empty($od['options'])) {
                        foreach ($od['options'] as $option) {
                            $od['subtotal'] += $option['price'] * $option['quantity'];  // update items subtotal					
                        }
                    }

                    $od['subtotal']         = $od['subtotal'] * $od['quantity'];    // update items's subtotal				
                    $this->data['subtotal'] = ($this->data['subtotal'] + $od['subtotal']);      // update order's subtotal
                } else {
                    unset($order['OrderDetail'][$key]);         // Remove item from orderDetail
                }
            }
        }


        // DELIVERY CHARGES

        if ($this->data['type'] === 'delivery') {
            if (empty($this->data['postal_code'])) {
                throw new ValidationException(__('Delivery charges may apply.'));
            } else if ($this->data['postal_code']) {        // Delivery chareges for the area of the user
                $pc                            = $this->data['postal_code'];
                $delCharge                     = $deliveryArea->deliversThereAndCharges($locationId, $this->data['postal_code']);
                $this->data['subtotal']        = ($this->data['subtotal'] + $delCharge['delivery_charge']);
                $this->data['delivery_charge'] = $delCharge['delivery_charge'];
            }

            $minReq = $this->checkOrdersMinimalValue($order['Order']);
            if ($minReq['delivers'] !== TRUE) {         // Delivery charges for orders below min required
                $this->data['min_required'] = $minReq['required'];
            } else {               // add delivery charges
                $this->data['subtotal'] = ($this->data['subtotal'] + $minReq['extra']);

                $dc                            = $this->data['delivery_charge'];
                $this->data['delivery_charge'] = $dc + $minReq['extra'];
                $this->data['min_required']    = 0;
            }
        } else {                // take out has no delivery charges
            $this->data['delivery_charge'] = 0;
        }

        $this->_calculateTotals();

        $tmpOrder = array('Order' => $this->data);
        return array_merge(array_merge($order, $tmpOrder));
    }

    /**
     * Calculates and rounds the totals on the order
     */
    private function _calculateTotals() {

        // Apply coupons
        try {
            $this->_applyCouponToOrder();
        } catch (CouponException $e) {

            // If coupon is invalid (throws a CouponException) then calculate the order as if no coupon was applied
            // the controller shoulld verify the coupon before calling this method to output the error messasge and decide 
            // to update the order or not.
            $this->data['coupon_code']     = '';
            $this->data['coupon_discount'] = 0;
            $this->_totalsBeforeCoupons();
        }

        // Round everything
        $this->data['pst']      = round($this->data['pst'], 2, PHP_ROUND_HALF_UP);
        $this->data['gst']      = round($this->data['gst'], 2, PHP_ROUND_HALF_UP);
        $this->data['subtotal'] = round($this->data['subtotal'], 2, PHP_ROUND_HALF_UP);
        $this->data['total']    = round($this->data['total'], 2, PHP_ROUND_HALF_UP);
    }

    /**
     * Calculates the order without any consideration for coupons. 
     */
    private function _totalsBeforeCoupons() {

        $this->_calculateTaxes();

        // Sum the total
        $this->data['total'] = ($this->data['subtotal'] +
            $this->data['gst'] +
            $this->data['pst'] + // total after taxes				
            $this->data['tip']);  // total after tip
    }

    /**
     * Calculate taxes of the orders
     */
    private function _calculateTaxes() {

        $tax = ClassRegistry::init('Tax');
		
        $gst = $tax->find('first', array('conditions' => array('name_en' => 'GST', 'Tax.Province' => Configure::read('I18N.PROVINCE_CODE_2'))));
        $qst = $tax->find('first', array('conditions' => array('name_en' => 'QST', 'Tax.Province' => Configure::read('I18N.PROVINCE_CODE_2'))));

        $this->data['gst']         = $this->data['subtotal'] * ($gst['Tax']['percentage'] / 100); //ex: 10$ * 0.05 =) 0.50$
        $this->data['gst_name']    = $gst['Tax']['name'];
        $this->data['gst_percent'] = $gst['Tax']['percentage'];

        $this->data['pst']         = $this->data['subtotal'] * ($qst['Tax']['percentage'] / 100); // ex.: 10$ * 0.0975 =) 0.98$
        $this->data['pst_name']    = $qst['Tax']['name'];
        $this->data['pst_percent'] = $qst['Tax']['percentage'];
    }

    /**
     * Validate that the order data store in the session is valid before sending to device, database and payment gateway <br/>
     * This only check the order's data is logical. <b>This does not check for security issues</b>
     * @param	array	$data						sesion array representing the order
     * @param	string	$locationId					location's ID
     * @param	bools 	$validateDeliveryAddress	set to false to ignore the delivery address in the validation process
     * @return	array				Valid Order array if no exception where thrown
     */
    public function validateSession($data, $locationId, $validateDeliveryAddress = TRUE) {

        $schedule     = ClassRegistry::init('Schedule');
        $deliveryArea = ClassRegistry::init('DeliveryArea');


        // Order already sent?
        if (!empty($data['Order']['id'])) {
            $session = new SessionComponent(array());
            $session->delete('Order');
            throw new ValidationException(__('Your order has already been sent for payment'));
        }

        // VALIDATE ORDER	
        // restaurant is open for delivery?		
        if (!$schedule->isOpenForDelivery($locationId)) {
            throw new ValidationException(__('This location does not deliver at this time'));
        }

        // DELIVERY STUFF
        if ($data['Order']['type'] === 'delivery' && $validateDeliveryAddress === TRUE) {
            // restaurant delivers in the user's area?		
            if (!empty($data['Order']['postal_code'])) {
                $postalcode = $data['Order']['postal_code'];
            } elseif (!empty($data['Order']['postal_code1'])) {
                $postalcode = $data['Order']['postal_code1'];
            } else {
                throw new WarningException(__('Please select a destination, by signing in of registering'));
            }

            if ($deliveryArea->deliversThereAndCharges($locationId, $postalcode) === FALSE) {
                throw new ValidationException(__('This location does not deliver to this area: ' . $postalcode));
            }
        }

        // order to old?
        $maxOrderAge = 3600;  // 1 hour in seconds

        if (($data['initialize_time'] + $maxOrderAge) < time()) {
            throw new ValidationException('This order is to old. Please log out and try reordering.');
        }

        // UPDATE ORDER
        $data = $this->updateCurrent($data);

        // VALIDATE TOTALS
        if ($data['Order']['subtotal'] < 0) {
            throw new ValidationException(__('invalid order 1382317866'));
        }
        if ($data['Order']['total'] < 0) {
            throw new ValidationException(__('invalid order 1382317891'));
        }
        if ($data['Order']['gst'] < 0) {
            throw new ValidationException(__('invalid order 1382317899'));
        }
        if ($data['Order']['qst'] < 0) {
            throw new ValidationException(__('invalid order 1382317909'));
        }

        // Empty value order
        if (empty($data['OrderDetail'])) {
            throw new ValidationException(__('Order is empty', '1382317933'));
        }

        // Time
        $opendXMinutesAgo = (time() - $data['initialize_time']) / 60;
        $maxMinAllowed    = 60;  // one hour
        if (($opendXMinutesAgo > $maxMinAllowed)) {
            throw new ValidationException(__("Order is to old"));
        }

        return $data;
    }

    /**
     * Validates the OrderDetail (item and it's optoins) part the order array
     * 
     * @param array $data array representing the order's "order details" (an item and it's options)
     * @param string $locationId location's id
     * @param string $categoryName name of this item's category
     * @return array A valid array representing the item and it's option. If no exception where thrown.
     * @throws Exception different exceptin depending on the validation that failed
     */
    public function validateOrderDetail($data, $locationId, $categoryName = null) {

        $menuModel                = ClassRegistry::init('Menu');
        $menuItemModel            = ClassRegistry::init('MenuItem');
        $menuItemOptionModel      = ClassRegistry::init('MenuItemOption');
        $menuItemOptionValueModel = ClassRegistry::init('MenuItemOptionValue');

        // Depending of the calling function, the array structure may be different
        if (!empty($data['MenuItem']['id'])) {
            $itemId = $data['MenuItem']['id'];
        } else {
            $itemId = $data['MenuItem']['menu_item_id'];
        }

        $result = array();

        // MenuItemOptionValues  may come form different array
        if (!empty($data['options'])) {
            $miov = $data['options'];
        } elseif (!empty($data['MenuItemOptionValues'])) {
            $miov = $data['MenuItemOptionValues'];
        } else {
            NULL;
        }

        $item = $menuItemModel->find('first', array(
            'conditions' => array('MenuItem.id' => $itemId),
            'fields'     => array(
                'MenuItem.id',
                'MenuItem.menu_id',
                'MenuItem.description',
                'MenuItem.number_of_instance',
                'MenuItem.price',
                'MenuItem.name')));

        // Check for a multi portion item
        if (!empty($data['MenuItem']['duplicate'])) {
            $isDuplicated = $data['MenuItem']['duplicate'];
        } else {
            $isDuplicated = FALSE;
        }

        // MANUALLY VALIDATE THE DATA SINCE CAKEPHP VALIDATE POST IS TURNED OFF FOR THIS FORM
        // item is valid
        $valid = $menuItemModel->find('first', array(
            'conditions' => array(
                'MenuItem.id'     => $itemId,
                'MenuItem.status' => 'active',
                'MenuItem.price'  => $data['MenuItem']['price'])));
        if ($valid < 1) {
            throw new ValidationException(__('invalid order 1382315649' . var_dump($valid)));
        }
        // Item belongs to location
        $valid = $menuModel->find('count', array(
            'conditions' => array(
                'Menu.id'          => $item['MenuItem']['menu_id'],
                'Menu.location_id' => $locationId)));
        if ($valid < 1) {
            throw new ValidationException(__('invalid order 1382315661'));
        }

        // NUMBER OF REQUIRED OPTIONS
        // Get list of required options	//TODO cake-i-fy this
        $itemId          = preg_match("/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/", $itemId) ? $itemId : NULL; // match UUIDs
        $sql             = "	
				SELECT MenuItemOption.id, MenuItemOption.half_and_half, MenuItemOption.number_of_free_values
				FROM  `menu_item_options` AS MenuItemOption
				INNER JOIN  `menu_item_options_menu_items` AS miomi 
				  ON MenuItemOption.id = miomi.menu_item_option_id
				WHERE miomi.menu_item_id =  '{$itemId}'
				  AND MenuItemOption.required = 1";
        $requiredOptions = $menuItemOptionModel->query($sql);

        // account for the amount of instances
        $nbRequiredOptions = 0;

        foreach ($requiredOptions as $ro) {
            $TmpNbRequiredOptions = 0;
            if ($ro['MenuItemOption']['half_and_half']) {
                if ($ro['MenuItemOption']['number_of_free_values'] > 1) { // multiple number of free values means multiple instance of this field in the form
                    $TmpNbRequiredOptions = ($ro['MenuItemOption']['number_of_free_values']);
                } else {
                    $TmpNbRequiredOptions++;
                }

                // check if many instances of this field is required 
                if (!$isDuplicated) {
                    $nbRequiredOptions += ($TmpNbRequiredOptions * $data['MenuItem']['number_of_instance']);
                } else {
                    $nbRequiredOptions += $TmpNbRequiredOptions;
                }
            } elseif ($ro['MenuItemOption']['number_of_free_values'] > 0) {
                $nbRequiredOptions += $ro['MenuItemOption']['number_of_free_values'];
            } else {
                $nbRequiredOptions++;
            }
        }

        // NUMBER OF UNREQUIRED FREE OPTIONS
        //TODO cake-i-fy this
        $sql = "	
				SELECT MenuItemOption.id, MenuItemOption.half_and_half
				FROM  `menu_item_options` AS MenuItemOption
				INNER JOIN  `menu_item_options_menu_items` AS miomi 
				  ON MenuItemOption.id = miomi.menu_item_option_id
				WHERE miomi.menu_item_id =  '{$itemId}'
				  AND MenuItemOption.required = 0
				  AND MenuItemOption.number_of_free_values > 0;";

        $unreqFreeOptions = $menuItemOptionModel->query($sql);

        // account for the amount of instances
        $nbUnreqFreeOptions = 0;
        foreach ($unreqFreeOptions as $uo) {
            if ($uo['MenuItemOption']['half_and_half']) {
                $nbUnreqFreeOptions += $item['MenuItem']['number_of_instance'];
            } else {
                $nbUnreqFreeOptions++;
            }
        }

        // ITEM'S DATA

        $result['menu_item_id'] = $itemId;
        $result['name']         = $item['MenuItem']['name'];
        if ($categoryName !== null) {
            $result['category_name'] = $categoryName;
        }
        $result['quantity']            = $data['MenuItem']['qty'];
        $result['special_instruction'] = $data['MenuItem']['comment'];
        $result['description']         = $item['MenuItem']['description'];
        $result['price']               = $item['MenuItem']['price'];
        $result['number_of_instance']  = $item['MenuItem']['number_of_instance'];
        $result['duplicate']           = $isDuplicated;


        // ITERATE ALL MENU_ITEM_OPTION_VALUE IN THE REQUEST AND CHECK IF IT RESPECT THE LOCATION'S RESTRICTION
        // Required and free items
        $k = 0;
        if (!empty($miov)) {
            if (!empty($miov['Required']['Free'])) {
                foreach ($miov['Required']['Free'] as $rf) {      // each free options															
                    foreach ($rf['Entities'] as $entitiesIndex => $entity) {  // each options entities					
                        if (!empty($entity)) {
                            foreach ($entity as $optionValue) {     // each values
                                $k++;

                                $nbRequiredOptions--;       // count required options// count required options
                                // prepare session array
                                $optionData = $menuItemOptionValueModel->find('first', array(
                                    'conditions' => array('MenuItemOptionValue.id' => $optionValue)));

                                if (empty($optionData['MenuItemOptionValue'])) { // if MenuItmpOptionValue then the required option is empty
                                    throw new ValidationException(__('Please choose all required options'));
                                }

                                if ($entitiesIndex > 0) {
                                    $optionName = '';       // prefix the option whit it's half number
                                    $optionName = 'ITEM' . $entitiesIndex . '-';
                                    $optionName .= $optionData['MenuItemOptionValue']['name'];
                                } else {
                                    $optionName = $optionData['MenuItemOptionValue']['name'];
                                }

                                $result['options'][$k]['name']     = $optionName;
                                $result['options'][$k]['price']    = 0;
                                $result['options'][$k]['quantity'] = 1;   //TODO count similar items and change quantity																			
                            }
                        }

                        // all entity are identical stop looping entities
                        if ($isDuplicated) {
                            break;
                        }
                    }
                }
            }

            // Required Price
            if (!empty($miov['Required']['Price'])) {
                foreach ($miov['Required']['Price'] as $rp) {  // Required.Free		
                    foreach ($rp['Entities'] as $entitiesIndex => $entity) {  // each options entities	
                        $k++;
                        $nbRequiredOptions--;          // count required options
                        // prepare session array
                        $optionData = $menuItemOptionValueModel->find('first', array(
                            'conditions' => array('MenuItemOptionValue.id' => $entity)));

                        if (empty($optionData['MenuItemOptionValue'])) { // if MenuItmpOptionValue then the required option is empty
                            throw new ValidationException(__('Please choose all required options'));
                        }

                        if ($entitiesIndex > 0) {
                            $optionName = '';          // prefix the option whit it's half number
                            $optionName = 'ITEM' . $entitiesIndex . '-';
                            $optionName .= $optionData['MenuItemOptionValue']['name'];
                        } else {
                            $optionName = $optionData['MenuItemOptionValue']['name'];
                        }

                        $result['options'][$k]['name']     = $optionName;
                        $result['options'][$k]['price']    = $optionData['MenuItemOptionValue']['price'];
                        $result['options'][$k]['quantity'] = 1;      //TODO count similar items and change quantity
                        // all entity are identical stop looping entities
                        if ($isDuplicated) {
                            break;
                        }
                    }
                }
            }

            // Not Required Free		
            $nb = 0;
            if (!empty($miov['NotRequired']['Free'])) {
                foreach ($miov['NotRequired']['Free'] as $entities) {
                    // Check if the request as more free values than the is allowed
                    if (++$nb > $nbUnreqFreeOptions) {
                        throw new ValidationException(__('Error') . print_r($nbUnreqFreeOptions));
                    }

                    $entitiesIndex = 0;

                    foreach ($entities as $entity) {
                        foreach ($entity as $options) {
                            $entitiesIndex++;
                            foreach ($options as $option) {
                                if (!empty($option)) {
                                    $k++;

                                    // prepare session array
                                    $optionData = $menuItemOptionValueModel->find('first', array(
                                        'conditions' => array('MenuItemOptionValue.id' => $option)));
                                    if ($entitiesIndex > 1) {
                                        $optionName = ''; // prefix the option whit it's half number
                                        $optionName = 'ITEM' . $entitiesIndex . '-';
                                        $optionName .= $optionData['MenuItemOptionValue']['name'];
                                    } else {
                                        $optionName = $optionData['MenuItemOptionValue']['name'];
                                    }

                                    $result['options'][$k]['name']     = $optionName;
                                    $result['options'][$k]['price']    = 0;
                                    $result['options'][$k]['quantity'] = 1; //TODO count similar items and change quantity
                                }
                            }
                        }
                        // all entity are identical stop looping entities
                        if ($isDuplicated) {
                            break;
                        }
                    }
                }
            }

            // Extras
            if (!empty($miov['NotRequired']['Extras'])) {
                foreach ($miov['NotRequired']['Extras'] as $entities) {  // Required.Free			
                    $entitiesIndex = 0;

                    foreach ($entities as $entity) {
                        foreach ($entity as $options) {
                            $entitiesIndex++;
                            foreach ($options as $option) {
                                if (!empty($option)) {
                                    $k++;

                                    // prepare session array
                                    $optionData = $menuItemOptionValueModel->find('first', array(
                                        'conditions' => array('MenuItemOptionValue.id' => $option)));
                                    if ($entitiesIndex > 1) {
                                        $optionName = ''; // prefix the option whit it's half number
                                        $optionName = 'ITEM' . $entitiesIndex . '-';
                                        $optionName = $optionName . $optionData['MenuItemOptionValue']['name'];
                                    } else {
                                        $optionName = $optionData['MenuItemOptionValue']['name'];
                                    }

                                    $result['options'][$k]['name']     = $optionName;
                                    $result['options'][$k]['price']    = $optionData['MenuItemOptionValue']['price'];
                                    $result['options'][$k]['quantity'] = 1; //TODO count similar items and change quantity						
                                }
                            }
                        }

                        // all entity are identical stop looping entities
                        if ($isDuplicated) {
                            break;
                        }
                    }
                }
            }
        }

        // Check if the request as more or less free values than the is allowed
        if ($nbRequiredOptions !== 0) {
            $session = new SessionComponent();
            $session->delete('Order');
            throw new ValidationException(__('Please choose all required options'));
        }
        return $result;
    }

    /**
     * Takes order in session and saves it to the database 
     * <b>At this point the data in the session is considered safe</b>
     * 
     * @param	array	$order			order data from session (including Order and OrderDetail)
     * @param	string	$gateway_status Payment Gateway order status: unproccessed, accepted, rejected
     * @param	string	$devcie_status	Device/restaurant's response: unprocessed, accepted, rejected
     * @param	string	$overall_status	Overall state of the order: unprocessed, processing, completed
     * @return	integer 				The id of the newly created order (last inserted id)							
     * @throws	ValidationException	 
     */
    public function session_to_db($order) {

        // SAVE ORDER		
        if (empty($order['Order']['id'])) {

            $order['Order']['expected_delivery_time'] = $order['Order']['requested_for']; //TODO refractor everything instead of doing this		
            $order['Order']['state']                  = $order['Order']['province']; //TODO refractor everything instead of doing this

            $commission = $this->Location->find('first', array(
                'conditions' => array(
                    'Location.id' => $order['Order']['location_id']),
                'fields'     => array(
                    'delivery_commission',
                    'pickup_commission')));

            if ($order['Order']['type'] === 'delivery') {
                $order['Order']['commission_percentage'] = $commission['Location']['delivery_commission'];
            } else {
                $order['Order']['commission_percentage'] = $commission['Location']['pickup_commission'];
            }

            if (!empty($order['special_instructions'])) {
                $order['Order']['special_instructions'] = '';
            }

            if (!empty($order['Order']['id'])) {

                $this->save($order['Order']);
                $orderId = $order['Order']['id'];
            } else {
                $this->create();
                $this->set($order['Order']);
                $this->data['requested_for'] = $order['Order']['requested_for'];
                $this->save($this->data);
                $orderId                     = $this->getLastInsertID();
            }

            if (!$this->validates()) {
                throw new ValidationException(serialize($this->validationErrors));  // send validation errors to the controller
            }



            // SAVE DETAILS

            foreach ($order['OrderDetail'] as &$od) {
                $od['order_id'] = $orderId;   // set id with last inserted order's id
                if (!empty($od['options'])) {  // options array to string
                    $optionString = '';
                    foreach ($od['options'] as $option) {
                        $optionString .= implode('~', $option);  // here the ~ is important has it use as a delimiter by the devices (Model/DeviceOrder.php::_buildStringBody())
                        $optionString .= "||\n";
                    }
                    $od['options'] = $optionString;
                } else {
                    $od['options'] = '';
                }
            }

            $this->OrderDetail->create();
            $this->OrderDetail->saveAll($order['OrderDetail']);
            return $orderId;
        } elseif ($order['Order']['gateway_status'] === 'validation_error') {
            return $order['Order']['id'];
        } else {
            $session = new SessionComponent(null);
            $session->delete('Order');
            throw new ValidationException(__('Your order has already been sent for payment.'));
        }
    }

    /**
     * Gets an order's transaction id
     * @param  int    $id
     * @return (string|false)     transaction_id on success, false on failure
     */
    public function getTransactionId($id) {
        $result = $this->find('first', array(
            'conditions' => array(
                'Order.id' => $id
            ),
            'fields'     => array(
                'Order.transaction_number'
            )
        ));

        if ($result) {
            return $result['Order']['transaction_number'];
        }

        return false;
    }

    /**
     * Check the database to see if the device as reponded for a given order
     * @param 	string	$id			Order's id 
     * @param 	int		$attempt	How many times processing.ctp checked the database
     * @return 	array				The order object
     */
    public function checkDb($id, $attempt) {

        $order = $this->findById($id);
        if ($attempt >= Configure::read('Topmenu.max_attempts')) {  // make sure taht inf processing.ctp timesout the order is cancelled //TODO maybe not necessary				
            $order['Order']['device_status']  = 'timeout';
            $order['Order']['response']       = 'timeout';
            $order['Order']['overall_status'] = 'rejected';
        } else {
            $order['Order']['overall_status'] = ($order['Order']['device_status'] === 'accepted') ? 'waiting_user' : 'waiting_resto';
        }
        $this->save($order);
        return $order['Order'];
    }

    /**
     * Check if the order respect the locations minimum amount requirement
     * 
     * @param	float		$order	The Order.order (order without the order details) array from the session
     * @param	boolean		$order	Set to TRUE to include the delivery charges in the amount to be check againgts the location min price
     * 
     * @return	array 		<ul><li>'delivers'	=>	'TRUE/Error'	// True or error message</li>
     * 						<li>'extra'		=>	0.00			// extra fee added to order</li>
     * 						<li>'required=>	0.00			// Minimun required by restaurant to allow delivery</li></ul>
     * 
     */
    public function checkOrdersMinimalValue($order, $includeDelCharges = FALSE, $postalCode = NULL) {

        // set the subtotal to check agains
        $delCharges = (empty($order['delivery_charge'])) ? 0 : $order['delivery_charge'];    // remove delivery charges
        // include delivery charges?
        if (!$includeDelCharges) {
            $subtotal = $order['subtotal'] - $delCharges;
        } else {
            $subtotal = $order['subtotal'];
        }

        // Remove coupon from the check        
        if (!empty($order['coupon_discount']) && is_numeric($order['coupon_discount'])) {
            $order['subtotal'] = $order['subtotal'] + $order['coupon_discount'];
        }

        // Check the min value for a given postal code (in deliveryarea table)
        if ($postalCode !== NULL) {

            $deliveryAreaModel = ClassRegistry::init('DeliveryArea');

            $postalCode      = strtoupper($postalCode);
            $postalCodeShort = substr($postalCode, 0, 3);    // only start of postal code is needed
            $deliveryArea    = $deliveryAreaModel->find('first', array(
                'conditions' => array(
                    'DeliveryArea.location_id' => $order['location_id'],
                    'DeliveryArea.postal_code' => $postalCodeShort)));

            // Does not deliver to area at all
            if ($deliveryArea === NULL || $deliveryArea === array()) {

                if (empty($postalCode)) {
                    $deliverErrorMessage = __('This Restaurant does not deliver in your area. Please login or choose a different address at the checkout.');
                } else {
                    $deliverErrorMessage = __('Please choose a delivery address.', $postalCode);
                }

                return array('delivers' => $deliverErrorMessage, 'extra' => FALSE, 'required' => NULL);
            } else {

                // Will Deliver if order is bigger
                if ($subtotal < $deliveryArea['DeliveryArea']['delivery_min']) {

                    return array(
                        'delivers' => __('The minimum order for delivery is $ %s (before tips and taxes)', $deliveryArea['DeliveryArea']['delivery_min']),
                        'extra'    => $deliveryArea['DeliveryArea']['delivery_charge'],
                        'required' => $deliveryArea['DeliveryArea']['delivery_min']);
                }

                // Good to go
                return array(
                    'delivers' => TRUE,
                    'extra'    => $deliveryArea['DeliveryArea']['delivery_charge'],
                    'required' => $deliveryArea['DeliveryArea']['delivery_min']);
            }
        }

        // Check for default min values (in location table)
        else {
            $locationModel = ClassRegistry::init('Location');
            $location      = $locationModel->findById($order['location_id']);


            // check required min amount
            if ($subtotal < $location['Location']['delivery_min_order']) {

                return array(
                    'delivers' => FALSE,
                    'extra'    => FALSE,
                    'required' => NULL);
            }
        }

        // Order is above the required minimum
        return array(
            'delivers' => TRUE,
            'extra'    => 0,
            'required' => $location['Location']['delivery_min_order']);
    }

    /**
     * Send invoice by email
     * 
     * @param array		$order		array of the order data
     * @param array		$location	array of the location data
     * @param array		$user		array of the user data
     * @param string	$reviewId	id of the review openned for the user to edit
     * @return boolean  Email sent successfully?
     */
    public function sendInvoiceEmail($order, $location, $user, $reviewId) {

        $data = array(
            'Order'    => $order,
            'Location' => $location,
            'User'     => $user,
            'reviewId' => $reviewId
        );

        $subject = __('Top Menu - Order confirmation');

        $response = $this->sendEmail(
            array(
            'name'    => $user['Profile']['first_name'] . ' ' . $user['Profile']['last_name'],
            'address' => $user['User']['email']), $subject, $data, array('template' => 'invoice'));

        return $response;
    }

    /**
     * Checks all approval fields of the order to see if order is fully approve and completed
     * @param string $orderId UUID of the order to check
     */
    public function isApprovedByAll($orderId) {
        $order = $this->findById($orderId);


        if (empty($order)) {
            return FALSE;
        }

        // Gateway status
        if ($order['Order']['method_of_payment'] != 'cash') {
            if ($order['Order']['gateway_status'] != 'approved') {
                return FALSE;
            }
        }

        // Method of payment
        if ($order['Order']['method_of_payment'] != 'cash' && $order['Order']['method_of_payment'] != 'creditcard') {
            return FALSE;
        }

        // Device status
        if ($order['Order']['device_status'] != 'approved' && $order['Order']['device_status'] != 'accepted') {
            return FALSE;
        }

        // Overall status
        if ($order['Order']['overall_status'] != 'complete' && $order['Order']['overall_status'] != 'cash') {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Apply a coupon (percentage or cash discount)to the given order.
     * @param array $order Full order array
     * @return array the updated order array
     * @todo passing the order array is not object oriented
     * @throws Exception, ValidationException
     */
    function _applyCouponToOrder() {

        if ($this->data['coupon_code'] || $this->data['method_of_payment'] === 'cash') {

            // Get the coupon data
            $coupon = $this->Coupon->findByCode($this->data['coupon_code']);

            // Is coupon valid
            $isValid = FALSE;

            if (!empty($coupon)) {
                $this->Coupon->id = $coupon['Coupon']['id'];
                try {
                    $isValid = $this->Coupon->isValid($this->data['user_id'], $this->data['location_id'], $this->data['coupon_code']); // if not valid throws an ValidationException caught by the controller
                } catch (Exception $e) {
                    $isValid = FALSE;
                    $this->_totalsBeforeCoupons();
                    throw $e;
                }
            } else {
                $this->_totalsBeforeCoupons();
            }

            if ($isValid) {

                // Check if this is coupon is offered (read assume cost) by topmenu or the restaurant itself
                $offeredBy                       = $this->Coupon->data['Coupon']['offered_by'];
                $this->data['coupon_offered_by'] = $offeredBy;

                // Get discount value
                if ($this->Coupon->data['Coupon']['amount_type'] === 'percent') { // Percentage discount
                    $this->data['coupon_discount'] = (($this->data['subtotal'] - $this->data['delivery_charge']) * ($this->Coupon->data['Coupon']['amount'] / 100));
                } elseif ('cash') { // Fixe cash amount discount
                    $discount                      = $this->Coupon->data['Coupon']['amount'] - $this->data['total'];
                    $this->data['coupon_discount'] = ( $discount > 0 ) ? $discount : 0;
                } else {
                    throw new Exception('Invalid value for Coupon.amount_type');
                }

                // apply the discount to the order
                if ($offeredBy === 'topmenu') {
                    $this->_totalsBeforeCoupons();   // calculate all the totals before 
                    $this->data['total'] = ($this->data['total'] - $this->data['coupon_discount']);
                } elseif ($offeredBy === 'restaurant') {
                    $this->data['subtotal'] = ($this->data['subtotal'] - $this->data['coupon_discount']); // Add discount before calculating taxes
                    $this->_totalsBeforeCoupons();
                } else {
                    throw new Exception('Invalid value for Coupon.offered_by');
                }
            } else {
                $this->data['coupon_code']     = '';
                $this->data['coupon_discount'] = 0;
                $this->_totalsBeforeCoupons();
            }
        } else {

            // Don't apply any coupons
            $this->data['coupon_code']     = '';
            $this->data['coupon_discount'] = 0;
            $this->_totalsBeforeCoupons();
        }
    }

    public function raiseFardFlagForUser($userId) {
        
    }

    private function suspiciousAmountOfOrderLately($userId, $period = 48) {
        
    }

    /**
     * Check if the user has ever made any user
     * @param string $userId user's id
     * @return boolean true if this is the user's first order, false otherwise
     */
    public function isFirstOrder($userId) {
        $orders = $this->find('count', array(
            'conditions' => array(
                'Order.user_id' => $userId)));

        return ($orders > 1);
    }

    /**
     * Hardcoded situation where a user receives a discount
     * <i>ex.: on the 10th order a 10% discount is automatically applied to the order</i>
     * @param type $userId
     * @return array An array representing the discount model
     * @todo this is the begining of an entire new module. At the moment we only use it for the "user's first order" situation
     */
    public function availableDiscount($userId) {

        if ($this->isFirstOrder($userId)) {
            return $this->Coupon->findByCode('firstcoupon');
        }

        return NULL;
    }

    /**
     * Calculate the restaurant's total which may be different from the user's total if a Topmenu (as opppose to the restaurants own) coupon is applied to the order
     * @param array $order the entire order array
     * @return float rounded total for the restaurant 
     */
    public function getRestaurantTotal($order) {

        if ($order['Order']['coupon_offered_by']) {
            if ($order['Order']['coupon_offered_by'] === 'topmenu') {
                return round($order['Order']['total'] + $order['Order']['coupon_discount'], 2);
            }
        }

        return $order['Order']['total'];
    }

    /**
     * This will generate the custom accounting report in the form of a cakephp like array<br/>
     * <i>The start and end date are inclusives</i>
     * 
     * @param mix $startTimeStamp 	Start of range to query - Unix Time stampt (in) or date string (will be converted using strtotime())
     * @param mix $endTimeStamp		End of range to query - Unix Time stampt (in) or date string (will be converted using strtotime())
     * @param type $conditions		String of conditions that will be append to the where clause of the query. The string should start with 'AND'<br/>
     * 								ex: $conditions = 'AND id = 12'; // will give this query: "SELECT ... FROM ORDERS ... WHERE  Order.created BETWEEN '$startDate' AND '$endDate' <b>AND id = 12</b> ORDER BY...";
     * @return array				Cakephp result Array
     * @throws ValidationException If any errors occurs while updating database
     */
    public function generateReports($startTimeStamp = 0, $endTimeStamp = NULL, $conditions = "") {

		
        // Format date to mysql format
        $format = 'Y-m-d';                                      // this format will default to the beginning of the given day to june 13 at 11am is 2014-06-13 00:00:00 so we have to add a day to the end date
		
		// convert array date to string //TODO this should be converted into a behavior or a component
		if(is_array($startTimeStamp)){
			$startTimeStamp =   $startTimeStamp['year'] . '-' .$startTimeStamp['month'] . '-' . $startTimeStamp['day'];
		}		
        if (is_numeric($startTimeStamp)) {
            $startDate = date($format, $startTimeStamp);
        } else {
            $tmpDate = strtotime($startTimeStamp);
            if ($tmpDate) {
                $startDate = date($format, $tmpDate);
            } else {
                throw new Exception("Invalide date formant for parameter 1 <br/>$startTimeStamp");
            }
        }
		
		if(is_array($endTimeStamp)){
			$endTimeStamp =   $endTimeStamp['year'] . '-' .$endTimeStamp['month'] . '-' . $endTimeStamp['day'];
		}
        if (is_numeric($endTimeStamp)) {
            $endDate = ($endTimeStamp === NULL) ? date($format, time()) : date($format, $endTimeStamp + DAY);   // adding a day means ending at midnight of the givent day
        } else {
            $tmpDate = strtotime($endTimeStamp);
            if ($tmpDate) {
                $endDate = date($format, $tmpDate + DAY);   // adding a day means ending at midnight of the givent day
            } else {
                throw new Exception("Invalide date formant for parameter 2<br/>$endTimeStamp");
            }
        }

        // Create the conditions string that will be append to the WHERE clause in the query 
        if (empty($conditions)) {
            $conditionsString = "AND (`Order`.overall_status = 'complete' OR `Order`.overall_status = 'waiting_user' OR `Order`.overall_status = 'reimbursement' )";
        } else {
            //TODO not tested
            $conditionsString = "AND (`Order`.overall_status = 'complete' OR `Order`.overall_status = 'waiting_user' OR `Order`.overall_status = 'reimbursement')";
            $conditionsString .= $conditions;
        }

        // Removed unwanted orders form report
        $this->_disableOrderForUsers();

        // Query database

        /**
         * These columns are only selected to receive data from the later computation (to keep it in the right order)
         * `Order`.`commission_percentage` AS 'Commission %', 
         * `Order`.`commission_percentage` AS 'Commission $',  
         * `location_id` AS 'Restaurant',
         */
        $query = " 
			SELECT 
			  `Order`.`id` AS '# Commande',   
              `Order`.created AS 'Date',    
			  `location_id` AS 'Restaurant',
			  `Location`.`name`,			   
			  ROUND((subtotal - `delivery_charge`), 2) AS 'Nourriture',     
			  delivery_charge AS 'Frais Livraison', 
			  ROUND((subtotal), 2) AS 'Sous-total',
			  `gst` AS 'TPS', 
			  `pst` AS 'TVQ',   
			  `tip` AS 'Pourboire',
			  `coupon_discount` AS 'Coupon',
			  `total` AS 'Total',   
			  `Order`.`commission_percentage` AS 'Commission %', 
			  `Order`.`commission_percentage` AS 'Commission $',  
			  `Order`.`commission_percentage`/100 AS 'com_percent',  
			   ROUND(((`Order`.`commission_percentage`/100) * `Order`.subtotal), 2) AS 'com_amount',  
			  `special_instruction` AS 'Note',
			  `type` AS 'Livraison',  
			  `method_of_payment` AS 'Cash/Credit',
			  `location_id`,
			   `user_id`,
			   `delivery_charge`,
			   `subtotal`,
			   `hst`,
			   `pst`,
			   `gst`,
			   `tip`,
			   `first_name`,
			   `last_name`,
			   `Order`.`address`,
			   `address2`,
			   `Order`.`city`,
			   `Order`.`state`,
			   `Order`.`postal_code`,
			   `Order`.`cross_street`,
			   `Order`.`door_code`,
			   `Order`.`phone`,
			   `Order`.`email`,
			   `Order`.`language`,
			   `requested_for`,
			   `expected_delivery_time`,
				`gateway_status`,
			   `device_status`,
			   `overall_status`,
			   `transaction_number`,
			   `response`
			FROM `orders` AS `Order`
			JOIN locations AS Location ON Order.location_id = `Location`.id			
			WHERE (Order.created BETWEEN '$startDate' AND '$endDate') $conditionsString
			ORDER BY Order.id DESC";

        $db     = $this->getDataSource();
        $result = $db->fetchAll($query);
        foreach ($result as $kr => $r) {
            $result[$kr]['Order']['Commission %'] = $result[$kr][0]['com_percent'];
            $result[$kr]['Order']['Commission $'] = $result[$kr][0]['com_amount'];
            $result[$kr]['Order']['Restaurant']   = $result[$kr]['Location']['name'];
        }

        // Validation exception
        if (!empty($this->Order->validationErrors)) {
            throw new ValidationException(implode(';', $this->Order->validationErrors));
        }

        return $result;
    }

    /**
     * Genereates the bi monthly statements for each restaurants with online ordering and outputs it to the browser to be downloaded
     * @param string $startTimeStamp date (MySQL format) of the beginning of the period
     * @param string $endTimeStamp date (MySQL format) of the end of the period
     * @param bool $showDetails Display the order history for each restaurant or not. <b>Defaults to false<b>
     * @param string $lang Local language Code (ex: 'fr') of the language to be use when generating date string and stuff 
     * @param string $restaurant UUID of the specific restaurant wanted in the report. Null will include all restaurants in the report
     * @todo <ul><li>check for restaurant that have orders although they are currently set as pdf restaurants</li><li>Localise the month name in the restaurant sheet header</li></ul>
     */
    public function bimonthlyRestaurantReport($startTimeStamp = NULL, $endTimeStamp = NULL, $showDetails = FALSE, $lang = 'fr', $restaurant = null) {

        //TODO handle datetime string pass to this function        
        $startDateTime = new DateTime($startTimeStamp);
        $endDateTime   = new DateTime($endTimeStamp);

        // Get all locations accepting online delivery
        $locationModel = ClassRegistry::init('Location');
        if (empty($restaurant)) {
            $locations = $locationModel->find('all', array('conditions' => array('online_ordering' => 1)));
        } else {
            $locations[0] = $locationModel->findById($restaurant);
        }

        // H1 style for workbook
        $h1StyleArray = array('font' => array('bold' => true, 'size' => 15));

        // Creating the workbook
        $objPHPExcel = new PHPExcel();
        $objPHPExcel
            ->getProperties()->setCreator("Topmenu System")
            ->setCreated(date('Y-m-d', time()))
            ->setLastModifiedBy("Topmenu_System")
            ->setTitle("Rapport_bimensuel_TopmenuCom_$startTimeStamp")
            ->setSubject("Rapport bimensuel par restaurant depuis le $startTimeStamp jusqu'au $endTimeStamp")
            ->setKeywords("Rapport_bimensuel");

        // Cover Page
        $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:K1')
            ->setCellValue('A1', __('Bimensuel Report for %s', Configure::read('Topmenu.company.name')))
            ->mergeCells('A2:K2')
            ->setCellValue('A2', __('FROM: %s', $startTimeStamp))
            ->mergeCells('A3:K3')
            ->setCellValue('A3', __('TO: %s', $endTimeStamp))
            ->mergeCells('A4:K4')
            ->setCellValue('A4', __('Generated On: %s', date('Y-m-d H:i:s')))
            ->setCellValue('B4', date('Y-m-d H:i:s'));

        // Header of the global statement 
        $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A6:M6')
            ->mergeCells('A7:B7')            // Restaurants info
            ->mergeCells('C7:I7')            // Credit card section
            ->mergeCells('J7:M7')            // Cash Commission
            
            ->setCellValue('A6', __("Global report"))   // Restaurant info
            ->setCellValue('A8', __("Restaurants"))
            ->setCellValue('B8', __("Contract"))
            
            ->setCellValue('C7', __("Credit Card"))     // Credit Card
            ->setCellValue('C8', __("CC Trans."))
            ->setCellValue('D8', __("Fees"))
            ->setCellValue('E8', __("F. Taxes"))
            ->setCellValue('F8', __("F. Total"))            
            ->setCellValue('G7', __("CC Commi."))
            ->setCellValue('H8', __("CC Taxes"))
            ->setCellValue('I8', __("CC CommTax"))
            
            ->setCellValue('J7', __("Cash")) // Cash
            ->setCellValue('J8', __("Ca. Trans.")) // Cash
            ->setCellValue('K8', __("Ca. Commi."))
            ->setCellValue('L8', __("Ca. Taxe"))
            ->setCellValue('M8', __("Ca. CommTax"))
            
            ->setCellValue('N8', __("Order Total"))                       
            ->setCellValue('O8', __("Commi. Total"))                       
            ->setCellValue('P8', __("Total Owe"))       // Total owe to restaurant
            ->setCellValue('Q8', __("Order Count"));      // Total owe to restaurant
        // Styling Cover Page
        $objPHPExcel->getActiveSheet()->setTitle(__('Summary'))
            ->getStyle('A1')->applyFromArray($h1StyleArray);
        
        // Before fetching all the orders remove the ones made with test accounts
        $this->_disableOrderForUsers();

        // Build one sheet for each restaurant
        $i = 0;
        foreach ($locations as $l) {

            // Create new worksheet
            // Clean Restaurant name
            $cleanerRestoName = preg_replace("/restaurant(s)*./i", "", $l['Location']['name']);         // Remove the "restaurant" "string from the name
            $cleanerRestoName = preg_replace("/[\W*]/", "-", $this->remove_accents($cleanerRestoName)); // Remove special characters and diacritics
            $cleanerRestoName = preg_replace("/-{2,}/", "-", $this->remove_accents($cleanerRestoName)); // Remove any occurence of multiple dash in row
            $cleanerRestoName = substr($cleanerRestoName, 0, 30);                                       // PHPExcel (or Excel) doesnt not allow sheet title longer than 30 chars

            $objWorksheet = $objPHPExcel->createSheet();
            $objWorksheet->setTitle($cleanerRestoName);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            // Write Body
            $fromToDateString = __('Statement for %s %s (day %s to %s)', strftime("%B", $startDateTime->getTimestamp()), $startDateTime->format('Y'), $startDateTime->format('j'), $endDateTime->format('j'));
            $this->_bimonthlyReportRestaurantHeader($objWorksheet, $l, $fromToDateString);                                     // header
            $summaryArray     = $this->_bimonthlyReportBody($objWorksheet, $l, $startTimeStamp, $endTimeStamp, $showDetails);   // body
            // Add the restaurant summary to overall statement
            $cr               = 9 + $i; // overall summary current row
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$cr", $summaryArray['restaurant'])
                ->setCellValue("B$cr", $l['Location']['contract_number'])
                
                ->setCellValue("C$cr", $summaryArray['ccTransactions'])
                ->setCellValue("D$cr", $summaryArray['ccFee'])
                ->setCellValue("E$cr", $summaryArray['ccFeeTaxe'])
                ->setCellValue("F$cr", $summaryArray['ccFeeWithTaxe'])
                ->setCellValue("G$cr", $summaryArray['ccCommision'])
                ->setCellValue("H$cr", $summaryArray['ccCommisionTaxe'])
                ->setCellValue("I$cr", $summaryArray['ccCommisionWithTaxe'])
                
                ->setCellValue("J$cr", $summaryArray['cashTransactions'])
                ->setCellValue("K$cr", $summaryArray['cashCommision'])
                ->setCellValue("L$cr", $summaryArray['cashCommisionTaxe'])
                ->setCellValue("M$cr", $summaryArray['cashCommisionWithTaxe'])
                
                ->setCellValue("N$cr", $summaryArray['ccTransactions'] + $summaryArray['cashTransactions'])
                ->setCellValue("O$cr", $summaryArray['commissionTotal'])
                ->setCellValue("P$cr", $summaryArray['oweToRestaurant'])
                ->setCellValue("Q$cr", $summaryArray['orderCount'])
            ;
            $i++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        // Output to browser (download)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rapport_bimensuel_TopmenuCom_' . $startTimeStamp . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');                 // If you're serving to IE 9, then the following may be needed        
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');   // If you're serving to IE over SSL, then the following may be needed (Date in the past)
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate');    // HTTP/1.1
        header('Pragma: public');                           // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * Iterates a list of user a set all the orders made by them to "DELETED"
     * @return boolean true on sucess without any errros
     * @throws ValidationException If any errors occurs while updating database
     */
    private function _disableOrderForUsers() {

        // get all the user for which orders should not be accounted for (testers)
        $testingUserModel = ClassRegistry::init('TestingUser');
        $testers          = $testingUserModel->find('all');

        // "deleted" orders
        foreach ($testers as $v) {

            $this->UpdateAll(
                array('Order.overall_status' => "'DELETED'"), array('Order.user_id' => $v['TestingUser']['id']));
        }

        // Validation exception
        if (!empty($this->Order->validationErrors)) {
            throw new ValidationException(implode(';', $this->Order->validationErrors));
        }

        return true;
    }

    /**
     * Groups and counts all the order status for a givent time period before now (defaults to 1 week).<br/>
     * This send will return data for the pie chart object of the Chart.js librairy.
     * @param int $goBackToSecondes how far back should we go back to make the stats in seconds (ex: time() - 60 = count orders in the last minute)
     * @return array array ready to converted to json to create a pie charte using Chart.js
     */
    public function ordersStatusPieChartData($goBackToSecondes = WEEK) {

        $startDate     = date('Y-m-d', time() - $goBackToSecondes);
        // Get data         
        $groupedOrders = $this->find(
            'all', array(
            'conditions' => array(
                'Order.created > ' => $startDate
            ),
            'fields'     => array(
                "Order.overall_status AS label",
                "COUNT(Order.overall_status) AS value"
            ),
            'group'      => array("Order.overall_status"),
            'order'      => array('Order.id' => 'DESC')));

        // Convert into a Chart.js array which will be converted to json in the controller
        $result             = array();
        $result[0]['value'] = 0;
        $result[1]['value'] = 0;
        $result[2]['value'] = 0;
        $result[3]['value'] = 0;
        $result[4]['value'] = 0;
        $result[5]['value'] = 0;

        foreach ($groupedOrders as $go) {
            switch ($go['Order']['label']) {
                case 'processing':
                    $result[4]['label'] = __('Unprocess');
                    $result[4]['color'] = "#F7DE3B";
                    $result[4]['value'] += (float) $go[0]['value'];
                    break;
                case 'complete':
                    $result[0]['label'] = __('All Good');
                    $result[0]['color'] = "#dff0d8";
                    $result[0]['value'] += (float) $go[0]['value'];
                    break;
                case 'rejected':
                    $result[1]['label'] = __('Rejected');
                    $result[1]['color'] = "#f2dede";
                    $result[1]['value'] += (float) $go[0]['value'];
                    break;
                case 'timeout ':
                    $result[2]['label'] = __('Timeout');
                    $result[2]['color'] = "#d9edf7";
                    $result[2]['value'] += (float) $go[0]['value'];
                    break;
                case 'waiting_user':
                case 'waiting_resto':
                    $result[3]['label'] = __('Waiting');
                    $result[3]['color'] = "#FFFF85";
                    $result[3]['value'] += (float) $go[0]['value'];
                    break;

                default:
                    $result[5]['label'] = __('Others');
                    $result[5]['color'] = "#dddddd";
                    $result[5]['value'] += (float) $go[0]['value'];
                    break;
            }
        }

        return $result;
    }

    public function revenuByMonthData($yearsIncluded = 5) {

        $data   = array();
        $result = array();
        for ($index = 0; $index < $yearsIncluded; $index++) {   // get all past years as diffenrent lines of the graph
            // date range
            $beginingOline = date('Y', time()) - ($index + 1) . "-12-31"; // december 31st last year
            $endOline      = date('Y', time()) - $index . "-12-31"; // decmber 31 this year
            // query
            $data[$index]  = $this->find('all', array(
                'conditions' => array(
                    'Order.created BETWEEN ? AND ?' => array($beginingOline, $endOline),
                    'AND'                           => array(
                        'OR' => array(
                            array('Order.overall_status' => 'complete'),
                            array('Order.overall_status' => 'waiting_user')
                        )
                    )
                ),
                'fields'     => array("(SUM(Order.total)) AS value", "MONTH(Order.created) AS m", "'$beginingOline' AS 'year'"),
                'group'      => array('MONTH(Order.created)'),
                'order'      => array('MONTH(Order.created)' => 'ASC')
            ));
        }

        // format array for Chart.js
        $result['labels'] = array(
            __("January"),
            __("February"),
            __("March"),
            __("April"),
            __("May"),
            __("June"),
            __("July"),
            __("August"),
            __("September"),
            __("October"),
            __("November"),
            __("December"));
        foreach ($data as $key => $value) {

            // Color of lines

            $colorNumberMd5 = (substr(md5($key), 6, 6));                                                // transform year to md5 and gets only six of those characters;
            $colorRgbArray  = $this->hex2rgb($colorNumberMd5);                                          // convert the hex color to rgb array
            $rgbStrokeStr   = "rgba({$colorRgbArray[0]}, {$colorRgbArray[1]}, {$colorRgbArray[2]}, .8)";   // create string for json array
            $rgbFillStr     = "rgba({$colorRgbArray[0]}, {$colorRgbArray[1]}, {$colorRgbArray[2]}, .2)";  // create string for json array
            $rgbPointStr    = "rgba({$colorRgbArray[0]}, {$colorRgbArray[1]}, {$colorRgbArray[2]}, 1)";  // create string for json array

            $result['datasets'][$key]['label']       = (int)date('Y', time()) - $key;
            $result['datasets'][$key]['fillColor']   = $rgbFillStr;
            $result['datasets'][$key]['strokeColor'] = $rgbStrokeStr;
            $result['datasets'][$key]['pointColor']  = $rgbPointStr;

            // data for each month (mysql start)            
            for ($index = 1; $index <= 12; $index++) {
                $asValue = false;
                foreach ($value AS $m) {
                    if ($m[0]['m'] == $index) {
                        $asValue = true;
                        break;
                    }
                }

                $result['datasets'][$key]['data'][] = $asValue ? (float) $m[0]['value'] : 0;
            }
            // months
        }

        return $result;
    }

    /**
     * Converts a CSS Hexadicmal color string to a CSS RGB color string
     * @param string $hex CSS Hexadecimal value of a color
     * @return string the color as CSS RGB color string
     */
    private function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    /**
     * This prints the header with the locations information for each restaurants sheet
     * 
     * @param Worksheet $objWorksheet current worksheet being generated
     * @param array $l current location being genearated
     * @param string $statementDate Begining of the statement period
     */
    private function _bimonthlyReportRestaurantHeader($objWorksheet, $l, $statementDate = '') {

        $h1StyleArray = array('font' => array('bold' => true, 'size' => 15));
        $h2StyleArray = array('font' => array('bold' => true, 'size' => 13));
        $objWorksheet->getStyle('A1')->applyFromArray($h1StyleArray);
        $objWorksheet->getStyle('A5')->applyFromArray($h2StyleArray);
        $objWorksheet->getStyle('A5:K5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD00');

        // Company info 
        $objWorksheet->mergeCells('A1:K1')
            ->setCellValue('A1', Configure::read('Topmenu.company.name') . ' — ' . $statementDate)
            ->mergeCells('A2:K2')
            ->setCellValue('A2', Configure::read('Topmenu.company.address') . " — " . Configure::read('Topmenu.company.phone'))
            ->mergeCells('A3:K3')
            ->setCellValue('A3', Configure::read('Topmenu.company.city') . ' (' . Configure::read('Topmenu.company.city') . ')  ' . Configure::read('Topmenu.company.postal_code'))

            // Location info
            ->mergeCells('A5:K5')
            ->setCellValue('A5', $l['Location']['name'])
            ->mergeCells('A6:K6')
            ->setCellValue('A6', $l['Location']['short_address']);
    }

    /**
     * This genearetes the body of the restaurant specific period of time if one if provide or for everything since the 
     * begining if no time period is provided
     * 
     * @param Worksheet $objWorksheet current worksheet being generated
     * @param array $l current location being genearated
     * @param string $startDate begining of period to be included in report <b>MySQL date format</b>
     * @param string $endDate end of period to be included in report.  <b>MySQL date format</b>
     * @param bool $showDetails Display the order history for each restaurant or not. <b>Defaults to false<b>
     * @return array Array representing a row of the overall summary for the current restaurant
     * @todo refactor into many smaller functions
     */
      private function _bimonthlyReportBody($objWorksheet, $l, $startDate = NULL, $endDate = NULL, $showDetails = FALSE) {

        $startDate = ($startDate === NULL) ? '2014-01-01 00:00:00' : $startDate;    // 2014-01-01 represent the opening day of the site.
        $endDate   = ($endDate === NULL) ? date('Y-m-d H:i:s', time()) : $endDate;
        $taxeRate  = Configure::read('Taxes.gst.rate') + Configure::read('Taxes.pst.rate');

        // Get all valid orders for this restaurant in the report time range
        $conditions               = array('conditions', 'fields');
        $conditions['fields']     = array('Order.id', 'Order.method_of_payment', 'Order.subtotal', 'Order.type', 'Order.delivery_charge', 'Order.tip', 'Order.created', 'Order.pst', 'Order.gst', 'Order.coupon_discount', 'Order.total');
        $conditions['conditions'] = array(
            'AND' => array(
                'Order.location_id' => $l['Location']['id'],
                'OR'                => array(
                    array('Order.overall_status' => 'complete'),
                    array('Order.overall_status' => 'waiting_user')),
                'AND'               => array(
                    'Order.created > ' => $startDate,
                    'Order.created < ' => $endDate))
        );
        $orders                   = $this->find('all', $conditions);

        // Varaible use for the calculation of the deposit
        $summaryArray                          = array();   // Array representing a row of the overall summary for the current restaurant
        $summaryArray['restaurant']            = $l['Location']['name'];
        $summaryArray['ccTransactions']        = 0;         // Total spent where the method of payment was credit cards        
        $summaryArray['ccFee']                 = 0;         // sum of credit card fees added to credit card orders
        $summaryArray['ccFeeTaxe']             = 0;         // sum of taxes on credit card fees
        $summaryArray['ccFeeWithTaxe']         = 0;         // sum of cc fees with taxes
        $summaryArray['ccCommision']           = 0;         // commission taken by TM on cc
        $summaryArray['ccCommisionTaxe']       = 0;         // taxe on commission taken by TM on cc
        $summaryArray['ccCommisionWithTaxe']   = 0;         // commission taken by TM on cc with the taxes
        $summaryArray['cashTransactions']      = 0;         // Total spent where the method of payment was cash
        $summaryArray['cashCommision']         = 0;         // commission taken by TM on cash
        $summaryArray['cashCommisionTaxe']     = 0;         // taxe on commission taken by TM on cash
        $summaryArray['cashCommisionWithTaxe'] = 0;         // commission taken by TM on cash with the taxes
        $summaryArray['commissionTotal']       = 0;         // Total of TM commission (cash and cc)
        $summaryArray['oweToRestaurant']       = 0;         // Money that TM should be sending to restaurant
        $summaryArray['orderCount']            = 0;         // Number of orders for this restaurants during period
        //
        // Calculate and display the summary AND calculate and display the orders history
        $orderHistoryRows                      = 17; // Starting row of the credit card orders history table (starts after the summary)
        foreach ($orders as $o) {

            $commisionsBase = $o['Order']['subtotal'] + $o['Order']['tip'];    // base on what the commission is calculated (the commision base differ from credit card and cash orders but not this part)
            $commisionRate  = ($o['Order']['type'] === 'delivery') ? $l['Location']['delivery_commission'] / 100 : $l['Location']['pickup_commission'] / 100;
            $summaryArray['orderCount']++;

            if ($o['Order']['method_of_payment'] === 'creditcard') {

                // Calculation for summary
                $summaryArray['ccTransactions'] += ($o['Order']['total'] + $o['Order']['coupon_discount']);  // total
                $summaryArray['ccFee'] += $l['Location']['credit_card_fee'];

                // Comission
                $commisionsBase += $l['Location']['credit_card_fee'];   // add the credit card fee to the amount with take a commission on.
                $commisionsTotal = $commisionsBase * $commisionRate;

                $summaryArray['ccCommision'] += $commisionsTotal;
                $summaryArray['ccCommisionTaxe'] += $commisionsTotal * $taxeRate;
                $summaryArray['ccCommisionWithTaxe'] += $commisionsTotal * (1 + $taxeRate );
                $summaryArray['commissionTotal'] += ($commisionsTotal * (1 + $taxeRate ));
                $ccFeeWithTaxe = $l['Location']['credit_card_fee'] * (1 + $taxeRate );
                
                $currentOrderOweToRestaurant = ($o['Order']['total'] + $o['Order']['coupon_discount']) - (($commisionsBase * $commisionRate) * (1 + $taxeRate )) - ($l['Location']['credit_card_fee'] * (1 + $taxeRate ));
                $summaryArray['oweToRestaurant'] += $currentOrderOweToRestaurant;
            } else {
                $summaryArray['ccFeeWithTaxe'] = 0;
                $summaryArray['cashTransactions'] += ($o['Order']['total']);  // total
                $ccFeeWithTaxe = 0;

                // Comission          
                $commisionsTotal = $commisionsBase * $commisionRate;

                $summaryArray['cashCommision'] += $commisionsBase * $commisionRate;
                $summaryArray['cashCommisionTaxe'] += $commisionsTotal * $taxeRate;
                $summaryArray['cashCommisionWithTaxe'] += $commisionsTotal * (1 + $taxeRate );
                $summaryArray['commissionTotal'] += ($commisionsTotal * (1 + $taxeRate ));
                
                $currentOrderOweToRestaurant = 0 - (($commisionsBase * $commisionRate) * (1 + $taxeRate ));
                $summaryArray['oweToRestaurant'] += $currentOrderOweToRestaurant;
								
								// Change background color of row for cash orders
								$objWorksheet->getStyle("A$orderHistoryRows:K$orderHistoryRows")->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFDDDDDD');
								
								
            }

            // Print order history
            if ($showDetails) {
                $objWorksheet->setCellValue("A$orderHistoryRows", $o['Order']['id']);
                $objWorksheet->setCellValue("B$orderHistoryRows", date('d', strtotime($o['Order']['created'])));
                $objWorksheet->setCellValue("C$orderHistoryRows", round($o['Order']['gst'], 2). " $");
                $objWorksheet->setCellValue("D$orderHistoryRows", round($o['Order']['pst'], 2). " $");
                $objWorksheet->setCellValue("E$orderHistoryRows", round($o['Order']['subtotal'], 2). " $");
                $objWorksheet->setCellValue("F$orderHistoryRows", round($o['Order']['delivery_charge'], 2). " $");
                $objWorksheet->setCellValue("G$orderHistoryRows", round($o['Order']['total'] + $o['Order']['coupon_discount'], 2). " $");
                $objWorksheet->setCellValue("H$orderHistoryRows", round($o['Order']['tip'], 2). " $");
                $objWorksheet->setCellValue("I$orderHistoryRows", round($ccFeeWithTaxe, 2). " $");
                $objWorksheet->setCellValue("J$orderHistoryRows", round($commisionsTotal, 2). " $");
                $objWorksheet->setCellValue("K$orderHistoryRows", round($currentOrderOweToRestaurant, 2). " $");
            }

            $orderHistoryRows++;
        }

        // Rounding
        $summaryArray['ccTransactions'] = round($summaryArray['ccTransactions'], 2) . " $";
        $summaryArray['ccFee']         = round($summaryArray['ccFee'], 2) . " $";                      // added the taxes,2);
        $summaryArray['ccFeeTaxe']     = round($summaryArray['ccFee'] * $taxeRate, 2) . " $";          // added the taxes,2);
        $summaryArray['ccFeeWithTaxe'] = round($summaryArray['ccFee'] * (1 + $taxeRate ), 2) . " $";   // added the taxes,2);        

        $summaryArray['ccCommision']         = round($summaryArray['ccCommision'], 2) . " $";                // added the taxes,2);
        $summaryArray['ccCommisionTaxe']     = round($summaryArray['ccCommision'] * $taxeRate, 2) . " $";    // added the taxes,2);
        $summaryArray['ccCommisionWithTaxe'] = round($summaryArray['ccCommision'] * (1 + $taxeRate ), 2) . " $";  // added the taxes,2);

				$summaryArray['cashTransactions'] = round($summaryArray['cashTransactions'], 2) . " $";
        $summaryArray['cashCommision']         = round($summaryArray['cashCommision'], 2) . " $";              // added the taxes,2);
        $summaryArray['cashCommisionTaxe']     = round($summaryArray['cashCommision'] * $taxeRate, 2) . " $";  // added the taxes,2);
        $summaryArray['cashCommisionWithTaxe'] = round($summaryArray['cashCommision'] * (1 + $taxeRate ), 2) . " $";  // added the taxes,2);

        $summaryArray['commissionTotal'] = round($summaryArray['commissionTotal'], 2) . " $";
        $summaryArray['oweToRestaurant'] = round($summaryArray['oweToRestaurant'], 2) . " $";

        // Some cell formating
        $h2StyleArray = array('font' => array('bold' => true, 'size' => 13));
        $objWorksheet->getStyle('A8')->applyFromArray($h2StyleArray);
        $objWorksheet->getStyle('A8:K8')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD00');
        $objWorksheet->getStyle('A14')->applyFromArray($h2StyleArray);
        $objWorksheet->getColumnDimension('A')->setWidth(6.86);
        $objWorksheet->getColumnDimension('B')->setWidth(6.86);
        $objWorksheet->getColumnDimension('C')->setWidth(6.86);
        $objWorksheet->getColumnDimension('D')->setWidth(6.86);
        $objWorksheet->getColumnDimension('E')->setWidth(6.86);
        $objWorksheet->getColumnDimension('F')->setWidth(6.86);
        $objWorksheet->getColumnDimension('G')->setWidth(7.86);
        $objWorksheet->getColumnDimension('H')->setWidth(6.86);
        $objWorksheet->getColumnDimension('I')->setWidth(6.86);
        $objWorksheet->getColumnDimension('J')->setWidth(6.86);
        $objWorksheet->getColumnDimension('K')->setWidth(16);
        $objWorksheet->getStyle('A12:k12')->getFont()->setBold(true);

                // Print summary                        
        $objWorksheet->mergeCells('A8:J8')
            ->setCellValue('A8', __('Summary'))
            
            ->mergeCells('A9:J9')
            ->setCellValue('A9', __('Total amount paid by cash'))
            ->setCellValue('K9', $summaryArray['cashTransactions'])
            
            ->mergeCells('A10:J10')
            ->setCellValue('A10', __('Total amount paid by credit card'))
            ->setCellValue('K10', $summaryArray['ccTransactions'])
            
            ->mergeCells('A11:J11')
            ->setCellValue('A11', __("Topmenu's Commissions (Taxes included)"))
            ->setCellValue('K11', $summaryArray['commissionTotal'])
            
            ->mergeCells('A12:J12')
            ->setCellValue('A12', __('Credit Card fee with taxes'))
            ->setCellValue('K12', $summaryArray['ccFeeWithTaxe'])
            
            ->mergeCells('A13:J13');

        $amountToDepositMessage = ($summaryArray['oweToRestaurant'] > 0) ? __('Amount you owe to Topmenu') : __('Amount Topmenu owes you');
        $objWorksheet->setCellValue('A13', $amountToDepositMessage)
            ->setCellValue('K13', $summaryArray['oweToRestaurant']);



        // Order history header
        if ($showDetails) {

            $objWorksheet->getStyle('A15:K15')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD00');
            $objWorksheet->getStyle('A16:K16')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD00');
            $objWorksheet->mergeCells('A15:K15')
                ->setCellValue('A15', __('Order Details'))
                ->setCellValue('A16', __('#'))
                ->setCellValue('B16', __('Date'))
                ->setCellValue('C16', __('GST'))
                ->setCellValue('D16', __('PST'))
                ->setCellValue('E16', __('Food.'))
                ->setCellValue('F16', __('Deli.'))
                ->setCellValue('G16', __('Total'))
                ->setCellValue('H16', __('Tip.'))
                ->setCellValue('I16', __('CC Fee'))
                ->setCellValue('J16', __('TM'))
                ->setCellValue('K16', __('du'));
        }

        return $summaryArray;
    }

    /**
     * Refunds an order by adding a refund order in the database and set the orignal order to refunded.<br/>
     * A refund order is essentially a copy of the order to be refunded with a negative amount representing the amount of money refunded (usualy the entire amount).<br/>
     * The original order as it's overall status field set to 'refund' so it's not included in reports. The refund order id is prepended to the special instructions field or the order
     * @param int $originalId Order id of the original order to be be refunded
     * @param string $adminUserName Username of the user (admin) that made the refund
     * @param float $amount Amount refunded <b>Any amount (positive or negative) will be converted to a negative amount in the method</b>
     * @param string $message Comments made by user about the refund
     * @param string $refundTransactionId transaction id given by the payment gateway for the refund transaction
     * 
     * @return boolean True if refund order is inserted and orignal order is updated without validation errors
     * @throws Exception if save functions dont validate then the validation errors are returned as json string
     * @throws ValidationException if an order cant be refunded this exception is thrown (ex.: Order already refunded)
     */
    public function addRefundOrder($originalId, $adminUserName, $amount, $message, $refundTransactionId = '') {

        $amount                 = ($amount > 0) ? $amount * -1 : $amount;   // refund are always negative amounts
        $refundString           = 'reimbursement';
        $hasBeenRefundedStribng = 'refund';
        $now                    = time();

        // Get original order to refund
        $originalOrder = $this->findById($originalId);
        $newOrder =$originalOrder;
        unset($newOrder['Order']['id']);

        if ($originalOrder['Order']['overall_status'] === 'refund') {
            throw new ValidationException(__('Order Already refunded'));
        } elseif ($originalOrder['Order']['overall_status'] !== 'complete') {
            throw new ValidationException(__("Order Overall Status (%s) is invalid", $originalOrder['Order']['overall_status']));
        }

        $originalMessage = $originalOrder['Order']['special_instruction'];

        // Prepare the refund explanation text to be set in special instructions
        $finalMessage = "REMBOURSEMENT
Commande Original: $originalId
Transaction original: {$originalOrder['Order']['transaction_number']}
Transaction remboursement: $refundTransactionId
Admin: $adminUserName
----------------------    
$message";
    

        // Insert refund order in orders table
        $this->create();        
        $this->set($newOrder['Order']);
        $this->set('total', $amount);
        $this->set('transaction_number', $refundTransactionId);
        $this->set('special_instruction', $finalMessage);
        $this->set('method_of_payment', $refundString);
        $this->set('gateway_status', $refundString);
        $this->set('device_status', $refundString);
        $this->set('overall_status', $refundString);
        $this->set('response', $refundString);
        $this->set('created', date('Y-m-d H:i:s', $now));
        $this->set('modified', date('Y-m-d H:i:s', $now));
        $this->save();
        if (!$this->validates()) {
            var_dump($newOrder['Order']);
            throw new Exception("Insert ". json_encode($this->validationErrors));
        }
        $refundOrderId = $this->getLastInsertID();

        // update the original order
        $this->set($originalOrder['Order']);
        $this->set('special_instructions', "No. Remboursement: $refundOrderId\nMessage Original:\n--------\n" . $originalMessage);
        $this->set('overall_status', $hasBeenRefundedStribng);
        $this->save();
        if (!$this->validates()) {
            throw new Exception("Update: " . json_encode($this->validationErrors));
        }

        return true;
    }
    
   
    /**
     * Disable credit card payment when there is no client support working
     * @param int $now Timestamp (defaults to time());
     * @return boolean true if client is available at the moment
     * @todo if this is not a temporary solutions we have to allow admins to change the client support schedule.
     */
    public function isClientSupportWorkingNow($now = null) {
        $timestamp   = ($now === null) ? time() : $now;
        $currentHour = date('G', $timestamp);
        switch (date('N', $timestamp)) {

            // Weekdays
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:

                // if not between opening hours (10am to 10pm)
                if (!($currentHour >= 10 && $currentHour <= 21)) {                    
                    return true;
                } 
                break;
        }
        return true;
    }

}
