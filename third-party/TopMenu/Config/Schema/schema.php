<?php

class AppSchema extends CakeSchema {

    public function before($event = array()) {
        return true;
    }

    public function after($event = array()) {
        
    }

    public $accepted_credit_cards = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'         => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'         => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $acos = array(
        'id'              => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
        'parent_id'       => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'model'           => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'foreign_key'     => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'alias'           => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'lft'             => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'rght'            => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $aros = array(
        'id'              => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
        'parent_id'       => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'model'           => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'foreign_key'     => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'alias'           => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'lft'             => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'rght'            => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $aros_acos = array(
        'id'              => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
        'aro_id'          => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
        'aco_id'          => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
        '_create'         => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        '_read'           => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        '_update'         => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        '_delete'         => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'     => array('column' => 'id', 'unique' => 1),
            'ARO_ACO_KEY' => array('column' => array('aro_id', 'aco_id'), 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO remove the table and place's it's used
    public $countries = array(
        'id'              => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'country'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 44, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'paypal'          => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $coupons = array(
        'id'                      => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'specific_user'           => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'coupon available for only one user'),
        'user_id'                 => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'specific_location'       => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'coupon available for only one restaurant'),
        'location_id'             => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'offered_by'              => array('type' => 'string', 'null' => true, 'default' => 'topmenu', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'comment' => 'topmenu, restaurant, x'),
        'code'                    => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'amount_type'             => array('type' => 'string', 'null' => true, 'default' => 'percent', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'comment' => 'percent or cash'),
        'amount'                  => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null),
        'coupon_type'             => array('type' => 'string', 'null' => false, 'default' => 'general', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'is_open'                 => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'is_enabled'              => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'max_usage'               => array('type' => 'integer', 'null' => true, 'length' => 10),
        'max_usage_by_restaurant' => array('type' => 'integer', 'null' => true, 'length' => 10),
        'max_usage_by_user'       => array('type' => 'integer', 'null' => true, 'length' => 10),
        'is_in_effect'            => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'name_fr'                 => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'                 => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_fr'          => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_en'          => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'comment'                 => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'start_date'              => array('type' => 'datetime', 'null' => false, 'default' => null),
        'end_date'                => array('type' => 'datetime', 'null' => false, 'default' => null),
        'admin_id'                => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'                 => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes'                 => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'code'    => array('column' => 'code', 'unique' => 1)
        ),
        'tableParameters'         => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $used_coupons = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'user_id'         => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'coupon_id'       => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'order_id'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'         => array('type' => 'date', 'null' => false, 'default' => null),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $cuisines = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_en'  => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_fr'  => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'url'             => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'         => array('type' => 'datetime', 'null' => true, 'default' => null),
        'modified'        => array('type' => 'datetime', 'null' => true, 'default' => null),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $cuisines_locations = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'cuisine_id'      => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'    => array('column' => 'id', 'unique' => 1),
            'cuisine_id' => array('column' => array('cuisine_id', 'location_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    public $delivery_addresses = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'user_id'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'phone'           => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'secondary_phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'street_number'   => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'door_code'       => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'cross_street'    => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'address'         => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'address2'        => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'city'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'province'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'country'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'postal_code'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'updated'         => array('type' => 'datetime', 'null' => false, 'default' => null),
        'last_used'       => array('type' => 'datetime', 'null' => true, 'default' => null),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'user_id' => array('column' => 'user_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    public $locations_addresses = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'             => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'phone'           => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'secondary_phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'street_number'   => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'door_code'       => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'cross_street'    => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'address'         => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'address2'        => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'city'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'province'        => array('type' => 'string', 'null' => false, 'default' => 'QC', 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'country'         => array('type' => 'string', 'null' => false, 'default' => 'Canada', 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'postal_code'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'updated'         => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'location_id' => array('column' => 'location_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $delivery_areas = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'postal_code'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'delivery_charge' => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => '0'),
        'delivery_min'    => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => '0'),
        'featured'        => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1),
        'indexes'         => array(
            'PRIMARY'     => array('column' => 'id', 'unique' => 1),
            'postal_code' => array('column' => 'postal_code', 'unique' => 0),
            'location_id' => array('column' => 'location_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $device_orders = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'order_id'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'order_string'    => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'         => array('type' => 'datetime', 'null' => false, 'default' => null),
        'status'          => array('type' => 'string', 'null' => false, 'default' => 'ready', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'  => array('column' => 'id', 'unique' => 1),
            'order_id' => array('column' => array('order_id', 'location_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $device_response_messages = array(
        'id'               => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'device_string_fr' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'human_string_fr'  => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'device_string_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'human_string_en'  => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'          => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters'  => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $devices = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description'     => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'username'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'password'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'salt'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 22, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'         => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
        'last_connection' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'timeout'         => array('type' => 'integer', 'null' => false, 'default' => '120', 'length' => 5),
        'indexes'         => array(
            'PRIMARY'     => array('column' => 'id', 'unique' => 1),
            'location_id' => array('column' => 'location_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $domains = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'domain_type'     => array('type' => 'string', 'null' => false, 'default' => 'domain', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'domain_name'     => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'main_website'    => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
        'theme_id'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'theme_values'    => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'status'          => array('type' => 'string', 'null' => false, 'default' => 'active', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO check if used
    public $features = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'         => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'         => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'url'             => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'url'     => array('column' => 'url', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $features_locations = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'feature_id'      => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'    => array('column' => 'id', 'unique' => 1),
            'feature_id' => array('column' => array('feature_id', 'location_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $forgotten_passwords = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'user_id'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'         => array('type' => 'datetime', 'null' => false, 'default' => null),
        'hash'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $gateway_response_messages = array(
        'id'               => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'original_message' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'message_en'       => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'message_fr'       => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'          => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters'  => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $groups = array(
        'id'              => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'name'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'         => array('type' => 'datetime', 'null' => true, 'default' => null),
        'modified'        => array('type' => 'datetime', 'null' => true, 'default' => null),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $i18n = array(
        'id'              => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
        'locale'          => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 6, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'model'           => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'foreign_key'     => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
        'field'           => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'content'         => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'locale'  => array('column' => 'locale', 'unique' => 0),
            'model'   => array('column' => 'model', 'unique' => 0),
            'row_id'  => array('column' => 'foreign_key', 'unique' => 0),
            'field'   => array('column' => 'field', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO check if used
    public $instant_payment_notifications = array(
        'id'                     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'verify_sign'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 127, 'collate' => 'utf8_general_ci', 'comment' => 'Encrypted string used to verify the authenticityof the tansaction', 'charset' => 'utf8'),
        'test_ipn'               => array('type' => 'integer', 'null' => true, 'default' => null),
        'first_name'             => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'comment' => 'Customer\'s first name', 'charset' => 'utf8'),
        'last_name'              => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'comment' => 'Customer\'s last name', 'charset' => 'utf8'),
        'payer_business_name'    => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 127, 'collate' => 'utf8_general_ci', 'comment' => 'Customer\'s company name, if customer represents a business', 'charset' => 'utf8'),
        'payer_email'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 127, 'collate' => 'utf8_general_ci', 'comment' => 'Customer\'s primary email address. Use this email to provide any credits', 'charset' => 'utf8'),
        'payer_id'               => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 13, 'collate' => 'utf8_general_ci', 'comment' => 'Unique customer ID.', 'charset' => 'utf8'),
        'payer_status'           => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'comment' => 'verified/unverified', 'charset' => 'utf8'),
        'residence_country'      => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'comment' => 'Two-Character ISO 3166 country code', 'charset' => 'utf8'),
        'business'               => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 127, 'collate' => 'utf8_general_ci', 'comment' => 'Email address or account ID of the payment recipient (that is, the merchant). Equivalent to the values of receiver_email (If payment is sent to primary account) and business set in the Website Payment HTML.', 'charset' => 'utf8'),
        'receiver_email'         => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 127, 'collate' => 'utf8_general_ci', 'comment' => 'Primary email address of the payment recipient (that is, the merchant). If the payment is sent to a non-primary email address on your PayPal account, the receiver_email is still your primary email.', 'charset' => 'utf8'),
        'receiver_id'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 13, 'collate' => 'utf8_general_ci', 'comment' => 'Unique account ID of the payment recipient (i.e., the merchant). This is the same as the recipients referral ID.', 'charset' => 'utf8'),
        'custom'                 => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Custom value as passed by you, the merchant. These are pass-through variables that are never presented to your customer.', 'charset' => 'utf8'),
        'invoice'                => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 127, 'collate' => 'utf8_general_ci', 'comment' => 'Pass through variable you can use to identify your invoice number for this purchase. If omitted, no variable is passed back.', 'charset' => 'utf8'),
        'rp_invoice_id'          => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'recurring_payment_id'   => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'initial_payment_txn_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'initial_payment_status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'initial_payment_amount' => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null, 'length' => '10,2'),
        'tax'                    => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null, 'length' => '10,2', 'comment' => 'Amount of tax charged on payment'),
        'auth_id'                => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 19, 'collate' => 'utf8_general_ci', 'comment' => 'Authorization identification number', 'charset' => 'utf8'),
        'auth_exp'               => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 28, 'collate' => 'utf8_general_ci', 'comment' => 'Authorization expiration date and time, in the following format: HH:MM:SS DD Mmm YY, YYYY PST', 'charset' => 'utf8'),
        'auth_amount'            => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Authorization amount'),
        'auth_status'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'comment' => 'Status of authorization', 'charset' => 'utf8'),
        'parent_txn_id'          => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 19, 'collate' => 'utf8_general_ci', 'comment' => 'In the case of a refund, reversal, or cancelled reversal, this variable contains the txn_id of the original transaction, while txn_id contains a new ID for the new transaction.', 'charset' => 'utf8'),
        'payment_date'           => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 28, 'collate' => 'utf8_general_ci', 'comment' => 'Time/date stamp generated by PayPal, in the following format: HH:MM:SS DD Mmm YY, YYYY PST', 'charset' => 'utf8'),
        'payment_status'         => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'comment' => 'Payment status of the payment', 'charset' => 'utf8'),
        'payment_type'           => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'comment' => 'echeck/instant', 'charset' => 'utf8'),
        'pending_reason'         => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'comment' => 'This variable is only set if payment_status=pending', 'charset' => 'utf8'),
        'reason_code'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'comment' => 'This variable is only set if payment_status=reversed', 'charset' => 'utf8'),
        'txn_id'                 => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 19, 'collate' => 'utf8_general_ci', 'comment' => 'A unique transaction ID generated by PayPal', 'charset' => 'utf8'),
        'txn_type'               => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => 'cart/express_checkout/send-money/virtual-terminal/web-accept', 'charset' => 'utf8'),
        'exchange_rate'          => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null, 'length' => '10,2', 'comment' => 'Exchange rate used if a currency conversion occured'),
        'mc_currency'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'comment' => 'Three character country code. For payment IPN notifications, this is the currency of the payment, for non-payment subscription IPN notifications, this is the currency of the subscription.', 'charset' => 'utf8'),
        'mc_fee'                 => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null, 'length' => '10,2', 'comment' => 'Transaction fee associated with the payment, mc_gross minus mc_fee equals the amount deposited into the receiver_email account. Equivalent to payment_fee for USD payments. If this amount is negative, it signifies a refund or reversal, and either ofthose p'),
        'mc_gross'               => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null, 'length' => '10,2', 'comment' => 'Full amount of the customer\'s payment'),
        'mc_handling'            => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null, 'length' => '10,2', 'comment' => 'Total handling charge associated with the transaction'),
        'payment_fee'            => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null, 'length' => '10,2', 'comment' => 'USD transaction fee associated with the payment'),
        'payment_gross'          => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null, 'length' => '10,2', 'comment' => 'Full USD amount of the customers payment transaction, before payment_fee is subtracted'),
        'created'                => array('type' => 'datetime', 'null' => true, 'default' => null),
        'modified'               => array('type' => 'datetime', 'null' => true, 'default' => null),
        'next_payment_date'      => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'raw'                    => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'                => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters'        => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO check if used
    public $internal_alerts = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'type'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'date'            => array('type' => 'datetime', 'null' => false, 'default' => null),
        'status'          => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'body'            => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'resolved_at'     => array('type' => 'datetime', 'null' => true, 'default' => null),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
       
    public $location_redirects = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'key' => 'primary'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'old_url'         => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'indexes'         => array(
        ),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
    public $locations             = array(
        'id'                    => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name'                  => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'               => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'               => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'owner_name'            => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'url'                   => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'sector_slug'           => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'logo'                  => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'pdf_menu'              => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_en'        => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_fr'        => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'rating'                => array('type' => 'float', 'null' => true, 'default' => '0'),
        'building_number'       => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'street'                => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'city'                  => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'postal_code'           => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'province'              => array('type' => 'string', 'null' => false, 'default' => 'QUEBEC', 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'country'               => array('type' => 'string', 'null' => false, 'default' => 'CA', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'longitude'             => array('type' => 'float', 'null' => true, 'default' => null),
        'latitude'              => array('type' => 'float', 'null' => true, 'default' => null),
        'phone'                 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'phone2'                => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'email'                 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'website'               => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'delivery'              => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1),
        'pickup'                => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1),
        'sector_id'             => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'delivery_min_order'    => array('type' => 'float', 'null' => false, 'default' => 0),
        'delivery_average_time' => array('type' => 'integer', 'null' => true, 'default' => 45, 'length' => 3),
        'online_ordering'       => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
        'status'                => array('type' => 'string', 'null' => false, 'default' => 'active', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'old_pdf_only'          => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1, 'comment' => 'Is this entry from the old website, one of the pdf only ones?'),
        'created'               => array('type' => 'datetime', 'null' => true, 'default' => null),
        'modified'              => array('type' => 'datetime', 'null' => true, 'default' => null),
        'test_mode'             => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
        'delivery_commission'   => array('type' => 'float', 'null' => true, 'default' => null),
        'pickup_commission'     => array('type' => 'float', 'null' => true, 'default' => null),
        'credit_card_fee'       => array('type' => 'decimal', 'length' => '6,2', 'null' => false, 'default' => 1),
        'contract_number'       => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        //        'timezone'                   => array('type' => 'string', 'null' => false, 'default' => 'America/Montreal', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'language'                   => array('type' => 'string', 'null' => false, 'default' => 'en', 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'rebate_text_fr'             => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'rebate_text_en'             => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),        
//        'conditions_fr'              => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'conditions_en'              => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'primary_sector'             => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'primary_cuisine'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),                
//        'use_email'                  => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
//        'primary_specialties_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'delivery_less_than_min_fee' => array('type' => 'float', 'null' => false, 'default' => null),
//        'delivery_more_than_min_fee' => array('type' => 'float', 'null' => false, 'default' => null),
//        'delivery_time_begins'       => array('type' => 'time', 'null' => true, 'default' => null),
//        'delivery_time_ends'         => array('type' => 'time', 'null' => true, 'default' => null),
//        'delivery_hours_fr'          => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'delivery_hours_en'          => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'delivery_message_fr'        => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'delivery_message_en'        => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),        
//        'weight'                     => array('type' => 'biginteger', 'null' => false, 'default' => null),
//        'featured'                   => array('type' => 'biginteger', 'null' => true, 'default' => '0', 'length' => 1),
//        'cuisine_featured'           => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1),
        'indexes'               => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters'       => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $locations_sectors = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'sector_id'       => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'is_primary'      => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'indexes'         => array(
            'PRIMARY'       => array('column' => 'id', 'unique' => 1),
            'location_id'   => array('column' => array('location_id', 'sector_id'), 'unique' => 0),
            'location_id_2' => array('column' => array('location_id', 'sector_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $locations_specialties = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'specialty_id'    => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'is_primary'      => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'indexes'         => array(
            'PRIMARY'     => array('column' => 'id', 'unique' => 1),
            'location_id' => array('column' => array('location_id', 'specialty_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO check if used
    public $locations_users = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'user_id'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'user_id' => array('column' => array('user_id', 'location_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO check if used
    public $logs = array(
        'id'              => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'uri'             => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'method'          => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 6, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'params'          => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'api_key'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'ip_address'      => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'time'            => array('type' => 'integer', 'null' => false, 'default' => null),
        'authorized'      => array('type' => 'boolean', 'null' => false, 'default' => null),
        'indexes'         => array(
            'PRIMARY'    => array('column' => 'id', 'unique' => 1),
            'uri'        => array('column' => 'uri', 'unique' => 0),
            'ip_address' => array('column' => 'ip_address', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $menu_categories = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'parent_id'       => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'lft'             => array('type' => 'integer', 'null' => false, 'default' => null),
        'rght'            => array('type' => 'integer', 'null' => false, 'default' => null),
        'menu_id'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'image'           => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'         => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'         => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_en'  => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_fr'  => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'start_time'      => array('type' => 'time', 'null' => true, 'default' => null),
        'end_time'        => array('type' => 'time', 'null' => true, 'default' => null),
        'status'          => array('type' => 'string', 'null' => false, 'default' => 'active', 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'menu_id' => array('column' => 'menu_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $menu_item_option_values = array(
        'id'                  => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'parent_id'           => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'lft'                 => array('type' => 'integer', 'null' => true, 'default' => null),
        'rght'                => array('type' => 'integer', 'null' => true, 'default' => null),
        'menu_item_option_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'             => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'             => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'price'               => array('type' => 'float', 'null' => true, 'default' => null),
        'status'              => array('type' => 'string', 'null' => false, 'default' => 'active', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'             => array(
            'PRIMARY'             => array('column' => 'id', 'unique' => 1),
            'menu_item_option_id' => array('column' => 'menu_item_option_id', 'unique' => 0)
        ),
        'tableParameters'     => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $menu_item_options = array(
        'id'                    => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'menu_id'               => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'menu_category_id'      => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'parent_id'             => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'lft'                   => array('type' => 'integer', 'null' => true, 'default' => null),
        'rght'                  => array('type' => 'integer', 'null' => true, 'default' => null),
        'description'           => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'               => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'               => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'price'                 => array('type' => 'float', 'null' => false, 'default' => null),
        'multiselect'           => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'required'              => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'number_of_free_values' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
        'half_and_half'         => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'status'                => array('type' => 'string', 'null' => false, 'default' => 'active', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'counts_as_free_value'  => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'indexes'               => array(
            'PRIMARY'        => array('column' => 'id', 'unique' => 1),
            'menu_id'        => array('column' => 'menu_id', 'unique' => 0),
            'menu_item_id'   => array('column' => 'menu_category_id', 'unique' => 0),
            'menu_id_2'      => array('column' => 'menu_id', 'unique' => 0),
            'menu_id_3'      => array('column' => 'menu_id', 'unique' => 0),
            'menu_item_id_2' => array('column' => 'menu_category_id', 'unique' => 0)
        ),
        'tableParameters'       => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $menu_item_options_menu_items = array(
        'id'                  => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'menu_item_option_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'menu_item_id'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'             => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters'     => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $menu_items = array(
        'id'                 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'parent_id'          => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'menu_id'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'menu_category_id'   => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'lft'                => array('type' => 'integer', 'null' => false, 'default' => null),
        'rght'               => array('type' => 'integer', 'null' => false, 'default' => null),
        'name_en'            => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'            => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_en'     => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_fr'     => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'no_price_text_en'   => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'no_price_text_fr'   => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'price'              => array('type' => 'float', 'null' => true, 'default' => null),
        'number_of_instance' => array('type' => 'float', 'null' => false, 'default' => '1'),
        'size_fr'            => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'size_en'            => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'size_weight'        => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 2),
        'image'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'icons'              => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'status'             => array('type' => 'string', 'null' => false, 'default' => 'active', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'            => array(
            'PRIMARY'            => array('column' => 'id', 'unique' => 1),
            'menu_id'            => array('column' => 'menu_id', 'unique' => 0),
            'menu_item_group_id' => array('column' => 'menu_category_id', 'unique' => 0)
        ),
        'tableParameters'    => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $menus = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'status'          => array('type' => 'string', 'null' => false, 'default' => 'active', 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'         => array('type' => 'date', 'null' => true, 'default' => '2014-02-13', 'comment' => 'this field was added to the db 4 months after the default date'),
        'modified'        => array('type' => 'date', 'null' => true, 'default' => '2014-02-13'),
        'indexes'         => array(
            'PRIMARY'     => array('column' => 'id', 'unique' => 1),
            'location_id' => array('column' => 'location_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $order_details = array(
        'id'                  => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'order_id'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'menu_item_id'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name'                => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'quantity'            => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
        'price'               => array('type' => 'float', 'null' => false, 'default' => null),
        'subtotal'            => array('type' => 'float', 'null' => false, 'default' => null),
        'options'             => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'special_instruction' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'             => array(
            'PRIMARY'  => array('column' => 'id', 'unique' => 1),
            'order_id' => array('column' => array('order_id', 'menu_item_id'), 'unique' => 0)
        ),
        'tableParameters'     => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $orders = array(
        'id'                     => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'location_id'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'user_id'                => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'delivery_charge'        => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
        'subtotal'               => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
        'hst'                    => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
        'pst'                    => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
        'gst'                    => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
//        'hst_percent'            => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
//        'pst_percent'            => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
//        'pst_name_fr'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'pst_name_en'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'gst_percent'            => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
        'tip'                    => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null),
        'total'                  => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
        'commission_percentage'  => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null),
        'special_instruction'    => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'redeemed_points'        => array('type' => 'integer', 'null' => false, 'default' => null),
//        'redeemed_points_value'  => array('type' => 'decimal','length' => '6,2', 'null' => false, 'default' => null),
//        'points_earned'          => array('type' => 'integer', 'null' => false, 'default' => null),
        'coupon_code'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'coupon_offered_by'      => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'coupon_discount'        => array('type' => 'decimal','length' => '6,2', 'null' => true, 'default' => null),
        'related_order'          => array('type' => 'integer', 'null' => true, 'default' => null),
        'paid_by'                => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'first_name'             => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'last_name'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'address'                => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'address2'               => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'city'                   => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'state'                  => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'postal_code'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'cross_street'           => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'door_code'              => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'phone'                  => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'email'                  => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'language'               => array('type' => 'string', 'null' => true, 'default' => 'en', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'type'                   => array('type' => 'string', 'null' => false, 'default' => 'delivery', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'requested_for'          => array('type' => 'datetime', 'null' => true, 'default' => null),
        'expected_delivery_time' => array('type' => 'datetime', 'null' => true, 'default' => null),
        'method_of_payment'      => array('type' => 'string', 'null' => false, 'default' => 'unprocessed', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'gateway_status'         => array('type' => 'string', 'null' => false, 'default' => 'unprocessed', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'device_status'          => array('type' => 'string', 'null' => false, 'default' => 'unprocessed', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'overall_status'         => array('type' => 'string', 'null' => false, 'default' => 'unprocessed', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'transaction_number'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'response'               => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'referrer'               => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
//        'date'                   => array('type' => 'datetime', 'null' => false, 'default' => null),
        'created'                => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified'               => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes'                => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters'        => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $pages = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'content'         => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'title'           => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    public $profiles = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'first_name'      => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'last_name'       => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'phone'           => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'language'        => array('type' => 'string', 'null' => false, 'default' => 'en', 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'image'           => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'timezone'        => array('type' => 'string', 'null' => true, 'default' => 'America/Montreal', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'date_of_birth'   => array('type' => 'date', 'null' => true, 'default' => null),
        'gender'          => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $provinces = array(
        'id'              => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'country'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'number'          => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'code'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'         => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 41, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'         => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 41, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'       => array('column' => 'id', 'unique' => 1),
            'country_index' => array('column' => 'country', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $ratings = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'user_id'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'order_id'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'review'          => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'rating'          => array('type' => 'float', 'null' => false, 'default' => null),
        'created'         => array('type' => 'datetime', 'null' => false, 'default' => null),
        'status'          => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'     => array('column' => 'id', 'unique' => 1),
            'location_id' => array('column' => array('location_id', 'user_id'), 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO check if used
    public $restaurants = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'logo'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'url'             => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'         => array('type' => 'datetime', 'null' => false, 'default' => null),
        'modified'        => array('type' => 'datetime', 'null' => false, 'default' => null),
        'indexes'         => array(
            'PRIMARY'         => array('column' => 'id', 'unique' => 1),
            'ID_restaurant'   => array('column' => 'id', 'unique' => 0),
            'ID_restaurant_2' => array('column' => 'id', 'unique' => 0),
            'url'             => array('column' => 'url', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $restaurants_specialties = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'restaurant_id'   => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'specialty_id'    => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'       => array('column' => 'id', 'unique' => 1),
            'restaurant_id' => array('column' => 'restaurant_id', 'unique' => 0),
            'specialty_id'  => array('column' => 'specialty_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO check if used
    public $restaurants_users = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'user_id'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'restaurant_id'   => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'       => array('column' => 'id', 'unique' => 1),
            'user_id'       => array('column' => 'user_id', 'unique' => 0),
            'restaurant_id' => array('column' => 'restaurant_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO check if used
    public $review_codes = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'order_id'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'code'            => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'  => array('column' => 'id', 'unique' => 1),
            'order_id' => array('column' => 'order_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
    );
    public $schedules = array(
        'id'                  => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'day'                 => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'key' => 'index'),
        'opening_hour'        => array('type' => 'time', 'null' => false, 'default' => null),
        'closing_hour'        => array('type' => 'time', 'null' => false, 'default' => null),
        'delivery_start1'     => array('type' => 'time', 'null' => true, 'default' => null),
        'delivery_end1'       => array('type' => 'time', 'null' => true, 'default' => null),
        'delivery_start2'     => array('type' => 'time', 'null' => true, 'default' => null),
        'delivery_end2'       => array('type' => 'time', 'null' => true, 'default' => null),
        'split_delivery_time' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'indexes'             => array(
            'PRIMARY'     => array('column' => 'id', 'unique' => 1),
            'location_id' => array('column' => 'location_id', 'unique' => 0),
            'day'         => array('column' => 'day', 'unique' => 0)
        ),
        'tableParameters'     => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $sectors = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'image'           => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'code'            => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'url'             => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'is_featured'     => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'created'         => array('type' => 'datetime', 'null' => true, 'default' => null),
        'modified'        => array('type' => 'datetime', 'null' => true, 'default' => null),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'url'     => array('column' => 'url', 'unique' => 0),
            'code'    => array('column' => 'code', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $slideshow_images = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'image_en'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'image_fr'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'         => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'         => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_en'  => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description_fr'  => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'url_en'          => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'url_fr'          => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $specialties = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_en'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'image'           => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'is_featured'     => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'url'             => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'url'     => array('column' => 'url', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $street_addresses = array(
        'id'                 => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'postal_code'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'city'               => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'latitude'           => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'longitude'          => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'area_name'          => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'street_name'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 75, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'street_type_code'   => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'street_dir_code'    => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'street_seq_code'    => array('type' => 'integer', 'null' => false, 'default' => null),
        'street_from_no'     => array('type' => 'integer', 'null' => false, 'default' => null),
        'street_from_suffix' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'street_to_no'       => array('type' => 'integer', 'null' => false, 'default' => null),
        'street_to_suffix'   => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'store'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'delchg'             => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
        'nosrch'             => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
        'indexes'            => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters'    => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    //TODO check if used
    public $taxes = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'country'         => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'province'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'percentage'      => array('type' => 'float', 'null' => false, 'default' => null),
        'name_en'         => array('type' => 'string', 'null' => false, 'default' => 'PST', 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name_fr'         => array('type' => 'string', 'null' => false, 'default' => 'PST', 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'is_compound'     => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $themes = array(
        'id'               => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name'             => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'folder_name'      => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'default_settings' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'          => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters'  => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $tip_options = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'amount'          => array('type' => 'float', 'null' => false, 'default' => null),
        'location_id'     => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $transaction_logs = array(
		'id'				 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id'			 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'order_id'			 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'location_id'		 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'number'			 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'message'			 => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'code'				 => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status'			 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'amount'			 => array('type' => 'decimal', 'length' => '6,2', 'null' => true, 'default' => null),
		'xml_request'		 => array('type' => 'text', 'null' => true),
		'xml_response'		 => array('type' => 'text', 'null' => true),
		'created'			 => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes'			 => array(
			'PRIMARY'		 => array('column' => 'id', 'unique' => 1),
			'order_id'		 => array('column' => 'order_id', 'unique' => 0),
			'user_id'		 => array('column' => 'user_id', 'unique' => 0),
			'location_id'	 => array('column' => 'location_id', 'unique' => 0)
		),
		'tableParameters'	 => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	public $uploaded_files = array(
        'id'                 => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'type'               => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'field'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'foreign_key'        => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'created'            => array('type' => 'datetime', 'null' => false, 'default' => null),
        'original_extension' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'            => array(
            'PRIMARY'     => array('column' => 'id', 'unique' => 1),
            'foreign_key' => array('column' => 'foreign_key', 'unique' => 0),
            'field'       => array('column' => 'field', 'unique' => 0)
        ),
        'tableParameters'    => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    public $users = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'email'           => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'password'        => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'salt'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 22, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'group_id'        => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
        'created'         => array('type' => 'datetime', 'null' => true, 'default' => null),
        'modified'        => array('type' => 'datetime', 'null' => true, 'default' => null),
        'is_active'       => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'last_login'      => array('type' => 'datetime', 'null' => true, 'default' => null),
        'last_ip'         => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'old_salt'        => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 22, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'old_hash'        => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'force_reset'     => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'fraudulent'      => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'indexes'         => array(
            'PRIMARY'        => array('column' => 'id', 'unique' => 1),
            'username'       => array('column' => 'email', 'unique' => 1),
            'group_id_index' => array('column' => 'group_id', 'unique' => 0),
            'email'          => array('column' => 'email', 'unique' => 0),
            'group_id'       => array('column' => 'group_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    
    public $location_documents = array(
        'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'location_id'     => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'name'            => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'description'     => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'number'          => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'link'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'file'            => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes'         => array(
            'PRIMARY'     => array('column' => 'id', 'unique' => 1),
            'location_id' => array('column' => 'location_id', 'unique' => 0)
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );
    public $testing_users = array(
		'id'              => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'email'           => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
	);
}
