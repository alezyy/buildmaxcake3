<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');
App::uses('Order', 'Model');
App::uses('User', 'Model');
App::uses('Location', 'Model');
App::uses('CakeEmail', 'Network/Email');

/**
 * CakePHP Fraud
 * @author pechartrand
 */
class Fraud extends AppModel {
    
    public $useTable = false;

    public $actsAs = array('Email', 'Diacritics');

    /**
     * Types of suspicous activity to include in the email sent out
     * @var array  
     */
    private $messages;

    /**
     * User info to include in the email
     * @var array 
     */
    private $userInfo;

    /**
     * Location info to include in the email if a location id is provided
     * @var array 
     */
    private $locationInfo;

    /**
     * A few orders made recently by the user to be sent with the email
     * @var array 
     */
    private $orderHistory;

    /**
     * Makes a series of test to etablish if the user should be flag as potentially fraudulent. If the user considered 
     * suspicious an fraud warning email will be sent.
     * 
     * @param string $userId User's ID
     * @param string $locattionId Current Location's ID if applicable
     * @param bool $blockFurtherActions If set to true a generic error will be thrown to prevent user from continuing is action on the site
     * @return bool True is suspicous (plus an email is sent) false if user is not suspicious
     */
    public function suspiciousUser($userId, $locationId = NULL, $blockFurtherActions = FALSE) {

        // If debug mode is on don't do his check
        if (Configure::read('debug') > 1) {
            return FALSE;
        }

        $isSuspicous = FALSE;

        // User info
        $userModel      = new User();
        $this->userInfo = $userModel->find('first', array(
            'contain'    => array('Profile'),
            'conditions' => array('User.id' => $userId),
            'fields'     => array('User.id', 'Profile.first_name')));
        if (empty($this->userInfo)) {
            throw new Exception(__('Sorry, we can not execute your request. 1398354217'));
        }

        // Location info
        if ($locationId !== NULL) {
            $locationModel      = new Location();
            $this->locationInfo = $locationModel->findById($locationId, array('Location.id', 'Location.name', 'Location.phone'));
        }


        if ($this->_asMadeManyOrdersLately($userId)) {
            $isSuspicous = TRUE;
        }

        if ($isSuspicous) {
            $this->_sendEmail();
            if ($blockFurtherActions) {
                throw new Exception(__('Sorry, we can not execute your request. 1398353933'));
            }
        }
    }

