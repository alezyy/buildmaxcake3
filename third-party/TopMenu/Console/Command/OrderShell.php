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
App::import('Core', 'ConnectionManager');

class OrderShell extends AppShell {

    public $uses = array('Order', 'DeviceOrder');

    public function initialize() {
        parent::initialize();
    }

    public function getOptionParser() {
        $parser = parent::getOptionParser();
        $parser->addArgument('testArgument', array('help' => 'The test argument', 'choices' => array('C')));
        $parser->addOption('function', array(
            'short'   => 'f',
            'choices' => array('cleanOrderQueue', 'main'),
            'help'    => 'The function you want to run'));
        return $parser;
    }

    public function main($arg = null) {

        // Run the appropriate function according to the -f option from the command line (or show a menu by default)
        switch ($this->params['function']) {
            
            case 'cleanOrderQueue':
            $this->cleanOrderQueue();
                break;
            case 'test':
            $this->test();
                break;

            default:
                

            $this->out('Welcome to the Orders shell!');
            $this->out('Possible Commands:');

            $this->out('C ) Clean the device orders queue');
            $this->out('Q ) Quit - Quits the shell');

            $command = $this->in('Command', array('C', 'Q'), 'Q');

            switch ($command) {
                case 'c':
                case 'C':
                    $this->cleanOrderQueue(false);
                    break;

                case 'q':
                case 'Q':
                    $this->out('Thanks for using the orders\' shell!');
                    exit;
                    break;

                default:
                    $this->out('Wrong input');
                    break;
            }
        }
    }

    /**
     * This iterate all the orders in the devie_order table and check if any of those order should be removed from the queu
     * to avoid printers from printing old orders upon waking up.
     * 
     * This is 
     * 
     * @param bool $exit False to return to the shell menu. True will exit the script silently
     */
    public function cleanOrderQueue() {
        
        echo "\nTESTTESTSTES";

        // Get all the orders in the queu older than 10 minutes
        $tenMinutesEarlier = date('Y-m-d H:i:s', time() - (MINUTE * 10));
        $conditions        = array('DeviceOrder.created < ' => $tenMinutesEarlier);
        $do                = $this->DeviceOrder->find('all', array('conditions' => $conditions));

        // Set all the old orders found to timeout in the order table
        echo "Orders modify: ";
        $i = 0;
        foreach ($do as $k => $v) {
            echo ++$i . "\n";
            $this->Order = $v['DeviceOrder']['order_id'];
            $this->Order->set('overall_status', 'timeout');
        }
    }
    
    public function test(){
        $this->log('cronjob test');
    }

}
