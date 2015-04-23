<?php

App::uses('Coupon', 'Model');
App::uses('CouponException', 'Lib/Error/Exception');

/**
 * Coupon Test Case
 * @author Pierre-Eric Chartrand <pec@topmenu.com>
 * @version march 3 2014
 */
class CouponTest extends CakeTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.coupon',
		'app.used_coupon'
	);

	private function _nextDay($modifier = 0) {
		date_default_timezone_set('America/New_York');
		return date('Y-m-d H:i:s', time() + 86400 + $modifier);
	}

	private function _previousDay($modifier = 0) {
		date_default_timezone_set('America/New_York');
		return date('Y-m-d H:i:s', time() - 86400 + $modifier);
	}

	private function _startOfToday() {
		date_default_timezone_set('America/New_York');
		$result = date('Y-m-d', time());
		$result .= ' 00:00:00';
		return $result;
	}

	private function _endOfToday() {
		date_default_timezone_set('America/New_York');
		$result = date('Y-m-d', time());
		$result .= ' 24:00:00';
		return $result;
	}

	/**
	 * Counts the total amount of records in the UsedCouponFixture with a given user_id 
	 * @param type $userId
	 * @return int	Amount of records with this UserID
	 */
	private function _countOccurenOfUserInUsedCouponFixture($userId) {
		$usedCouponFixture = new UsedCouponFixture();
		$usedCoupon = $usedCouponFixture->records;
		$i = 0;
		foreach ($usedCoupon as $uc) {
			if ($uc['user_id'] === $userId) {
				$i++;
			}
		}

		return $i;
	}

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Coupon = ClassRegistry::init('Coupon');
		$this->Coupon->read(null, '521b8859-1be8-42b3-a2cb-2aa3fe51d21f');
		$this->langSuffix = 'en';
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Coupon);

		parent::tearDown();
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////											isInEffect()
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Coupon date starting date in future
	 * @expectedException        CouponException
	 * @expectedExceptionMessage Coupon is not in effect
	 */
	public function testIsInEffectDateRageNotStartedCouponException() {

		$this->Coupon->data['Coupon']['start_date'] = $this->_nextDay();
		$this->Coupon->isInEffect();
	}

	/**
	 * Coupon end date in past
	 * @expectedException        CouponException
	 * @expectedExceptionMessage Coupon is expired
	 */
	public function testIsInEffectDateRangeEndedCouponException() {

		$this->Coupon->data['Coupon']['start_date'] = $this->_previousDay();  // start date in the past
		$this->Coupon->data['Coupon']['end_date'] = $this->_previousDay(10);   // end date in the past but after start date
		$this->Coupon->isInEffect();
	}

	/**
	 * Invalid date range - End date before start date
	 * @expectedException        Exception
	 * @expectedExceptionMessage Invalid date range given for coupon
	 */
	public function testIsInEffectInvalidDateRangeCouponExceptionInvalidDateRange() {

		$this->Coupon->data['Coupon']['start_date'] = $this->_previousDay();  // start date in the past
		$this->Coupon->data['Coupon']['end_date'] = $this->_previousDay(-100);  // end date before start date
		$this->Coupon->isInEffect();
	}

	/**
	 * Date range have the exact same start en end date
	 * @expectedException        Exception
	 * @expectedExceptionMessage Invalid date range given for coupon
	 */
	public function testIsInEffectSameEndAndStartDateCouponExceptionCouponIsNotInEffect() {

		$sameDate = $this->_previousDay();
		$this->Coupon->data['Coupon']['start_date'] = $sameDate;  // start date in the past
		$this->Coupon->data['Coupon']['end_date'] = $sameDate;  // end date before start date
		$this->Coupon->isInEffect();
	}

	/**
	 * Coupon is expired
	 * @expectedException        CouponException
	 * @expectedExceptionMessage Coupon is not in effect
	 */
	public function testIsInEffectCouponNotStartedCouponExceptionCouponIsNotInEffect() {

		$this->Coupon->data['Coupon']['start_date'] = $this->_nextDay();  // start date in future
		$this->Coupon->data['Coupon']['end_date'] = $this->_nextDay(100);  // end date before start date
		$this->Coupon->isInEffect();
	}

	/**
	 * Coupon is valid
	 */
	public function testIsInEffectTrue() {


		$this->Coupon->data['Coupon']['start_date'] = $this->_previousDay();
		$this->Coupon->data['Coupon']['end_date'] = $this->_nextDay();   // end date in the future
		$result = $this->Coupon->isInEffect();
		$this->assertEqual($result, TRUE);
	}

	/**
	 * Coupon is valid start date is today at beginin of day (0h 0m 0s)
	 */
	public function testIsInEffectStartDateTodayTrue() {


		$this->Coupon->data['Coupon']['start_date'] = $this->_startOfToday();
		$this->Coupon->data['Coupon']['end_date'] = $this->_nextDay();   // end date in the future
		$result = $this->Coupon->isInEffect();
		$this->assertEqual($result, TRUE);
	}
	
	/**
	 * Check if the maximum usage for a coupon is reached (reach means => not > so if it's equal than no more coupon are allowed)
	 * @expectedException        CouponException
	 * @expectedExceptionMessage Coupon is no longer in effect.
	 */
	public function testMaxUsageReachedEqualExceptionCouponIsNoLongerInEffect(){
		$this->Coupon->read(null, '53359a64-bba0-42d7-b150-1d1fc0c6c6a4');
		$this->Coupon->isInEffect();
	}
	
	/**
	 * Check if the maximum usage for a coupon is reached (reach means => not > so if it's equal than no more coupon are allowed)
	 * @expectedException        CouponException
	 * @expectedExceptionMessage Coupon is no longer in effect.
	 */
	public function testMaxUsageReachedGreaterThanExceptionCouponIsNoLongerInEffect(){
		$this->Coupon->read(null, "53359a64-bba0-42d7-b150-1d1fc0c6c6a5");
		$this->Coupon->isInEffect();
	}

	/**
	 * Coupon is valid start date is today at beginin of day (0h 0m 0s)
	 */
	public function testIsInEffectEndDateToday() {


		$this->Coupon->data['Coupon']['start_date'] = $this->_startOfToday();
		$this->Coupon->data['Coupon']['end_date'] = $this->_nextDay();   // end date in the future
		$result = $this->Coupon->isInEffect();
		$this->assertEqual($result, TRUE);
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////										IsValidForUser()
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Any user can use coupon only once.
	 * @expectedException        CouponException
	 * @expectedExceptionMessage You have already used this coupon
	 */
	public function testIsValidForUserMoreUsageThanAllowedValidationErrorYouHaveAlready() {

		$user = '52810434-b8a0-4375-83ce-6a881ec880c8'; // user_0 as only one entry and it's with restaurant location_0. 
		$this->Coupon->data['Coupon']['max_usage_by_user'] = NULL;
		$this->Coupon->data['Coupon']['max_usage_by_user'] = 1;
		$this->Coupon->isValidForUser($user);
	}

	/**
	 * Max usage is 0 (nobody can use this coupon)
	 * @expectedException        CouponException
	 * @expectedExceptionMessage Coupon is not in effect
	 */
	public function testIsValidForUserIsZeroCouponExceptionCouponIsNotValid() {

		$user = 'user_99'; // user_99 never appears in the used coupon table
		$this->Coupon->data['Coupon']['max_usage_by_user'] = NULL;
		$this->Coupon->data['Coupon']['user_id'] = null;
		$this->Coupon->data['Coupon']['max_usage_by_user'] = 0;
		$this->Coupon->isValidForUser($user);
	}

	/**
	 * User given not the same as specified one
	 * @expectedException        CouponException
	 * @expectedExceptionMessage You may not use this coupon
	 */
	public function testIsValidForUserWrongUserValidationErrorInvalidCoupon() {
		$user = 'user_99'; // user_99 never appears in the used coupon table
		$this->Coupon->data['Coupon']['specific_user'] = 1;
		$this->Coupon->data['Coupon']['max_usage_by_user'] = 100;
		$this->Coupon->data['Coupon']['user_id'] = 'xxx';
		$this->Coupon->isValidForUser($user);
	}

	/**
	 * TRUES
	 */
	public function testIsValidForUserTrue() {

		// Infinite usage for any user
		$user = 'user_1';		   // user_1 used the coupon many times
		$this->Coupon->data['Coupon']['max_usage_by_user'] = NULL;   // No specific user
		$this->Coupon->data['Coupon']['user_id'] = null;   // No specific user
		$this->Coupon->data['Coupon']['max_usage_by_user'] = NULL; // Infinite usage
		$result = $this->Coupon->isValidForUser($user);
		$this->assertEqual($result, TRUE, "// Infinite usage for any user");

		// Infinite usage for any user (user not in recdords)
		$user = 'user_99';		   // user_99 never appears in the used coupon table
		$this->Coupon->data['Coupon']['max_usage_by_user'] = NULL;   // No specific user
		$this->Coupon->data['Coupon']['max_usage_by_user'] = NULL; // Infinite usage
		$result = $this->Coupon->isValidForUser($user);
		$this->assertEqual($result, TRUE, '// Infinite usage for any user (user not in recdords)');

		// infinte usage for specific user (user not in records)
		$user = 'user_99';		   // user_99 never appears in the used coupon table
		$this->Coupon->data['Coupon']['specific_user'] = 1;   // Specific User
		$this->Coupon->data['Coupon']['user_id'] = $user;   // allowed for the current user
		$this->Coupon->data['Coupon']['max_usage_by_user'] = NULL; // Infinite usage
		$result = $this->Coupon->isValidForUser($user);
		$this->assertEqual($result, TRUE, '// infinte usage for specific user (user not in records)');

		// max usage for specific user that never used this coupon
		$user = 'user_99';		   // user_99 never appears in the used coupon table
		$this->Coupon->data['Coupon']['specific_user'] = 1;   // Specific User
		$this->Coupon->data['Coupon']['user_id'] = $user;   // allowed for the current user
		$this->Coupon->data['Coupon']['max_usage_by_user'] = 1;  // Allowed to use coupon once
		$result = $this->Coupon->isValidForUser($user);
		$this->assertEqual($result, TRUE, '// max usage for specific user that never used this coupon');

		// specific user wich as used the coupon one time less than the max allowed. Example: usage_max = 5, user_usage_of_coupon = 4
		$user = 'user_1';		   // user_1 used the coupon many times ()		
		$usageAmount = $this->_countOccurenOfUserInUsedCouponFixture($user);
		$this->Coupon->data['Coupon']['specific_user'] = 1;   // Specific User
		$this->Coupon->data['Coupon']['user_id'] = $user;   // allowed for the current user
		$this->Coupon->data['Coupon']['max_usage_by_user'] = $usageAmount + 1; // Allowed more times than user as
		$result = $this->Coupon->isValidForUser($user);
		$this->assertEqual($result, TRUE, '// specific user wich as used the coupon one time less than the max allowed. Example: usage_max = 5, user_usage_of_coupon = 4');

		// specific user wich as used the coupon many time less than the max allowed. Example: usage_max = 10, user_usage_of_coupon = 4
		$user = 'user_1';		   // user_1 used the coupon many times ()		
		$usageAmount = $this->_countOccurenOfUserInUsedCouponFixture($user);
		$this->Coupon->data['Coupon']['specific_user'] = 1;   // Specific User
		$this->Coupon->data['Coupon']['user_id'] = $user;   // allowed for the current user
		$this->Coupon->data['Coupon']['max_usage_by_user'] = $usageAmount + 10; // Allowed more times than user as
		$result = $this->Coupon->isValidForUser($user);
		$this->assertEqual($result, TRUE, '// specific user wich as used the coupon many time less than the max allowed. Example: usage_max = 10, user_usage_of_coupon = 4');
		
		// max usage by user		
		$user = 'user_1';		   // user_1 never used the coupon
		$this->Coupon->read(null, '53343e51-2674-437a-9a6e-6ca7c0c6c6a4');
		debug($this->Coupon->data);
		$result = $this->Coupon->isValid($user, 'location_id_not_important');
		$this->assertEqual($result, TRUE, '// specific user wich as used the coupon many time less than the max allowed. Example: usage_max = 10, user_usage_of_coupon = 4');
	}

	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//		IsValid()
	//		No need to test it because it only calls the other functions
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Not in effect
	 */
	public function testIsValid(){
		
	}

}
