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
class SectorShell extends AppShell {
	public  $uses = array('Sector','Location');

	public function initialize() {
		Configure::write('debug', 2);
		parent::initialize();
	}

	public function main() {
        echo "\n"
            . "----------------------------------- "
            . "This shell is IMCOMPLETE!!!!!!!!!!!"
            . " -----------------------------------"
            . "\n\n";          
    }
}

/**
 * This shell is IMCOMPLETE!!!!!!!!!!!  EVERYTHING FOLLOWING THIS IS JUST IS //TODO STUFF
 */

/**
 * Find out which sectors have online restaurants (at least one)
 */

/**
 * ♪ Step 1: We can have lots of fun♪
 */
// Get all the delivery area served by an online restaurant
$query = "SELECT DISTINCT(da.`postal_code`)
    FROM `delivery_areas` AS da
    JOIN locations as l on l.id = da.location_id
    JOIN menus AS m on l.id = m.location_id
    WHERE l.online_ordering = 1
    AND m.status = 'active'";

$delivery_areas = array(
  array('postal_code' => 'H2E'),
  array('postal_code' => 'H2H'),
  array('postal_code' => 'H2J'),
  array('postal_code' => 'H2L'),
  array('postal_code' => 'H2P'),
  array('postal_code' => 'H2R'),
  array('postal_code' => 'H2S'),
  array('postal_code' => 'H2T'),
  array('postal_code' => 'H2W'),
  array('postal_code' => 'H2X'),
  array('postal_code' => 'H2Z'),
  array('postal_code' => 'H2K'),
  array('postal_code' => 'H2V'),
  array('postal_code' => 'H2G'),
  array('postal_code' => 'H3C'),
  array('postal_code' => 'H1N'),
  array('postal_code' => 'H1T'),
  array('postal_code' => 'H1V'),
  array('postal_code' => 'H1W'),
  array('postal_code' => 'H1X'),
  array('postal_code' => 'H1Y'),
  array('postal_code' => 'H1Z'),
  array('postal_code' => 'H2A'),
  array('postal_code' => 'H3S'),
  array('postal_code' => 'H3T'),
  array('postal_code' => 'H3V'),
  array('postal_code' => 'H4Z'),
  array('postal_code' => 'H5A'),
  array('postal_code' => 'H5B'),
  array('postal_code' => 'H2Y'),
  array('postal_code' => 'H3A'),
  array('postal_code' => 'H3B'),
  array('postal_code' => 'H1M'),
  array('postal_code' => 'H1P'),
  array('postal_code' => 'H1R'),
  array('postal_code' => 'H1S'),
  array('postal_code' => 'H2C'),
  array('postal_code' => 'H3G'),
  array('postal_code' => 'H3H'),
  array('postal_code' => 'H3J'),
  array('postal_code' => 'H3K'),
  array('postal_code' => 'H3L'),
  array('postal_code' => 'H3P'),
  array('postal_code' => 'H3W'),
  array('postal_code' => 'H3Y'),
  array('postal_code' => 'H3Z'),
  array('postal_code' => 'H4A'),
  array('postal_code' => 'H4C'),
  array('postal_code' => 'H4G'),
  array('postal_code' => 'H4E'),
  array('postal_code' => 'H4H'),
  array('postal_code' => 'H4V'),
  array('postal_code' => 'H4N'),
  array('postal_code' => 'H7A'),
  array('postal_code' => 'H7B'),
  array('postal_code' => 'H7C'),
  array('postal_code' => 'H7E'),
  array('postal_code' => 'H7G'),
  array('postal_code' => 'H7H'),
  array('postal_code' => 'H7J'),
  array('postal_code' => 'H7L'),
  array('postal_code' => 'H7W'),
  array('postal_code' => 'J4G'),
  array('postal_code' => 'J4H'),
  array('postal_code' => 'J4J'),
  array('postal_code' => 'J4K'),
  array('postal_code' => 'J4L'),
  array('postal_code' => 'J4M'),
  array('postal_code' => 'J4P'),
  array('postal_code' => 'J4R'),
  array('postal_code' => 'J4V'),
  array('postal_code' => 'J4W'),
  array('postal_code' => 'J4X'),
  array('postal_code' => 'J4Z'),
  array('postal_code' => 'H3e'),
  array('postal_code' => 'H2M'),
  array('postal_code' => 'H2N'),
  array('postal_code' => 'H3N'),
  array('postal_code' => 'H8N'),
  array('postal_code' => 'H8P'),
  array('postal_code' => 'H3X'),
  array('postal_code' => 'H4B'),
  array('postal_code' => 'H4J'),
  array('postal_code' => 'H4K'),
  array('postal_code' => 'H4L'),
  array('postal_code' => 'H4M'),
  array('postal_code' => 'H7K'),
  array('postal_code' => 'J4N'),
  array('postal_code' => 'H3M'),
  array('postal_code' => 'H3R'),
  array('postal_code' => 'h1h'),
  array('postal_code' => 'h2b'),
  array('postal_code' => 'H4p'),
  array('postal_code' => 'H4X'),
  array('postal_code' => 'H4W'),
  array('postal_code' => 'H4R'),
  array('postal_code' => 'H8R'),
  array('postal_code' => 'J3Y'),
  array('postal_code' => 'J3Z'),
  array('postal_code' => 'J4T'),
  array('postal_code' => 'J4S'),
  array('postal_code' => 'J4Y'),
  array('postal_code' => 'H4S'),
  array('postal_code' => 'H4T'),
  array('postal_code' => 'J7E'),
  array('postal_code' => 'J7J'),
  array('postal_code' => 'J7C'),
  array('postal_code' => 'J7B'),
  array('postal_code' => 'H1B'),
  array('postal_code' => 'H1A')
);