    /**
     * Checks the user's order history for a given period and establish if is ordering behavior is suspicious or not. <br/>
     * If suspicious this will populate the $orderHistory property and add a element to the $message property
     * 
     * @param string $userId $userId User's ID
     * @param int $period Period of time to look back in the user's order history in hours. <i>Defaults to constant in configuration</i>
     * @param float $orderAverageTreshold If the average of the orders total in the given period is under this treshold than do not flag for fraud. <i>Defaults to constant in configuration</i>
     * @param int $orderAmountTreshold The amount or order at which with start to flag for warnings. <i>Defaults to constant in configuration</i>
     * @return boolean True if user is suspicious.
     */
    private function _asMadeManyOrdersLately($userId, $period = NULL, $orderAverageTreshold = NULL, $orderAmountTreshold = NULL) {

        // Default values
        $periodHours          = $period;
        $period               = ($period === NULL) ? Configure::read('fraud.period') : $period;
        $orderAverageTreshold = ($orderAverageTreshold === NULL) ? Configure::read('fraud.order_average_treshold') : $orderAverageTreshold;
        $orderAmountTreshold  = ($orderAmountTreshold === NULL) ? Configure::read('fraud.order_amount_treshold') : $orderAmountTreshold;

        // Prep the time string 
        $periodStart = date('Y-m-d h:i:s', time() - ($period * HOUR));

        // Retreive data	
        $orderModel = new Order();
        $orders     = $orderModel->find('all', array(
            'conditions' => array(
                'Order.user_id'    => $userId,
                'Order.created >=' => $periodStart)));

        $orderAmount = count($orders);

        // Order Average
        $orderAverage = 0;
        $i            = 0;
        foreach ($orders as $o) {
            $i++;
            $orderAverage += $o['Order']['total'];
        }
        $orderAverage = ($i > 0) ? $orderAverage / $i : 0;

        // Checks
        if ($orderAverage >= $orderAverageTreshold && $orderAmount >= $orderAmountTreshold) {
            $this->messages[]   = "$orderAmount orders made in the last $periodHours hours. Order Total average:  $orderAverage $";
            $this->orderHistory = $orders;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Configure and send out the email to 
     */
    private function _sendEmail() {

        $data = array(
            'OrderHistory' => $this->orderHistory,
            'Location'     => $this->locationInfo,
            'User'         => $this->userInfo,
            'Message'      => $this->messages
        );

        $subject = "Fraud";

        $response = $this->sendEmail(
            array(
            'name'    => '',
            'address' => Configure::read('fraud.emails')), $subject, $data, array('template' => 'fraud'));

        return $response;
    }

    /**
     * Check against a ongoing
     * @throws Exception
     * @todo store blacklist item in database and make forms for admins to insert them
     */
    public function blackLists($userEmail, $deliveryAddress, $phone) {
        // Anti Fraud by username	
        if (
            $userEmail === '' ||
            $userEmail === 'morroco160@gmail.com' ||
            $userEmail === 'ntm0047@gmail.com' ||
            $userEmail === 'ntm0051@gmail.com' ||
            $userEmail === 'karim4life8@hotmail.com' ||
            $userEmail === 'Jpelletier2010@outlook.com' ||
            $userEmail === 'itspossible915@gmail.com' ||
            $userEmail === 'itspossible2204@outlook.com' ||
            $userEmail === 'jamaldaugustave@hotmail.com' ||
            $userEmail === 'thomasj888@outlook.fr' ||
            $userEmail === 'ntm0033@gmail.com' ||
            $userEmail === 'shaita1@hotmail.com' ||
            $userEmail === 'hhhmob@outlook.fr' ||
            $userEmail === 'robinhayhay@gmail.com' ||
            $userEmail === 'stephshimath@gmail.com' ||
            $userEmail === 'iz3r@outlook.fr' ||
            $userEmail === 'mibhhh@outlook.fr' ||
            $userEmail === 'edithl@yopmail.com' ||
            $userEmail === 'lorenafigueredo@gmail.com' ||
            $userEmail === 'jamesmunduri@gmail.com' ||
            $userEmail === 'molotvmarco@live.fr' ||
            $userEmail === 'jamesshimath@gmail.com' ||
            $userEmail === 'jameshimath@gmail.com' ||
            $userEmail === 'Joelavoie7@gmail.com' ||
            $userEmail === 'kingnaldo5141@gmail.com' ||
            $userEmail === 'smsimon@mho.com' ||
            $userEmail === 'momo3134@gmail.com' ||
            $userEmail === 'maishamaishu78@yahoo.com' ||
            $userEmail === 'vinnhto@yahoo.ca' ||
            $userEmail === 'poundtrey1313@hotmail.com' ||
            $userEmail === 'matenike@hotmail.com' ||
            $userEmail === 'donna.a@yopmail.com' ||
            $userEmail === 'jamie.r@yopmail.com' ||
            $userEmail === 'donna.a@yopmail.com' ||
            $userEmail === 'krystal_son@yahoo.com' ||
            $userEmail === 'dan.c@yopmail.com' ||
            $userEmail === 'ryanasprey@gmail.com' ||
            $userEmail === 'john.l@yopmail.com'
        ) {
            $this->_blackListEmail($userEmail, $userEmail, $phone);
            throw new Exception;
        }

        // Anti fraud by addresses
        if (!empty($deliveryAddress)) {

                        
            //TODO consider appartements and street direction (west, est, ouest, w ...)
            
            /**
             * /^4119   // Match given Building number
             * .*       // Matches any "street, boul, blv, ave ..."
             * (?:st)e{0,1}|(?:saint)e{0,1}. // Matches any of those: "Saint, Sainte, Ste, ST" in a street name like "Sainte-Catherine" and the following character (usually a "-")
             * .*       // Matches anything after the street name
             * /i       // Case insentitive
             * 
             */
            $deliveryAddress = $this->remove_accents($deliveryAddress); // Remove diacritics from string
            if (
//                preg_match("/^7454.*pie-ix.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^5679.*monk.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^1988.*montcalm.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^3540.*messier.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^4420.*coloniale.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^2445.*sunset.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^3300.*troie.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^8202.*rameau.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^8071.*papineau.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^2471.*rachel.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^3844.*rachel.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^1318.*jean-talon.*$/i", $deliveryAddress) === 1 ||                
//                preg_match("/^10640.*london*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^600.*dufresne*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^2391.*jean.langlois*$/i", $deliveryAddress) === 1 ||              
//                preg_match("/^(?:4119\D).*(?:(?:st)e{0,1}|(?:saint)e{0,1}).denis*$/i", $deliveryAddress) === 1 ||                
//                preg_match("/^1890.*erables*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^4406.*hotel.de.ville*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^7.785.*amherst*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^556.*dufresne*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^2200.*beaudry*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^(?:2436\D)(?:(?:st)e{0,1}|(?:saint)e{0,1}.catherine)*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^(?:3380\D)(?:(?:st)e{0,1}|(?:saint)e{0,1}).joseph*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^11665.*l{0,1}.archeveque*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^911.*rosaire.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^1201.*rene-levesque.*$/i",$deliveryAddress) === 1 ||
//                preg_match("/^2217.*visitation.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^475.*president.kennedy.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^345.*gauchetiere.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^(?:103.8415\D)(?:(?:st)e{0,1}|(?:saint)e{0,1}).laurent.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^1050.*gauchetiere.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^1425.*montagne.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^3535.*papineau.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^7781.*marquette.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^7677.*marquette.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^395.*colline.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^5250.*jarry.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^2217.*visitation.*$/i", $deliveryAddress) === 1 ||
//                preg_match("/^(?:268\D)(?:(?:st)e{0,1}|(?:saint)e{0,1}).marguerite*$/i", $deliveryAddress) === 1 ||
                preg_match("/^5475.*coolbrook.*$/i", $deliveryAddress) === 1
            ) {
                $this->_blackListEmail($userEmail, $deliveryAddress, $phone);
                throw new Exception($deliveryAddress);
            }
        }

        // Anti fraud by phone
        if (!empty($phone)) {
            $phone = preg_replace('[^0-9]', '', $phone);     // Keep number character only
            if (
                $phone == '5142209020' ||
                $phone == '5142653871' ||
                $phone == '4388020722' ||
                $phone == '5148896632' ||
                $phone == '4388684998' ||
                $phone == '5145274270' ||
                $phone == '4389349961'
            ) {
                $this->_blackListEmail($userEmail, $phone, $phone);
                throw new Exception;
            }
        }
    }

    private function _blackListEmail($userEmail, $data, $phone) {
        $Email = new CakeEmail();
        $Email->from('fraud@topmenu.com');
        $Email->to(Configure::read('fraud.emails'));
        $Email->subject('Utilisateur Bloquer par black list');
        $Email->send("La commande de l'utilisateur [$userEmail] fût bloquer puisque [$data] est sur notre black liste\nTel de l'utilisateur: $phone");
    }

}
    