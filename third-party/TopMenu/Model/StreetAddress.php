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
App::uses('HttpSocket', 'Network/Http');

class StreetAddress extends AppModel {


	public $actsAs = array(
		'Elasticsearch.Searchable',
		'Email'
	);
/**
 * Virtual Fields
 */
	public $virtualFields = array(
		'postal_code1' => 'SUBSTR(postal_code, 1, 3)',
		'postal_code2' => 'SUBSTR(postal_code, 5, 3)',
		'location'     => 'CONCAT(StreetAddress.latitude, ",", StreetAddress.longitude)'
	);


/**
 * Gets a list of street names
 * @param  string $postal_code
 * @param  string $street_name
 * @return array              list of streets
 */
	public function getStreets($postal_code, $street_name = '') {
		// Attach the Elastic.Indexable behavior on the fly (we dont use it by default.)
		// Set the database config for the model to our elasticsearch config
		// and we'll be using 'street_address' as our type
		$this->Behaviors->attach('Elastic.Indexable');
		$this->useDbConfig = 'index';
		$this->useTable = 'street_address';

		$results = $this->find(
			'all',
			array(
				'fields' => array(
					'StreetAddress.street_name'
				),
				'conditions' => array(
					'StreetAddress.postal_code1' => substr($postal_code, 0, 3),
					'StreetAddress.postal_code2' => substr($postal_code, 4, 7)
				),
				'limit' => 2000
			)
		);


		return $results;


		// $results = $this->find('all', array(
		// 	'fields' => array(
		// 		'street_name'
		// 	),
		// 	'conditions' => array(
		// 		'street_name LIKE' => $street_name . '%',
		// 		'postal_code' => $postal_code
		// 	)
		// ));
		// return $results;
	}

	public function getCoordinates($postal_code1, $postal_code2 = null, $google = true) {
		if (!$google) {
			$conditions = array(
                    'StreetAddress.postal_code1' => $postal_code1
            );

            if ($postal_code2 !== null) {
                    $conditions['StreetAddress.postal_code2'] = $postal_code2;
            }

            $results = $this->find(
                    'first',
                    array(
                            'fields' => array(
                                    'StreetAddress.latitude',
                                    'StreetAddress.longitude'
                            ),
                            'conditions' => $conditions
                    )
            );


            if (empty($results)) {
                    $results = array(
                            'StreetAddress' => array(
                                    'latitude' => 0,
                                    'longitude' => 0
                            )
                    );
            }


            return $results;
		}


		$Http        = new HttpSocket();
		$endPoint    = 'https://maps.googleapis.com/maps/api/geocode/json';
		$postal_code = $postal_code1;


		$return = array(
			'StreetAddress' => array(
				'latitude' => 0,
				'longitude' => 0
			)
		);

		if ($postal_code2 !== null && $postal_code2 !== false) {
			$postal_code .= ' ' . $postal_code2;
		}

		$payload = array(
			'address' => $postal_code,
			'sensor'  => 'false'
		);

		$results = $Http->get($endPoint, $payload);

		//return $results;

		if ($results->isOk()) {
			$results = json_decode($results->body, true);


			if ($results['status'] == 'OK') {
				$results = $results['results'][0];
				$return['StreetAddress']['latitude']  = $results['geometry']['location']['lat'];
				$return['StreetAddress']['longitude'] = $results['geometry']['location']['lng'];
			}

		}

		return $return;
	}

/**
 * Grabs the city for a given postal code
 * @param  string $postal_code
 * @return array
 */
	public function getCitiesByPostalCode($postal_code) {
		$results = $this->find('first', array(
			'fields' => array(
				'DISTINCT city'
			),
			'conditions' => array(
				'postal_code' => $postal_code
			)
		));
		return $results;
	}

/**
 * Validates a postal code based on the Canada Post database
 * @param  string $postal_code
 * @return boolean              true on success, false on failure
 */
	public function validatePostalCode($postal_code) {
		// $this->Behaviors->attach('Elastic.Indexable');
		// $this->useDbConfig = 'index';
		// $this->useTable = 'street_address';
		// $results = $this->find(
		// 	'all',
		// 	array(
		// 		'fields' => array(
		// 			'StreetAddress.postal_code2'
		// 		),
		// 		'conditions' => array(
		// 			 =>
					
		// 		),
		// 		'limit' => 200
		// 	)
		// );
		$results = $this->find('count', array(
			'conditions' => array(
				'postal_code' => $postal_code
			)
		));
		if ($results) {
			return true;
		}
		return false;
	}
/**
 * Gets a list of postal codes (2nd part)
 * @param  string $postal_code first 3 chars, any longer will be truncated
 * @return array
 */
	public function getPostalCodesPart2($postal_code) {
		if (strlen($postal_code) > 3 ) {
			$postal_code = substr($postal_code, 0, 3);
		}
		
		$this->Behaviors->attach('Elastic.Indexable');
		$this->useDbConfig = 'index';
		$this->useTable = 'street_address';



		$results = $this->find(
			'all',
			array(
				'fields' => array(
					'StreetAddress.postal_code2'
				),
				'conditions' => array(
					'query_string' => array(
						'fields' => array('StreetAddress.postal_code1'),
						'query' => $postal_code
					)
				),
				'limit' => 2000
			)
		);

		return $results;

		// $results = $this->find('all', array(
		// 	'fields' => array(
		// 		'postal_code2'
		// 	),
		// 	'conditions' => array(
		// 		'postal_code LIKE' => $postal_code . '%'
		// 	)
		// ));
		// return $results;
	}

/**
 * Gets a postal code from a given lat/long
 * @param  float  $latitude  Latitude
 * @param  float  $longitude Longitude
 * @return string|bool       Postal code on success, FALSE on failure
 */
	public function getPostalCodeFromCoords($latitude, $longitude) {
		$this->Behaviors->attach('Elastic.Indexable');
		$this->useDbConfig = 'index';
		$this->useTable = 'street_address';

		if ($latitude === FALSE || $longitude === FALSE) {
			return false;
		}

		$result = $this->find('first', array(
			'conditions' => array(
				'StreetAddress.location' => array(
					'lat'           => $latitude,
					'lon'           => $longitude,
					'distance'      => '2km',
					'distance_type' => 'arc'
				)
			),
			'fields'    => array(
				'StreetAddress.postal_code1'
			),
			'latitude'  => $latitude,
			'longitude' => $longitude,
			'order'     => array(
				'StreetAddress.location' => 'ASC'
			)
		));

		if ($result) {
			return array(
				'postal_code' => $result['StreetAddress']['postal_code1']
			);
		}
		return false;

	}
}