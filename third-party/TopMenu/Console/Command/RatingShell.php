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

class RatingShell extends AppShell {

    public $uses = array('Rating', 'Location');

    public function initialize() {
        Configure::write('debug', 2);
        parent::initialize();
    }

    public function main() {


        if ($this->args[0] !== 'U') {

            $this->out('Welcome to the user shell!');
            $this->out('Possible Commands:');

            $this->out('U ) Update ratings');
            $this->out('UX) Update and delete older than 90 days retings');
            $this->out('Q ) Quit - Quits the shell');

            // User input from console
            $command = $this->in(
                'Command', array(
                'U',
                'Q',
                'UX'), 'Q'
            );
        } else {

            // Arguments from command line (CRON JOB)
            echo "Hello cron job";
            $this->updateRating(false);
            exit();
        }

        switch ($command) {
            case 'U':
            case 'u':
            default:
                $this->updateRating(true);
                break;

            case 'UX':
            case 'ux':
                $this->updateAndClean();
                break;

            case 'q':
            case 'Q':
                $this->out('Thanks for using the rating shell!');
                exit;
                break;

            default:
                $this->out('Wrong input');
                break;
        }
    }

    public function updateAndClean() {

        $this->out('This as NOT been tested. Proceed anyway');
        $command = $this->in(
            'Command', array('Y', 'N'), 'N');

        if (strtoupper($command) === 'Y') {
            echo "Cleaning...\n";
            $this->Rating->cleanUpOldRatings();
            $this->updateRating();
        } else {
            echo " XXX Action cancelled XXX \n";
            $this->main();
        }
    }

    public function updateRating($human) {

        // get all active ratings
        echo "retrieving ratings...\n";
        $ratingsAverage = $this->Rating->find('all', array(
            'conditions' => array('Rating.rating >' => 0, 'status' => 'active'),
            'fields'     => array('Rating.id', 'Rating.location_id', 'AVG(Rating.rating) AS "avgRating"'),
            'group'      => 'Rating.location_id'
        ));

        $i         = 0;
        $totalToDo = sizeof($ratingsAverage);

        echo "updating ratings...\n";

        foreach ($ratingsAverage as $ra) {

            // update locations rating 
            $this->Location->id = $ra['Rating']['location_id'];
            $this->Location->set('rating', $ra['0']['avgRating']);
            $this->Location->save();

            // Output to console            
            echo "\033[5D";                                                         // Overwrite progress percentage string by backing 5 steps
            echo str_pad(( ++$i / $totalToDo) * 100, 3, ' ', STR_PAD_LEFT) . " %";       // Output is always 5 characters long
        }

        echo "\nDone!\n";
        if ($human) {
            $this->main();
        }
    }

}
