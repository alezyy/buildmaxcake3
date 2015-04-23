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
App::import('View', 'View');

class InternalAlert extends AppModel
{

/**
 * Behaviors
 */
	public $actsAs = array('Email');

/**
 * Array of alerts to send out (so we can implement rate limiting)
 */
	protected $notificationQueue = array();

/**
 * Construct
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}
/**
 * Creates an alert
 */
	public function createAlert($location_id, $type, $body = array()) {
		$body = json_encode($body);
		if (!$this->getAlert($location_id, $type, true)) {
			$data = array(
				'InternalAlert' => array(
					'location_id' => $location_id,
					'type'        => $type,
					'body'        => $body,
					'status'      => 'open',
					'date'        => date('Y-m-d H:i:s')
				)
			);

			$this->create();
			if ($this->save($data)) {
				$this->queueNotification($data);
			}
		}
	}

/**
 * Checks to see if an alert exists (and is open)
 * if open get the information
 */
	public function getAlert($location_id, $type = null, $count = false) {
		if (!$count) {
			$query_type = 'first';
		} else {
			$query_type = 'count';
		}

		$conditions = array(
			'location_id' => $location_id,
			'status'      => 'open'
		);

		if ($type !== null) {
			$conditions['type'] = $type;
		}

		$result = $this->find($query_type, array(
			'conditions' => $conditions
		));

		if ($result) {
			return $result;
		}
		return false;
	}


/**
 * Resolves an alert
 */
	public function resolveAlert($location_id, $type) {
		if ($alert = $this->getAlert($location_id, $type)) {
			$data = $alert;

			$data['InternalAlert']['status']      = 'resolved';
			$data['InternalAlert']['resolved_at'] = date('Y-m-d H:i:s');

			if ($this->save($data)) {
				$this->queueNotification($data);
			}
		}
	}


/**
 * Queues a notification with information about the alert
 */
	public function queueNotification($data) {
		$Location = ClassRegistry::init('Location');
		$View     = new View();

		switch ($data['InternalAlert']['status']) {
			case 'open':
				$view = 'alert_created';
			break;

			case 'resolved':
				$view = 'alert_resolved';
			break;
		}

		$location_url = $Location->getLocationUrl($data['InternalAlert']['location_id']);
		$location_url = array_shift($location_url);
		$location_url = array_shift($location_url);

		$data['InternalAlert']['location_url'] = $location_url;


		$View->set('data', $data);

		$this->notificationQueue[] = $View->render('Alerts/' . $view, 'ajax');

	}
/**
 * Flushes the notification queue, sending out all notificaitons
 */
	public function flushNotificationQueue() {
		// Logfile entries
		foreach ($this->notificationQueue as $key => $message) {
			// Log the message
			$this->log($message);
		}
		$sendNotifications = Configure::read('Alert.send');
		if (!$sendNotifications) {
			return true;
		}

		// Email notifications
		foreach ($this->notificationQueue as $key => $message) {

			$this->sendAlertEmail($message);


			// Limit the amount of messages we're going to send out in a period of time...
			// 1/4 of a second is enough here.
			usleep(250000);
		}

		// Pushover Notifications
		foreach ($this->notificationQueue as $key => $message) {
			// Send out notifications through Pushover

			$this->sendPushoverAlert($message);

			// Limit the amount of messages we're going to send out in a period of time...
			// We don't want to get ourselves banned from Pushover...
			// 1/4 of a second should suffice
			usleep(250000);
		}


	}
/**
 * Sends an email to all destinations configured in core.php
 */
	public function sendAlertEmail($data){

		$destinations = Configure::read('Alert.Email');

		$subject = __('Top Menu - Alert System');

		foreach ($destinations as $destination) {
			$this->sendEmail(
				$destination,
				$subject,
				$data,
				array(
					'template' => 'alert'
				)
			);
			usleep(250000);
		}
	}

/**
 * Sends notifications using Pushover
 */
	public function sendPushoverAlert($data){

		$Pushover = ClassRegistry::init('Pushover');

		$destinations = Configure::read('Alert.Pushover');

		$subject = __('Top Menu - Alert System');

		foreach ($destinations as $destination) {
			$Pushover->sendMessage(
				$destination,
				$subject,
				$data
			);
			usleep(500000);
		}
	}

}