/**
 * ♪ Step 2: There's so much we can do ♪
 * Get all the sectors and there postal codes
 */
$sectors = array(
  array('name_fr' => 'Sainte-Rose','code' => 'H1C,H1E'),
  array('name_fr' => 'Centre ville','code' => 'H3A,H3B,H3C,H3H,H3G,H3Z,H2Y'),
  array('name_fr' => 'Saint-Jérôme','code' => 'J5L,J7Y,J7Z'),
  array('name_fr' => 'Sainte-Rose','code' => 'H7L'),
  array('name_fr' => 'Brossard - St-Lambert - Greenfield Park','code' => 'J4P,J4R,J4S,J4V,J4Y,J4Z,J4W,J4X,'),
  array('name_fr' => 'Rosemère -  Lorraine - Bois-des-Filion - Boisbriand','code' => 'J6Z,J7A,J7G,J7H'),
  array('name_fr' => 'Val-d\'Or','code' => 'J9P'),
  array('name_fr' => 'Laval-Des-Rapides','code' => 'H7N'),
  array('name_fr' => 'Pierrefonds - DDO - Roxboro - Kirkland','code' => 'H9A,H9C,H9E,H9G,H9H,H9J,H9K'),
  array('name_fr' => 'Drummondville','code' => 'J2A,J2B,J2C,J2E'),
  array('name_fr' => 'Ville Mont-Royal  - T.M.R.','code' => 'H3P,H3R'),
  array('name_fr' => 'Terrebonne','code' => 'J6V,J6W,J6X'),
  array('name_fr' => 'Hochelaga','code' => 'H1V,H1W,H2K'),
  array('name_fr' => 'Villeray','code' => 'H2S,H2R,H2E,H2P'),
  array('name_fr' => 'Rosemont Est','code' => 'H1T,H1X'),
  array('name_fr' => 'Ile-des-soeurs','code' => 'H3E'),
  array('name_fr' => 'Notre-Dame-de-Grâce (NDG)','code' => 'H3X,H4W,H4A,H4V,H4B,H4X,'),
  array('name_fr' => 'Chomedey - Sainte-Dorothée','code' => 'H7W,H7X'),
  array('name_fr' => 'Centre Sud','code' => 'H2L,H2X,H2Z'),
  array('name_fr' => 'Montréal Nord H1G','code' => 'H1G'),
  array('name_fr' => 'Longue-Pointe','code' => 'H1N,H1M'),
  array('name_fr' => 'LaSalle','code' => 'H8N,H8R,H8P'),
  array('name_fr' => 'Saint-Eustache','code' => 'J7P,J7R'),
  array('name_fr' => 'Vimont - Auteuil','code' => 'H7H,H7K,H7M'),
  array('name_fr' => 'Parc Extension','code' => 'H3N'),
  array('name_fr' => 'Montréal Nord H1H','code' => 'H1H'),
  array('name_fr' => 'Joliette','code' => 'J6E'),
  array('name_fr' => 'Dorval','code' => 'H4Y,H8T,H9P,H9S'),
  array('name_fr' => 'Duvernay / Pont-Viau','code' => 'H7C,H7E,H7G,H7A'),
  array('name_fr' => 'Île Bizard-Pierrefonds','code' => 'H9E,H9C'),
  array('name_fr' => 'Ahuntsic Ouest','code' => 'H2M,H2N,H3L'),
  array('name_fr' => 'Mascouche','code' => 'J7K,J7L'),
  array('name_fr' => 'Pointe Claire','code' => 'H8T,H9R'),
  array('name_fr' => 'St-Hubert - Laflèche - Greenfield Park','code' => 'J3Y,J3Z,J4T,J4V'),
  array('name_fr' => 'Lachine H8S','code' => 'H8S'),
  array('name_fr' => 'Pointe St-Charles - St-Henri','code' => 'H4C,H3K,H3J'),
  array('name_fr' => 'Longueuil','code' => 'J4L,J4G,,J4H,J4J,J4M,J4N,J4K'),
  array('name_fr' => 'Rosemont Ouest','code' => 'H1Y,H2G,H2H'),
  array('name_fr' => 'Fabreville','code' => 'H7P'),
  array('name_fr' => 'Boucherville','code' => 'J4B'),
  array('name_fr' => 'Snowdon-Upper Westmount-Côte-des-neiges','code' => 'H3W,H3Y'),
  array('name_fr' => 'Rivière-Des-Prairies','code' => 'H1C,H1E'),
  array('name_fr' => 'Tétreaultville','code' => 'H1L'),
  array('name_fr' => 'Sainte-Thérèse - Blainville','code' => 'J7E,J7B,J7C'),
  array('name_fr' => 'Saint-Laurent OUEST','code' => 'H4M,H4R,H4T,H4S,H4K,H4J,'),
  array('name_fr' => 'Granby','code' => 'J2G,J2H,J2J'),
  array('name_fr' => 'Laval Ouest','code' => 'H7R,H7Y'),
  array('name_fr' => 'Outremont','code' => 'H2V'),
  array('name_fr' => 'Anjou','code' => 'H1J,H1K'),
  array('name_fr' => 'Saint-Léonard','code' => 'H1P,H1R,H1S'),
  array('name_fr' => 'Saint-Michel','code' => ''),
  array('name_fr' => 'Repentigny','code' => 'J5Y,J5Z,J6A'),
  array('name_fr' => 'Plateau Mont-Royal','code' => 'H2H,H2J,H2T,H2W'),
  array('name_fr' => 'Saint-Laurent EST','code' => 'H3M,H4L,H4N'),
  array('name_fr' => 'Verdun','code' => 'H4G,H4E,H4H,'),
  array('name_fr' => 'Rouyn-Noranda','code' => 'J9X,J9Y'),
  array('name_fr' => 'Ahuntsic Est','code' => 'H2B,H2C'),
  array('name_fr' => 'Pointe-Aux-Trembles','code' => 'H1A,H1B'),
  array('name_fr' => 'Côtes des Neiges','code' => 'H3S,H3V,H3T'),
  array('name_fr' => 'Beaconsfield - Kirkland','code' => 'H9W'),
  array('name_fr' => 'St-Hilaire - Otterburn Park','code' => 'J3H'),
  array('name_fr' => 'St-Luc','code' => 'J2W'),
  array('name_fr' => 'St-Jean sur Richelieu ','code' => 'J2X,J2Y,J3A,J3B'),
  array('name_fr' => 'St-Hyacinthe','code' => '(J2R,J2S,J2T)'),
  array('name_fr' => 'Ville St-Pierre/Lasalle','code' => 'H8R'),
  array('name_fr' => 'Beloeil - St-Basile - MC Masterville','code' => 'J3G,J3N'),
  array('name_fr' => 'Chomedey','code' => 'H7S,H7T,H7V'),
  array('name_fr' => 'Nouveau Rosemont','code' => 'H1S,H1M'),
  array('name_fr' => 'Châteauguay - Mercier - Kahnawake','code' => 'J6J,J6K,J6R,J0L'),
  array('name_fr' => 'Vaudreuil - Dorion - ILe Perrot - Pincout','code' => 'J7V'),
  array('name_fr' => 'Rivière des Prairies','code' => 'H1C,H1E')
);

/**
 * ♪ Step 3: It's just you and me ♪
 * Is the stuff from the first array in the other array?
 */
$sectorsOnline = array();
foreach ($sectors as $sectorKey => $sectorValue) {    
    $codes = explode(',', $sectorValue['code']);
    foreach ($codes as $pcKey => $pcValue) {
        foreach($delivery_areas as $daKey => $daValue){
            if($pcValue === $daValue['postal_code'] ){                               
                $sectorsOnline[] = $sectorValue['name_fr'] . "\t" . str_replace(',', "\t", $sectorValue['code']) ;
            }
        }
        
    }
}

/**
 * ♪ Step 4: I can give you more ♪
 * Ouptut the results
 */
$sectorsOnline = array_unique($sectorsOnline);
foreach ($sectorsOnline AS $v){
    echo $v . "\n";
}

/**
 * ♪ Step 5: Don't you know that the time has arrived ♪
 * Profit!
 */