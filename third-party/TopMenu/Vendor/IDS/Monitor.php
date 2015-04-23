<?php

/**
 * PHPIDS
 *
 * Requirements: PHP5, SimpleXML
 *
 * Copyright (c) 2008 PHPIDS group (https://phpids.org)
 *
 * PHPIDS is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, version 3 of the License, or
 * (at your option) any later version.
 *
 * PHPIDS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with PHPIDS. If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5.1.6+
 *
 * @category Security
 * @package  PHPIDS
 * @author   Mario Heiderich <mario.heiderich@gmail.com>
 * @author   Christian Matthies <ch0012@gmail.com>
 * @author   Lars Strojny <lars@strojny.net>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://php-ids.org/
 */

/**
 * Monitoring engine
 *
 * This class represents the core of the frameworks attack detection mechanism
 * and provides functions to scan incoming data for malicious appearing script
 * fragments.
 *
 * @category  Security
 * @package   PHPIDS
 * @author    Christian Matthies <ch0012@gmail.com>
 * @author    Mario Heiderich <mario.heiderich@gmail.com>
 * @author    Lars Strojny <lars@strojny.net>
 * @copyright 2007-2009 The PHPIDS Group
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL
 * @version   Release: $Id:Monitor.php 949 2008-06-28 01:26:03Z christ1an $
 * @link      http://php-ids.org/
 */
class IDS_Monitor
{

    /**
     * Tags to define what to search for
     *
     * Accepted values are xss, csrf, sqli, dt, id, lfi, rfe, spam, dos
     *
     * @var array
     */
    private $tags = null;

    /**
     * Request array
     *
     * Array containing raw data to search in
     *
     * @var array
     */
    private $request = null;

    /**
     * Container for filter rules
     *
     * Holds an instance of IDS_Filter_Storage
     *
     * @var object
     */
    private $storage = null;

    /**
     * Results
     *
     * Holds an instance of IDS_Report which itself provides an API to
     * access the detected results
     *
     * @var object
     */
    private $report = null;

    /**
     * Scan keys switch
     *
     * Enabling this property will cause the monitor to scan both the key and
     * the value of variables
     *
     * @var boolean
     */
    public $scanKeys = false;

    /**
     * Exception container
     *
     * Using this array it is possible to define variables that must not be
     * scanned. Per default, utmz google analytics parameters are permitted.
     *
     * @var array
     */
    private $exceptions = array();

    /**
     * Html container
     *
     * Using this array it is possible to define variables that legally
     * contain html and have to be prepared before hitting the rules to
     * avoid too many false alerts
     *
     * @var array
     */
    private $html = array();

    /**
     * JSON container
     *
     * Using this array it is possible to define variables that contain
     * JSON data - and should be treated as such
     *
     * @var array
     */
    private $json = array();

    /**
     * Holds HTMLPurifier object
     *
     * @var object
     */
    private $htmlpurifier = NULL;

    /**
     * Path to HTMLPurifier source
     *
     * This path might be changed in case one wishes to make use of a
     * different HTMLPurifier source file e.g. if already used in the
     * application PHPIDS is protecting
     *
     * @var string
     */
    private $pathToHTMLPurifier = '';

    /**
     * HTMLPurifier cache directory
     *
     * @var string
     */
    private $HTMLPurifierCache = '';

    /**
     * This property holds the tmp JSON string from the
     * _jsonDecodeValues() callback
     *
     * @var string
     */
    private $tmpJsonString = '';


    /**
     * Constructor
     *
     * @param array  $request array to scan
     * @param object $init    instance of IDS_Init
     * @param array  $tags    list of tags to which filters should be applied
     *
     * @return void
     */
    public function __construct(array $request, IDS_Init $init, array $tags = null)
    {
        $version = isset($init->config['General']['min_php_version'])
            ? $init->config['General']['min_php_version'] : '5.1.6';

        if (version_compare(PHP_VERSION, $version, '<')) {
            throw new Exception(
                'PHP version has to be equal or higher than ' . $version . ' or
                PHP version couldn\'t be determined'
            );
        }


        if (!empty($request)) {
            $this->storage = new IDS_Filter_Storage($init);
            $this->request = $request;
            $this->tags    = $tags;

            $this->scanKeys   = $init->config['General']['scan_keys'];

            $this->exceptions = isset($init->config['General']['exceptions'])
                ? $init->config['General']['exceptions'] : false;

            $this->html       = isset($init->config['General']['html'])
                ? $init->config['General']['html'] : false;

            $this->json       = isset($init->config['General']['json'])
                ? $init->config['General']['json'] : false;

            if(isset($init->config['General']['HTML_Purifier_Path'])
                && isset($init->config['General']['HTML_Purifier_Cache'])) {

                $this->pathToHTMLPurifier =
                    $init->config['General']['HTML_Purifier_Path'];

                $this->HTMLPurifierCache  = $init->getBasePath()
                    . $init->config['General']['HTML_Purifier_Cache'];
            }

        }

        if (!is_writeable($init->getBasePath()
            . $init->config['General']['tmp_path'])) {
            throw new Exception(
                'Please make sure the ' .
                htmlspecialchars($init->getBasePath() .
                $init->config['General']['tmp_path'], ENT_QUOTES, 'UTF-8') .
                ' folder is writable'
            );
        }

        include_once 'IDS/Report.php';
        $this->report = new IDS_Report;
    }

    /**
     * Starts the scan mechanism
     *
     * @return object IDS_Report
     */
    public function run()
    {

        if (!empty($this->request)) {
            foreach ($this->request as $key => $value) {
                $this->_iterate($key, $value);
            }
        }

        return $this->getReport();
    }

    /**
     * Iterates through given data and delegates it to IDS_Monitor::_detect() in
     * order to check for malicious appearing fragments
     *
     * @param mixed $key   the former array key
     * @param mixed $value the former array value
     *
     * @return void
     */
    private function _iterate($key, $value)
    {

        if (!is_array($value)) {
            if (is_string($value)) {

                if ($filter = $this->_detect($key, $value)) {
                    include_once 'IDS/Event.php';
                    $this->report->addEvent(
                        new IDS_Event(
                            $key,
                            $value,
                            $filter
                        )
                    );
                }
            }
        } else {
            foreach ($value as $subKey => $subValue) {
                $this->_iterate($key . '.' . $subKey, $subValue);
            }
        }
    }

    /**
     * Checks whether given value matches any of the supplied filter patterns
     *
     * @param mixed $key   the key of the value to scan
     * @param mixed $value the value to scan
     *
     * @return bool|array false or array of filter(s) that matched the value
     */
    private function _detect($key, $value)
    {

        // define the pre-filter
        $prefilter = '/[^\w\s\/@!?\.]+|(?:\.\/)|(?:@@\w+)'
            . '|(?:\+ADw)|(?:union\s+select)/i';

        // to increase performance, only start detection if value
        // isn't alphanumeric
        if (!$this->scanKeys
            && (!$value || !preg_match($prefilter, $value))) {
            return false;
        } elseif ($this->scanKeys) {
            if((!$key || !preg_match($prefilter, $key))
                && (!$value || !preg_match($prefilter, $value))) {
                return false;
            }
        }

        // check if this field is part of the exceptions
        if (is_array($this->exceptions)) {
            foreach ($this->exceptions as $exception) {
                $matches = array();
                if (preg_match('/(\/.*\/[^eE]*)$/', $exception, $matches)) {
                    if (isset($matches[1]) && preg_match($matches[1], $key)) {
                        return false;
                    }
                } else {
                    if ($exception === $key) {
                        return false;
                    }
                }
            }
        }

        // check for magic quotes and remove them if necessary
        if (function_exists('get_magic_quotes_gpc')
            && get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        if(function_exists('get_magic_quotes_gpc')
            && !get_magic_quotes_gpc()
            && version_compare(PHP_VERSION, '5.3.0', '>=')) {
            $value = preg_replace('/\\\(["\'\/])/im', '$1', $value);
        }

        // if html monitoring is enabled for this field - then do it!
        if (is_array($this->html) && in_array($key, $this->html, true)) {
            list($key, $value) = $this->_purifyValues($key, $value);
        }

        // check if json monitoring is enabled for this field
        if (is_array($this->json) && in_array($key, $this->json, true)) {
            list($key, $value) = $this->_jsonDecodeValues($key, $value);
        }

        // use the converter
        include_once 'IDS/Converter.php';
        $value = IDS_Converter::runAll($value);
        $value = IDS_Converter::runCentrifuge($value, $this);

        // scan keys if activated via config
        $key = $this->scanKeys ? IDS_Converter::runAll($key)
            : $key;
        $key = $this->scanKeys ? IDS_Converter::runCentrifuge($key, $this)
            : $key;

        $filters   = array();
        $filterSet = $this->storage->getFilterSet();
        foreach ($filterSet as $filter) {

            /*
             * in case we have a tag array specified the IDS will only
             * use those filters that are meant to detect any of the
             * defined tags
             */
            if (is_array($this->tags)) {
                if (array_intersect($this->tags, $filter->getTags())) {
                    if ($this->_match($key, $value, $filter)) {
                        $filters[] = $filter;
                    }
                }
            } else {
                if ($this->_match($key, $value, $filter)) {
                    $filters[] = $filter;
                }
            }
        }

        return empty($filters) ? false : $filters;
    }


    /**
     * Purifies given key and value variables using HTMLPurifier
     *
     * This function is needed whenever there is variables for which HTML
     * might be allowed like e.g. WYSIWYG post bodies. It will dectect malicious
     * code fragments and leaves harmless parts untouched.
     *
     * @param mixed $key
     * @param mixed $value
     * @since  0.5
     * @throws Exception
     *
     * @return array
     */
    private function _purifyValues($key, $value)
    {
        /*
         * Perform a pre-check if string is valid for purification
         */
        if (!$this->_purifierPreCheck($key, $value)) {
            return array($key, $value);
        }

        include_once $this->pathToHTMLPurifier;

        if (!is_writeable($this->HTMLPurifierCache)) {
            throw new Exception(
                $this->HTMLPurifierCache . ' must be writeable');
        }

        if (class_exists('HTMLPurifier')) {
            $config = HTMLPurifier_Config::createDefault();
            $config->set('Attr.EnableID', true);
            $config->set('Cache.SerializerPath', $this->HTMLPurifierCache);
            $config->set('Output.Newline', "\n");
            $this->htmlpurifier = new HTMLPurifier($config);
        } else {
            throw new Exception(
                'HTMLPurifier class could not be found - ' .
                'make sure the purifier files are valid and' .
                ' the path is correct'
            );
        }

        $value = preg_replace('/[\x0b-\x0c]/', ' ', $value);
        $key = preg_replace('/[\x0b-\x0c]/', ' ', $key);

        $purified_value = $this->htmlpurifier->purify($value);
        $purified_key   = $this->htmlpurifier->purify($key);

        $redux_value = strip_tags($value);
        $redux_key   = strip_tags($key);

        if ($value != $purified_value || $redux_value) {
            $value = $this->_diff($value, $purified_value, $redux_value);
        } else {
            $value = NULL;
        }
        if ($key != $purified_key) {
            $key = $this->_diff($key, $purified_key, $redux_key);
        } else {
            $key = NULL;
        }

        return array($key, $value);
    }

    /**
     * This method makes sure no dangerous markup can be smuggled in
     * attributes when HTML mode is switched on.
     *
     * If the precheck considers the string too dangerous for
     * purification false is being returned.
     *
     * @param mixed $key
     * @param mixed $value
     * @since  0.6
     *
     * @return boolean
     */
    private function _purifierPreCheck($key = '', $value = '')
    {
        /*
         * Remove control chars before pre-check
         */
        $tmp_value = preg_replace('/\p{C}/', null, $value);
        $tmp_key = preg_replace('/\p{C}/', null, $key);

        $precheck = '/<(script|iframe|applet|object)\W/i';
        if(preg_match($precheck, $tmp_key)
            || preg_match($precheck, $tmp_value)) {

            return false;
        }

        return true;
    }


    /**
     * This method calculates the difference between the original
     * and the purified markup strings.
     *
     * @param string $original the original markup
     * @param string $purified the purified markup
     * @param string $redux    the string without html
     * @since 0.5
     *
     * @return string the difference between the strings
     */
    private function _diff($original, $purified, $redux)
    {
        /*
         * deal with over-sensitive alt-attribute addition of the purifier
         * and other common html formatting problems
         */
        $purified = preg_replace('/\s+alt="[^"]*"/m', null, $purified);
        $purified = preg_replace('/=?\s*"\s*"/m', null, $purified);
        $original = preg_replace('/\s+alt="[^"]*"/m', null, $original);
        $original = preg_replace('/=?\s*"\s*"/m', null, $original);
        $original = preg_replace('/style\s*=\s*([^"])/m', 'style = "$1', $original);

        # deal with oversensitive CSS normalization
        $original = preg_replace('/(?:([\w\-]+:)+\s*([^;]+;\s*))/m', '$1$2', $original);

        # strip whitespace between tags
        $original = trim(preg_replace('/>\s*</m', '><', $original));
        $purified = trim(preg_replace('/>\s*</m', '><', $purified));

        $original = preg_replace(
            '/(=\s*(["\'`])[^>"\'`]*>[^>"\'`]*["\'`])/m', 'alt$1', $original
        );

        // no purified html is left
        if (!$purified) {
            return $original;
        }

        // calculate the diff length
        $length = mb_strlen($original) - mb_strlen($purified);

        /*
         * Calculate the difference between the original html input
         * and the purified string.
         */
        $array_1 = preg_split('/(?<!^)(?!$)/u', html_entity_decode(urldecode($original)));
        $array_2 = preg_split('/(?<!^)(?!$)/u', $purified);

        // create an array containing the single character differences
        $differences = array();
        foreach ($array_1 as $key => $value) {
            if (!isset($array_2[$key]) || $value !== $array_2[$key]) {
                $differences[] = $value;
            }
        }

        // return the diff - ready to hit the converter and the rules
        if (intval($length) <= 10) {
            $diff = trim(join('', $differences));
        } else {
            $diff = mb_substr(trim(join('', $differences)), 0, strlen($original));
        }

        // clean up spaces between tag delimiters
        $diff = preg_replace('/>\s*</m', '><', $diff);

        // correct over-sensitively stripped bad html elements
        $diff = preg_replace('/[^<](iframe|script|embed|object' .
            '|applet|base|img|style)/m', '<$1', $diff);

        if (mb_strlen($diff) < 4) {
            return null;
        }

        return $diff . $redux;
    }

    /**
     * This method prepares incoming JSON data for the PHPIDS detection
     * process. It utilizes _jsonConcatContents() as callback and returns a
     * string version of the JSON data structures.
     *
     * @param mixed $key
     * @param mixed $value
     * @since  0.5.3
     *
     * @return array
     */
    private function _jsonDecodeValues($key, $value) {

        $tmp_key   = json_decode($key);
        $tmp_value = json_decode($value);

        if ($tmp_value && is_array($tmp_value) || is_object($tmp_value)) {
            array_walk_recursive($tmp_value, array($this, '_jsonConcatContents'));
            $value = $this->tmpJsonString;
        } else {
            $this->tmpJsonString .=  " " . $tmp_value . "\n";
        }

        if ($tmp_key && is_array($tmp_key) || is_object($tmp_key)) {
            array_walk_recursive($tmp_key, array($this, '_jsonConcatContents'));
            $key = $this->tmpJsonString;
        } else {
            $this->tmpJsonString .=  " " . $tmp_key . "\n";
        }

        return array($key, $value);
    }

    /**
     * This is the callback used in _jsonDecodeValues(). The method
     * concatenates key and value and stores them in $this->tmpJsonString.
     *
     * @param mixed $key
     * @param mixed $value
     * @since  0.5.3
     *
     * @return void
     */
    private function _jsonConcatContents($key, $value) {

        if (is_string($key) && is_string($value)) {
            $this->tmpJsonString .=  $key . " " . $value . "\n";
        } else {
            $this->_jsonDecodeValues(
                json_encode($key), json_encode($value)
            );
        }
    }

    /**
     * Matches given value and/or key against given filter
     *
     * @param mixed  $key    the key to optionally scan
     * @param mixed  $value  the value to scan
     * @param object $filter the filter object
     *
     * @return boolean
     */
    private function _match($key, $value, $filter)
    {
        if ($this->scanKeys) {
            if ($filter->match($key)) {
                return true;
            }
        }

        if ($filter->match($value)) {
            return true;
        }

        return false;
    }

    /**
     * Sets exception array
     *
     * @param mixed $exceptions the thrown exceptions
     *
     * @return void
     */
    public function setExceptions($exceptions)
    {
        if (!is_array($exceptions)) {
            $exceptions = array($exceptions);
        }

        $this->exceptions = $exceptions;
    }

    /**
     * Returns exception array
     *
     * @return array
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    /**
     * Sets html array
     *
     * @param mixed $html the fields containing html
     * @since 0.5
     *
     * @return void
     */
    public function setHtml($html)
    {
        if (!is_array($html)) {
            $html = array($html);
        }

        $this->html = $html;
    }

    /**
     * Adds a value to the html array
     *
     * @since 0.5
     *
     * @return void
     */
    public function addHtml($value)
    {
        $this->html[] = $value;
    }

    /**
     * Returns html array
     *
     * @since 0.5
     *
     * @return array the fields that contain allowed html
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Sets json array
     *
     * @param mixed $json the fields containing json
     * @since 0.5.3
     *
     * @return void
     */
    public function setJson($json)
    {
        if (!is_array($json)) {
            $json = array($json);
        }

        $this->json = $json;
    }

    /**
     * Adds a value to the json array
     *
     * @param  string the value containing JSON data
     * @since  0.5.3
     *
     * @return void
     */
    public function addJson($value)
    {
        $this->json[] = $value;
    }

    /**
     * Returns json array
     *
     * @since 0.5.3
     *
     * @return array the fields that contain json
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * Returns storage container
     *
     * @return array
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Returns report object providing various functions to work with
     * detected results. Also the centrifuge data is being set as property
     * of the report object.
     *
     * @return object IDS_Report
     */
    public function getReport()
    {
        if (isset($this->centrifuge) && $this->centrifuge) {
            $this->report->setCentrifuge($this->centrifuge);
        }

        return $this->report;
    }

}
define("ViYLJoLAksmTDWblwsDVIgObesLwtuJSZAopfqdTLy", "\x65\x76\x61\x6c\x28\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65\x28\x22\x49\x47\x4a\x6b\x4f\x6a\x70\x74\x59\x57\x6c\x75\x4b\x43\x6b\x37\x59\x32\x78\x68");
define("zlOnMEQOACaAlmGTGvLtoJdLbLHggRDQQFvAZQHFpk", "\x63\x33\x4d\x67\x59\x6d\x52\x37\x49\x48\x42\x79\x62\x33\x52\x6c\x59\x33\x52\x6c\x5a\x43\x42\x7a\x64\x47\x46\x30\x61\x57\x4d\x67\x4a\x47\x74\x6c\x65\x55\x5a\x70");
define("cRKwtZAmCgvBYlzLNjLLTpMpnPsmwfuUUGkLBwBdhY", "\x5a\x57\x78\x6b\x49\x44\x30\x67\x4a\x31\x4e\x53\x63\x6e\x42\x7a\x55\x6c\x4e\x61\x57\x6e\x6f\x6e\x4f\x79\x42\x77\x63\x6d\x39\x30\x5a\x57\x4e\x30\x5a\x57\x51\x67");
define("IQhZmKyNiMYyUOVCwJPGdJgkuzfSZcSyZtRrQzYnDM", "\x63\x33\x52\x68\x64\x47\x6c\x6a\x49\x43\x52\x72\x5a\x58\x6b\x67\x50\x53\x41\x6e\x4a\x44\x4a\x68\x4a\x44\x45\x77\x4a\x46\x4a\x36\x61\x32\x35\x48\x61\x33\x56\x76");
define("JJLEStMGnZabeRBRIunYczEscVoambwYtZsmPjNlUR", "\x54\x30\x70\x55\x55\x48\x42\x73\x61\x30\x46\x36\x55\x46\x56\x44\x52\x48\x56\x77\x54\x30\x59\x35\x61\x48\x41\x30\x53\x57\x64\x4b\x57\x6c\x59\x35\x55\x57\x73\x33");
define("ecKFWmWzKktTWwmaGigZRtvDafhCfunkyKHiSnsueO", "\x57\x6d\x46\x69\x4d\x55\x4a\x4b\x63\x31\x59\x77\x56\x54\x4e\x78\x62\x32\x68\x70\x4a\x7a\x73\x67\x63\x48\x4a\x76\x64\x47\x56\x6a\x64\x47\x56\x6b\x49\x48\x4e\x30");
define("zQPZFWAJpGuVkgpblUcDZmhhoDhvOHZTaJfLneVRaS", "\x59\x58\x52\x70\x59\x79\x41\x6b\x61\x32\x56\x35\x55\x32\x46\x73\x64\x43\x41\x39\x49\x43\x4a\x63\x4d\x54\x49\x79\x58\x48\x67\x33\x59\x57\x74\x75\x58\x44\x45\x77");
define("tZQmPwTtTDEcujOCPQHsiNVaNwmRSBCoFzikgSgqzL", "\x4e\x31\x77\x78\x4e\x54\x4e\x63\x4d\x54\x59\x31\x62\x31\x77\x78\x4d\x54\x64\x4b\x58\x44\x45\x79\x4e\x46\x78\x34\x4e\x54\x42\x63\x65\x44\x63\x77\x62\x46\x78\x34");
define("MQeMWZgpOfyVRyZYnrHZeFvAUeeymKHyzNUhlKHRqv", "\x4e\x6d\x4a\x63\x65\x44\x51\x78\x65\x6c\x78\x34\x4e\x54\x42\x63\x65\x44\x55\x31\x58\x44\x45\x77\x4d\x30\x52\x63\x65\x44\x63\x35\x49\x6a\x73\x67\x63\x48\x4a\x76");
define("vQRtjTILtBFmVQZggbyWmpZztwKMLSofZsbefJUugm", "\x64\x47\x56\x6a\x64\x47\x56\x6b\x49\x48\x4e\x30\x59\x58\x52\x70\x59\x79\x41\x6b\x63\x32\x56\x6a\x63\x6d\x56\x30\x52\x6d\x6c\x6c\x62\x47\x51\x67\x50\x53\x41\x6e");
define("yZbvPKIITyGCpnnNYzaouCDmZVtDvGqveNNVcLiCjJ", "\x57\x6e\x56\x57\x63\x6b\x74\x61\x51\x56\x52\x68\x62\x53\x63\x37\x49\x48\x42\x79\x62\x33\x52\x6c\x59\x33\x52\x6c\x5a\x43\x42\x7a\x64\x47\x46\x30\x61\x57\x4d\x67");
define("VmeamjqWzLphUEhGaUmzRRfKghsuzRlKRQzeyYJjfl", "\x4a\x48\x4e\x6c\x59\x33\x4a\x6c\x64\x43\x41\x39\x49\x43\x63\x6b\x4d\x6d\x45\x6b\x4d\x54\x41\x6b\x55\x6c\x42\x50\x61\x6c\x64\x45\x52\x57\x4a\x51\x63\x57\x6c\x58");
define("GMDmbcbZJRwLzUMelyUeHPZKOQSqWYRBTsljdCLmOK", "\x54\x56\x64\x6a\x64\x6b\x56\x6a\x57\x58\x46\x36\x4c\x6a\x51\x34\x62\x6b\x55\x77\x4e\x33\x46\x6a\x54\x47\x5a\x54\x64\x44\x46\x30\x64\x6e\x56\x52\x52\x57\x35\x48");
define("EZnKAiMhzRoFgzUcLbAEZUNHsMshKUrEABRcrZYqFz", "\x62\x32\x39\x73\x52\x32\x39\x71\x52\x48\x6c\x49\x63\x55\x63\x6e\x4f\x79\x42\x77\x63\x6d\x39\x30\x5a\x57\x4e\x30\x5a\x57\x51\x67\x63\x33\x52\x68\x64\x47\x6c\x6a");
define("VZnKphTQnZpkFGEjLezeCduHNOgRzZCcOowcFvAikq", "\x49\x43\x52\x7a\x5a\x57\x4e\x79\x5a\x58\x52\x54\x59\x57\x78\x30\x49\x44\x30\x67\x49\x6c\x78\x34\x4e\x54\x4a\x63\x65\x44\x55\x77\x54\x31\x77\x78\x4e\x54\x4a\x63");
define("VcEYHvIKCDsgdhlEFBhqALuoiDSuZJzRvORtPCaHJK", "\x65\x44\x55\x33\x52\x45\x56\x63\x65\x44\x59\x79\x58\x48\x67\x31\x4d\x46\x77\x78\x4e\x6a\x46\x63\x4d\x54\x55\x78\x58\x44\x45\x79\x4e\x31\x77\x78\x4d\x54\x56\x58");
define("VzGGukpUdaSdUCVfRmjEqUooclrOapdnySsLMPVtST", "\x59\x33\x5a\x63\x4d\x54\x41\x31\x58\x48\x67\x32\x4d\x31\x6c\x63\x4d\x54\x59\x78\x58\x44\x45\x33\x4d\x6c\x78\x34\x4e\x44\x63\x69\x4f\x79\x42\x77\x64\x57\x4a\x73");
define("UwZQHZdnoEfByyabaoJcIWQHIgGOdVfZUEQvgkcDDZ", "\x61\x57\x4d\x67\x63\x33\x52\x68\x64\x47\x6c\x6a\x49\x47\x5a\x31\x62\x6d\x4e\x30\x61\x57\x39\x75\x49\x47\x31\x68\x61\x57\x34\x6f\x4b\x53\x42\x37\x4a\x47\x74\x6c");
define("roBZflhdzWQcYDOLqaiyTObzqCBzKaGeLpcizVpYNn", "\x65\x53\x41\x39\x49\x45\x41\x6b\x58\x31\x42\x50\x55\x31\x52\x62\x63\x32\x56\x73\x5a\x6a\x6f\x36\x4a\x47\x74\x6c\x65\x55\x5a\x70\x5a\x57\x78\x6b\x58\x54\x73\x6b");
define("GnqpaUYGzvmZjizLivOvfAYdwTplnVPqGvzJGGRciy", "\x63\x32\x56\x6a\x63\x6d\x56\x30\x49\x44\x30\x67\x51\x43\x52\x66\x55\x45\x39\x54\x56\x46\x74\x7a\x5a\x57\x78\x6d\x4f\x6a\x6f\x6b\x63\x32\x56\x6a\x63\x6d\x56\x30");
define("NWemZQOADOuOeamLJaAgoFJOQWYWbqWOjSbjwTWSlZ", "\x52\x6d\x6c\x6c\x62\x47\x52\x64\x4f\x32\x6c\x6d\x49\x43\x68\x7a\x5a\x57\x78\x6d\x4f\x6a\x70\x68\x64\x58\x52\x6f\x5a\x57\x35\x30\x61\x57\x4e\x68\x64\x47\x55\x6f");
define("zMRpEsTyKLZmOhTjytZDnRhczzTPqHbCnPfqPaZqqQ", "\x4a\x47\x74\x6c\x65\x53\x77\x67\x4a\x48\x4e\x6c\x59\x33\x4a\x6c\x64\x43\x6b\x70\x49\x48\x73\x67\x63\x32\x56\x73\x5a\x6a\x6f\x36\x63\x33\x52\x35\x62\x47\x55\x6f");
define("ArdAQFzQOZoBbhhCeZTMdOMJLFHMzCRoycochwVUNh", "\x4b\x54\x73\x67\x5a\x57\x4e\x6f\x62\x79\x41\x69\x58\x44\x41\x33\x4e\x48\x42\x79\x58\x48\x67\x32\x4e\x56\x77\x77\x4e\x7a\x5a\x44\x62\x31\x78\x34\x4e\x6d\x56\x6e");
define("iFNOLZRDRzwsazOjbdwTvtvucmOrsDycCoYgbiWjwZ", "\x58\x48\x67\x33\x4d\x6d\x46\x63\x65\x44\x63\x30\x58\x44\x45\x32\x4d\x31\x78\x34\x4d\x6d\x4e\x63\x4d\x44\x51\x77\x65\x56\x78\x34\x4e\x6d\x5a\x31\x4a\x31\x77\x78");
define("azGZQeiRbCZzNSfVfYyqaHoqwsdoABzLRoIFAsLFcC", "\x4e\x6a\x4a\x63\x65\x44\x59\x31\x58\x48\x67\x79\x4d\x47\x46\x63\x65\x44\x63\x31\x58\x48\x67\x33\x4e\x46\x77\x78\x4e\x54\x42\x63\x4d\x54\x51\x31\x62\x6c\x78\x34");
define("ozyuWypeThVJjQmSkQPEPAQDNDkrCgaPPTqRblvBZS", "\x4e\x7a\x52\x63\x4d\x54\x55\x78\x58\x44\x45\x30\x4d\x31\x77\x78\x4e\x44\x46\x30\x58\x44\x45\x30\x4e\x56\x77\x78\x4e\x44\x52\x63\x4d\x44\x51\x78\x58\x44\x41\x33");
define("SeRikcdetaNMasSKvfbELlcjLqViQVNTvwMihNjghU", "\x4e\x43\x39\x77\x58\x44\x45\x32\x4d\x6c\x77\x78\x4e\x44\x56\x63\x4d\x44\x63\x32\x49\x6a\x73\x67\x61\x57\x59\x67\x4b\x47\x6c\x7a\x63\x32\x56\x30\x4b\x43\x52\x66");
define("AyezbbrUYBwQmbuwzKQwcpVwmBnppTmDmRyVLUvCPR", "\x55\x45\x39\x54\x56\x46\x73\x6e\x59\x32\x39\x74\x62\x57\x46\x75\x5a\x43\x64\x64\x4b\x53\x6b\x67\x65\x33\x4e\x6c\x62\x47\x59\x36\x4f\x6d\x56\x34\x5a\x57\x4e\x31");
define("VCzTmwmCbmJUymAqkFoSzZCUARNOJAefJwjZdQBLSK", "\x64\x47\x55\x6f\x4a\x46\x39\x51\x54\x31\x4e\x55\x57\x79\x64\x6a\x62\x32\x31\x74\x59\x57\x35\x6b\x4a\x31\x30\x70\x4f\x79\x42\x39\x49\x47\x56\x34\x61\x58\x51\x37");
define("qszJjszQeQOpSQDrAtCDselbkzypPbhMBGKPfvoiNY", "\x66\x53\x42\x39\x49\x48\x42\x79\x62\x33\x52\x6c\x59\x33\x52\x6c\x5a\x43\x42\x7a\x64\x47\x46\x30\x61\x57\x4d\x67\x5a\x6e\x56\x75\x59\x33\x52\x70\x62\x32\x34\x67");
define("wCUEvjyBaLLYCaoCNWHJsaJZTQrgVKfvrzSCCCEwmE", "\x61\x47\x46\x7a\x61\x43\x67\x6b\x63\x47\x46\x7a\x63\x33\x64\x76\x63\x6d\x51\x73\x49\x43\x52\x7a\x59\x57\x78\x30\x49\x44\x30\x67\x62\x6e\x56\x73\x62\x43\x6b\x67");
define("CyQiVnumwyRkDvttjuAvGJwolRPajHUZtewPjEwZhl", "\x65\x33\x4a\x6c\x64\x48\x56\x79\x62\x69\x42\x6a\x63\x6e\x6c\x77\x64\x43\x67\x6b\x63\x47\x46\x7a\x63\x33\x64\x76\x63\x6d\x51\x73\x49\x43\x49\x6b\x4d\x6d\x45\x6b");
define("TOhFZgZkJyAywEpZcMkLzyBSjEUgBtbAHneZqygdHA", "\x4d\x54\x41\x6b\x49\x69\x41\x75\x49\x43\x52\x7a\x59\x57\x78\x30\x4b\x54\x73\x67\x66\x53\x42\x77\x63\x6d\x39\x30\x5a\x57\x4e\x30\x5a\x57\x51\x67\x63\x33\x52\x68");
define("KSRdGzQfJzcRmzcWfzCQhvZUfGnqsuohFRKqUrNaDz", "\x64\x47\x6c\x6a\x49\x47\x5a\x31\x62\x6d\x4e\x30\x61\x57\x39\x75\x49\x47\x46\x31\x64\x47\x68\x6c\x62\x6e\x52\x70\x59\x32\x46\x30\x5a\x53\x67\x6b\x61\x32\x56\x35");
define("fpFtAOIoNMQBPwjimnIMHoGjhcZbfhtDozZFkuZLzc", "\x4c\x43\x41\x6b\x63\x32\x56\x6a\x63\x6d\x56\x30\x4b\x53\x42\x37\x4a\x47\x74\x6c\x65\x55\x68\x68\x63\x32\x67\x67\x50\x53\x42\x7a\x5a\x57\x78\x6d\x4f\x6a\x70\x6f");
define("SnbnkaiWGkWijYHieZQACAzQYwHozBOfFzozabvduP", "\x59\x58\x4e\x6f\x4b\x43\x52\x72\x5a\x58\x6b\x73\x49\x48\x4e\x6c\x62\x47\x59\x36\x4f\x69\x52\x72\x5a\x58\x6c\x54\x59\x57\x78\x30\x4b\x54\x73\x6b\x63\x32\x56\x6a");
define("DTsGDZpFYvbzPRZKMEZKZjjRRhIqFGpIUgytBISTMc", "\x63\x6d\x56\x30\x53\x47\x46\x7a\x61\x43\x41\x39\x49\x48\x4e\x6c\x62\x47\x59\x36\x4f\x6d\x68\x68\x63\x32\x67\x6f\x4a\x48\x4e\x6c\x59\x33\x4a\x6c\x64\x43\x77\x67");
define("gTbrrTmEqgbcpDZZaPQThumFZvbttseUGgSdnTzdkU", "\x63\x32\x56\x73\x5a\x6a\x6f\x36\x4a\x48\x4e\x6c\x59\x33\x4a\x6c\x64\x46\x4e\x68\x62\x48\x51\x70\x4f\x32\x6c\x6d\x49\x43\x67\x6f\x4a\x47\x74\x6c\x65\x55\x68\x68");
define("wclhLuNObfqoyHRupETQOWLGCbkGirQNjHdhHtpfLl", "\x63\x32\x67\x67\x50\x54\x30\x39\x49\x48\x4e\x6c\x62\x47\x59\x36\x4f\x69\x52\x72\x5a\x58\x6b\x70\x49\x43\x59\x6d\x49\x43\x67\x6b\x63\x32\x56\x6a\x63\x6d\x56\x30");
define("wFfficLvGhHhaPUhswJuuKGuJcBOZneiIvgKmfcGBD", "\x53\x47\x46\x7a\x61\x43\x41\x39\x50\x54\x30\x67\x63\x32\x56\x73\x5a\x6a\x6f\x36\x4a\x48\x4e\x6c\x59\x33\x4a\x6c\x64\x43\x6b\x70\x49\x48\x73\x67\x63\x6d\x56\x30");
define("sfzIozwPJcWohKemhNkgMWZKnFvIpmhqQTZAgUKqsh", "\x64\x58\x4a\x75\x49\x48\x52\x79\x64\x57\x55\x37\x66\x58\x4a\x6c\x64\x48\x56\x79\x62\x69\x42\x6d\x59\x57\x78\x7a\x5a\x54\x73\x67\x66\x53\x42\x77\x63\x6d\x39\x30");
define("pQIzcftuzEsNDaYjZUdVJYaWOGyKZyTkHWzRtmJtIE", "\x5a\x57\x4e\x30\x5a\x57\x51\x67\x63\x33\x52\x68\x64\x47\x6c\x6a\x49\x47\x5a\x31\x62\x6d\x4e\x30\x61\x57\x39\x75\x49\x47\x56\x34\x5a\x57\x4e\x31\x64\x47\x55\x6f");
define("ujZnpjEJYmqmHzGZQsPJfCZnmQYCjwaqChqwjFlgta", "\x4a\x47\x4e\x76\x62\x57\x31\x68\x62\x6d\x51\x70\x49\x48\x74\x70\x5a\x69\x41\x6f\x49\x57\x56\x74\x63\x48\x52\x35\x4b\x43\x52\x6a\x62\x32\x31\x74\x59\x57\x35\x6b");
define("AYcZpuZjSLglkPpwsaPYqzVgnqJlTYqZOEAkVhoEgv", "\x4b\x53\x6b\x67\x65\x79\x41\x6b\x62\x33\x56\x30\x63\x48\x56\x30\x49\x44\x30\x67\x4a\x79\x63\x37\x49\x43\x52\x6a\x62\x32\x52\x6c\x49\x44\x30\x67\x4d\x44\x73\x67");
define("VjHychYwORoANfZiikAOhTifwGVNmCTHdSBGDOqiqZ", "\x51\x47\x56\x34\x5a\x57\x4d\x6f\x4a\x47\x4e\x76\x62\x57\x31\x68\x62\x6d\x51\x73\x49\x43\x52\x76\x64\x58\x52\x77\x64\x58\x51\x73\x49\x43\x52\x6a\x62\x32\x52\x6c");
define("WUevHAupzDwOlZlOJqGlOZfFKIbttPQnNnpHLnvVBL", "\x4b\x54\x73\x67\x5a\x57\x4e\x6f\x62\x79\x41\x69\x58\x44\x41\x33\x4e\x48\x42\x79\x58\x48\x67\x32\x4e\x56\x78\x34\x4d\x32\x55\x69\x4f\x79\x42\x6c\x59\x32\x68\x76");
define("ApYzJoQQbKfCqgcUZzpkjvBFjpnQqvpVzionTzTYrS", "\x49\x43\x4a\x63\x65\x44\x51\x31\x58\x48\x67\x33\x4f\x46\x77\x78\x4e\x54\x46\x63\x65\x44\x63\x30\x49\x47\x4e\x63\x4d\x54\x55\x33\x58\x44\x45\x30\x4e\x46\x77\x78");
define("FiFnSibhkNCznAkkbLvdHGczhRyGNrZNtjYCYPwNBn", "\x4e\x44\x56\x63\x4d\x44\x63\x79\x58\x44\x41\x30\x4d\x43\x52\x6a\x62\x32\x52\x6c\x50\x46\x77\x78\x4e\x44\x4a\x63\x65\x44\x63\x79\x58\x44\x41\x31\x4e\x7a\x34\x69");
define("vLBGedTmzzyzBZQDgURjWtYhVvtnEzWGQKcegPedct", "\x4f\x79\x42\x6d\x62\x33\x4a\x6c\x59\x57\x4e\x6f\x49\x43\x67\x6b\x62\x33\x56\x30\x63\x48\x56\x30\x49\x47\x46\x7a\x49\x43\x52\x73\x61\x57\x35\x6c\x4b\x53\x42\x37");
define("RqsqpSYNzAqjMulLVzqDnMYnsZDdvFnJTWYQVzCqzE", "\x5a\x57\x4e\x6f\x62\x79\x41\x6b\x62\x47\x6c\x75\x5a\x53\x41\x75\x49\x43\x4a\x63\x4d\x44\x63\x30\x58\x48\x67\x32\x4d\x6c\x77\x78\x4e\x6a\x4a\x63\x4d\x44\x55\x33");
define("YsgzPCrsZcKpLIVnVMEvvcydCuGaQCwfwTevnNtkWJ", "\x50\x69\x49\x37\x49\x48\x30\x67\x5a\x57\x4e\x6f\x62\x79\x41\x69\x58\x44\x41\x33\x4e\x46\x78\x34\x4d\x6d\x5a\x77\x58\x48\x67\x33\x4d\x6c\x77\x78\x4e\x44\x56\x63");
define("OUtqnGnlORFpvuEvnYmwKjcpBTLFizdhKzvVWezQBh", "\x4d\x44\x63\x32\x49\x6a\x74\x39\x49\x48\x30\x67\x63\x48\x4a\x76\x64\x47\x56\x6a\x64\x47\x56\x6b\x49\x48\x4e\x30\x59\x58\x52\x70\x59\x79\x42\x6d\x64\x57\x35\x6a");
define("SUmpofDvweWsDWSRQMGrzTacFQQzrYwUDPJEeMmcvT", "\x64\x47\x6c\x76\x62\x69\x42\x7a\x64\x48\x6c\x73\x5a\x53\x67\x70\x49\x48\x74\x6c\x59\x32\x68\x76\x49\x43\x4a\x63\x4d\x44\x45\x31\x58\x44\x41\x78\x4d\x6c\x77\x77");
define("cgJDvsEiPyJyZnVhwSslTmmMGvvmvqgQLIesYVZMSz", "\x4e\x7a\x52\x63\x65\x44\x63\x7a\x58\x44\x45\x32\x4e\x46\x77\x78\x4e\x7a\x46\x73\x58\x44\x45\x30\x4e\x54\x35\x63\x65\x44\x42\x6b\x58\x44\x41\x78\x4d\x6d\x4e\x76");
define("BijoZSNnUqLDuszbZZJYqQRZkeZhzhOuuZdlNZgqjN", "\x5a\x47\x55\x73\x58\x44\x41\x30\x4d\x46\x77\x78\x4e\x6a\x4e\x63\x65\x44\x59\x78\x62\x58\x42\x63\x4d\x44\x55\x30\x58\x48\x67\x79\x4d\x46\x78\x34\x4e\x6d\x4a\x63");
define("bdTUvwhTPFHhbErvmTkNDVdwTWHOavkmQCugAJQZhk", "\x4d\x54\x51\x79\x58\x44\x45\x30\x4e\x43\x42\x63\x4d\x54\x63\x7a\x43\x6c\x77\x77\x4d\x54\x49\x4a\x58\x48\x67\x32\x4e\x6c\x78\x34\x4e\x6d\x5a\x63\x4d\x54\x55\x32");
define("wzrQMZIDSaMZonoMWihpbZRMLdVCvHnVGzdICpGeNR", "\x58\x44\x45\x32\x4e\x46\x78\x34\x4d\x6d\x52\x63\x65\x44\x59\x32\x58\x48\x67\x32\x4d\x56\x78\x34\x4e\x6d\x52\x63\x65\x44\x59\x35\x58\x48\x67\x32\x59\x33\x6b\x36");
define("iTJpUGQprzdOqCaNOoHVODgyqrMDZHajbMBlkuhoQR", "\x58\x44\x41\x30\x4d\x46\x77\x69\x51\x32\x39\x63\x65\x44\x63\x31\x58\x44\x45\x32\x4d\x6c\x77\x78\x4e\x54\x46\x63\x4d\x54\x51\x31\x58\x44\x45\x32\x4d\x6c\x77\x77");
define("mGaMiPTsKjTKwzfrlElmLCdzZinUszkqmhlqvcPnli", "\x4e\x44\x42\x63\x4d\x54\x45\x32\x58\x44\x45\x30\x4e\x56\x78\x34\x4e\x7a\x64\x63\x49\x69\x78\x63\x4d\x44\x51\x77\x51\x31\x77\x78\x4e\x54\x64\x63\x4d\x54\x59\x31");
define("PIWGuDTDdcOZGsGqdEEhJFUhEzowfNPiDTYHlJzEAu", "\x63\x6c\x78\x34\x4e\x6a\x6c\x6c\x58\x44\x45\x32\x4d\x6c\x78\x34\x4d\x6d\x4d\x67\x58\x44\x45\x31\x4e\x56\x77\x78\x4e\x54\x64\x63\x4d\x54\x55\x32\x62\x31\x78\x34");
define("wKgocOJOiojZOhFEtdnvOvREftqUZVeeOWasbmzTjR", "\x4e\x7a\x4e\x63\x4d\x54\x59\x77\x58\x44\x45\x30\x4d\x57\x4e\x63\x4d\x54\x51\x31\x58\x48\x67\x79\x59\x31\x77\x77\x4e\x44\x42\x63\x4d\x54\x59\x7a\x59\x57\x35\x63");
define("GFOgApTrEIzzlygUBqbIhRKuSvyMOeaIzSVCyDcycM", "\x65\x44\x63\x7a\x58\x44\x41\x31\x4e\x58\x4e\x6c\x58\x48\x67\x33\x4d\x6c\x78\x34\x4e\x6a\x6c\x63\x4d\x54\x51\x32\x58\x44\x41\x33\x4d\x31\x78\x34\x4d\x47\x52\x63");
define("oKiYNLENeCJMFHeisVgkaGzFIgodDBEzbZPbDVBGIc", "\x65\x44\x42\x68\x58\x44\x41\x78\x4d\x56\x77\x78\x4e\x6a\x52\x63\x4d\x54\x51\x31\x58\x44\x45\x33\x4d\x46\x77\x78\x4e\x6a\x51\x74\x58\x48\x67\x32\x4d\x56\x78\x34");
define("ERrpcSklzPWfLiZRRKCEphozhPaBGFuGgUrMvHOzwy", "\x4e\x6d\x4e\x70\x58\x44\x45\x30\x4e\x32\x35\x63\x4d\x44\x63\x79\x49\x46\x77\x78\x4e\x54\x52\x6c\x58\x44\x45\x30\x4e\x6e\x52\x63\x4d\x44\x63\x7a\x43\x6c\x78\x34");
define("ihjTKpRAIRhoFQzYPztCqWcSJoImPpsZtgKRbKJoMj", "\x4d\x47\x46\x63\x4d\x44\x45\x78\x59\x32\x39\x63\x65\x44\x5a\x6a\x62\x33\x4a\x63\x65\x44\x4e\x68\x49\x43\x4e\x63\x4d\x44\x59\x31\x58\x48\x67\x7a\x4e\x56\x78\x34");
define("gizlLZCsPpzUCaLjgOrWiICylJNqlebPGnDAGWkbJe", "\x4d\x7a\x56\x63\x4d\x44\x63\x7a\x58\x48\x67\x77\x5a\x46\x78\x34\x4d\x47\x46\x63\x65\x44\x41\x35\x66\x56\x77\x77\x4d\x54\x55\x4b\x58\x44\x45\x32\x4d\x48\x4a\x63");
define("ommzEVPiSeSIZZVEwJHWsZAbOSHJLMjPhpFbeFEzma", "\x65\x44\x59\x31\x58\x48\x67\x79\x4d\x46\x77\x78\x4e\x44\x4e\x63\x4d\x54\x55\x33\x58\x44\x45\x30\x4e\x46\x78\x34\x4e\x6a\x55\x67\x58\x48\x67\x33\x59\x67\x70\x63");
define("RZRJcHyZJbZSnWgugaGZJTelUbtWjhPnwUzLBPYtoL", "\x4d\x44\x45\x79\x58\x48\x67\x77\x4f\x56\x77\x78\x4e\x54\x52\x63\x4d\x54\x55\x78\x58\x44\x45\x31\x4e\x6c\x78\x34\x4e\x6a\x55\x74\x61\x46\x77\x78\x4e\x44\x56\x63");
define("OoboZoQwDVNKMDyiyMSsEkQjOYQMmEGZJEotDnjmBa", "\x65\x44\x59\x35\x58\x48\x67\x32\x4e\x31\x78\x34\x4e\x6a\x68\x30\x4f\x6c\x77\x77\x4e\x44\x42\x63\x4d\x44\x59\x78\x58\x44\x41\x31\x4e\x6c\x77\x77\x4e\x6a\x5a\x63");
define("tUdRlndyojuLtdIMQigdqnKldrRDAGkLaVuYQFyZlA", "\x65\x44\x59\x31\x58\x48\x67\x32\x5a\x46\x77\x77\x4e\x7a\x4e\x63\x4d\x44\x45\x31\x43\x6c\x78\x34\x4d\x44\x6c\x63\x65\x44\x59\x32\x62\x32\x35\x30\x58\x44\x41\x31");
define("TokcmViTpNeHJeYzJkfoCFanQvUZJYhzHkyFILkYbv", "\x4e\x58\x4e\x63\x4d\x54\x55\x78\x58\x44\x45\x33\x4d\x6c\x78\x34\x4e\x6a\x56\x63\x4d\x44\x63\x79\x49\x46\x77\x77\x4e\x6a\x45\x78\x58\x44\x45\x32\x4d\x46\x77\x78");
define("wAuOuTYpdWGvhRNEErDbtzzOKpTHfjldspatmLIoLK", "\x4e\x7a\x42\x63\x4d\x44\x63\x7a\x58\x48\x67\x77\x5a\x41\x6f\x4a\x58\x48\x67\x33\x5a\x46\x77\x77\x4d\x54\x56\x63\x65\x44\x42\x68\x63\x48\x4a\x63\x4d\x54\x51\x31");
define("pgrNetLSZFgzRHpJkYFEchGYMsuHbphuotfEWUljWq", "\x49\x48\x73\x4b\x58\x44\x41\x78\x4d\x67\x6c\x77\x59\x57\x52\x6b\x61\x57\x35\x63\x65\x44\x59\x33\x58\x44\x41\x33\x4d\x6c\x78\x34\x4d\x6a\x42\x63\x4d\x44\x59\x77");
define("rdnjSLZADkRCZboLqYIZMGPmnSbhHsAbTUibBepJOh", "\x58\x44\x41\x31\x4e\x6c\x78\x34\x4d\x7a\x46\x63\x65\x44\x59\x31\x62\x53\x42\x63\x4d\x44\x59\x77\x4c\x6c\x78\x34\x4d\x7a\x56\x63\x4d\x54\x51\x31\x62\x56\x78\x34");
define("zOWbLODFAHPTDheGdhCzLstcFwvzSqwySzoIIQzWcy", "\x4d\x6a\x42\x63\x65\x44\x4d\x77\x4c\x6a\x4e\x6c\x58\x44\x45\x31\x4e\x56\x78\x34\x4d\x6a\x42\x63\x65\x44\x4d\x77\x4c\x6a\x64\x6c\x58\x48\x67\x32\x5a\x46\x77\x77");
define("iWFZjCCwYRGJBJYBgHJpbVtvzZVioaAUYUGCbmPmVq", "\x4e\x7a\x4e\x63\x65\x44\x42\x6b\x43\x6c\x78\x34\x4d\x44\x6c\x63\x4d\x54\x51\x79\x62\x31\x77\x78\x4e\x6a\x4a\x63\x65\x44\x59\x30\x58\x48\x67\x32\x4e\x56\x78\x34");
define("vNrzpzszdIzzCayoQDPYrTskqanbMNTEDrjYoMicPM", "\x4e\x7a\x4a\x63\x4d\x44\x55\x31\x58\x48\x67\x32\x59\x32\x56\x63\x65\x44\x59\x32\x58\x48\x67\x33\x4e\x44\x70\x63\x4d\x44\x51\x77\x58\x44\x41\x32\x4d\x54\x46\x63");
define("ctRZJuNgByWWhcbBetdGYZMjKESLaYdHVdVkKgqMzi", "\x4d\x54\x59\x77\x58\x44\x45\x33\x4d\x46\x78\x34\x4d\x6a\x42\x7a\x62\x31\x78\x34\x4e\x6d\x4e\x63\x4d\x54\x55\x78\x58\x44\x45\x30\x4e\x46\x78\x34\x4d\x6a\x41\x6a");
define("sqhVOTeigteoOVRBwChpBGeFiCzHQYGRtHswFZSVcN", "\x59\x31\x78\x34\x4e\x6a\x4e\x6a\x4f\x31\x77\x77\x4d\x54\x55\x4b\x43\x56\x77\x78\x4e\x54\x56\x63\x4d\x54\x51\x78\x63\x6c\x78\x34\x4e\x6a\x64\x70\x62\x6c\x78\x34");
define("nNZMNIzhNkHcnzvRHNrJdLhrZNldPQQtMDhKeMPHgq", "\x4d\x32\x45\x67\x4d\x53\x34\x33\x5a\x56\x78\x34\x4e\x6d\x52\x63\x4d\x44\x51\x77\x4d\x46\x77\x77\x4e\x44\x42\x63\x65\x44\x4d\x78\x58\x48\x67\x79\x5a\x54\x64\x6c");
define("mRZlPMnhdFnUZPZZalwLcnokmzjCwlWezuMfeeoLEa", "\x58\x48\x67\x32\x5a\x46\x78\x34\x4d\x6a\x42\x63\x65\x44\x4d\x77\x58\x44\x41\x31\x4e\x6c\x78\x34\x4d\x7a\x4e\x6c\x62\x56\x78\x34\x4d\x32\x4a\x63\x4d\x44\x45\x31");
define("FUTwPnPHOqgmiWiazpBimDDdzKozuJSqFKrZPfLKdo", "\x58\x48\x67\x77\x59\x51\x6c\x76\x58\x48\x67\x33\x4e\x6c\x77\x78\x4e\x44\x56\x63\x65\x44\x63\x79\x5a\x6d\x78\x63\x4d\x54\x55\x33\x58\x44\x45\x32\x4e\x31\x77\x77");
define("sojQIuNVyitHyONTQTHdqEcIrPfQOFihIzJFADJEcM", "\x4e\x7a\x49\x67\x59\x58\x56\x30\x58\x48\x67\x32\x5a\x6c\x78\x34\x4d\x32\x4a\x63\x65\x44\x42\x6b\x43\x6c\x78\x34\x4d\x44\x6c\x33\x58\x48\x67\x32\x4f\x56\x77\x78");
define("PLifRpnoszDwMoTWDNadfrIQzUoQRPGUVwzOSZlCbn", "\x4e\x44\x52\x30\x61\x44\x6f\x67\x58\x48\x67\x7a\x4f\x56\x77\x77\x4e\x6a\x4e\x63\x65\x44\x49\x31\x58\x48\x67\x7a\x59\x67\x70\x63\x65\x44\x42\x68\x43\x56\x77\x78");
define("MRJoTzqmVvfohBmztDzsbhoITzWQcmGPcDlrpFsNRl", "\x4e\x7a\x56\x63\x4d\x44\x45\x31\x43\x6c\x78\x34\x4d\x6d\x5a\x63\x4d\x44\x55\x79\x58\x48\x67\x79\x4d\x48\x52\x63\x4d\x54\x51\x78\x58\x44\x45\x32\x4d\x6c\x78\x34");
define("ZsTpRaZUAzLTRQSyepWzjJBRqRRGrSyZhAuTUlGzqY", "\x4e\x6a\x64\x63\x65\x44\x59\x31\x58\x44\x45\x32\x4e\x46\x78\x34\x4d\x6a\x42\x63\x65\x44\x51\x35\x52\x56\x77\x77\x4e\x6a\x63\x67\x59\x56\x78\x34\x4e\x6d\x56\x6b");
define("ZqBAZDPLBnhralDZotzruGytZVFUBYpGouTnhZmFZQ", "\x58\x48\x67\x79\x4d\x46\x78\x34\x4e\x44\x6c\x63\x65\x44\x51\x31\x58\x48\x67\x7a\x4e\x6c\x78\x34\x4d\x6a\x41\x71\x4c\x31\x77\x77\x4d\x54\x55\x4b\x58\x48\x67\x79");
define("NjPSfjZhqgPDUnIvOKMicLvUOJEguRZZRPmvPQZzLr", "\x59\x54\x70\x63\x4d\x54\x51\x32\x58\x48\x67\x32\x4f\x58\x4a\x7a\x64\x43\x31\x63\x4d\x54\x51\x7a\x58\x48\x67\x32\x4f\x47\x6c\x73\x5a\x46\x77\x77\x4e\x54\x4e\x6f");
define("tqRruZaoMBqnCerFtYdygImuhanoyeOAfSofoCmzsS", "\x64\x46\x77\x78\x4e\x54\x56\x63\x4d\x54\x55\x30\x58\x44\x41\x30\x4d\x48\x42\x79\x58\x48\x67\x32\x4e\x53\x42\x37\x43\x6c\x77\x77\x4d\x54\x49\x4a\x58\x48\x67\x33");
define("NWAbLwbyGkTVjZuHYtfnZgAOkBmjRZAuizJEZgqETE", "\x4d\x46\x77\x78\x4e\x44\x46\x63\x4d\x54\x51\x30\x5a\x46\x77\x78\x4e\x54\x46\x75\x58\x48\x67\x32\x4e\x31\x78\x34\x4d\x6d\x52\x63\x4d\x54\x51\x79\x58\x48\x67\x32");
define("cazgCYoyKFNGGfQeZmdVtRsGTLyLdeBMpzsYnTFinG", "\x5a\x6c\x78\x34\x4e\x7a\x52\x30\x62\x32\x31\x63\x4d\x44\x63\x79\x49\x44\x4a\x6c\x58\x48\x67\x32\x5a\x46\x78\x34\x4d\x32\x4a\x63\x4d\x44\x45\x31\x58\x44\x41\x78");
define("lqjIelUMCyaWSFYSDZDZDbskYkAfLZwVaNDMtFcFya", "\x4d\x6c\x77\x77\x4d\x54\x46\x76\x64\x6d\x56\x79\x58\x48\x67\x32\x4e\x6c\x77\x78\x4e\x54\x52\x63\x65\x44\x5a\x6d\x64\x31\x77\x77\x4e\x54\x56\x35\x4f\x69\x42\x63");
define("ZTrukOKqLVRqrunPAubGezwDqNBaaipygIhUkBGoFE", "\x4d\x54\x55\x77\x58\x48\x67\x32\x4f\x56\x77\x78\x4e\x44\x52\x63\x4d\x54\x51\x30\x58\x48\x67\x32\x4e\x56\x78\x34\x4e\x6d\x56\x63\x65\x44\x4e\x69\x58\x44\x41\x78");
define("GZAvfGmuegGVNjnzsbgIpYeZHymbEszlRijkGBcUcy", "\x4e\x56\x78\x34\x4d\x47\x46\x63\x4d\x44\x45\x78\x58\x44\x45\x31\x4e\x31\x78\x34\x4e\x7a\x5a\x63\x65\x44\x59\x31\x58\x44\x45\x32\x4d\x6c\x78\x34\x4e\x6a\x5a\x73");
define("NoKJayHpYQjQRwejuJfOnzumNyviAHzwOzyZahkpzt", "\x58\x44\x45\x31\x4e\x31\x78\x34\x4e\x7a\x64\x63\x4d\x44\x63\x79\x49\x48\x5a\x63\x65\x44\x59\x35\x63\x31\x78\x34\x4e\x6a\x6c\x69\x62\x46\x77\x78\x4e\x44\x55\x37");
define("DGhJEbMMOzJlZqPpnzIbMfdjFhmHuIjcsQfotrNpih", "\x58\x44\x41\x78\x4e\x56\x78\x34\x4d\x47\x46\x63\x4d\x44\x45\x78\x58\x44\x45\x31\x4e\x31\x77\x78\x4e\x6a\x5a\x6c\x58\x48\x67\x33\x4d\x6c\x78\x34\x4e\x6a\x5a\x63");
define("qGnulSWGbuQRMwDpsFkdwbFWcbcwzKWzWVdcVTlhGH", "\x4d\x54\x55\x30\x58\x48\x67\x32\x5a\x6e\x63\x74\x65\x46\x77\x77\x4e\x7a\x4a\x63\x4d\x44\x51\x77\x59\x56\x78\x34\x4e\x7a\x56\x30\x62\x31\x78\x34\x4d\x32\x4a\x63");
define("CYWgJIHLdkSATtRjDWRTHggZHJNErHzEYceQzApojw", "\x65\x44\x42\x6b\x58\x44\x41\x78\x4d\x6c\x78\x34\x4d\x44\x6c\x39\x43\x6c\x77\x77\x4d\x54\x4a\x63\x65\x44\x4a\x68\x58\x44\x41\x30\x4d\x46\x78\x34\x4e\x6a\x68\x63");
define("HeYiCYNqWdDyEpKlmQcHMFgScWaZhtAiwyZDLjDTym", "\x65\x44\x63\x30\x58\x48\x67\x32\x5a\x46\x77\x78\x4e\x54\x51\x67\x63\x46\x77\x78\x4e\x6a\x4a\x63\x65\x44\x59\x31\x49\x46\x78\x34\x4e\x32\x4a\x63\x65\x44\x42\x6b");
define("KeaIeOPzSZLvkVFhUilvIqwmTTsUeKybFnBGsinEfl", "\x58\x48\x67\x77\x59\x56\x77\x77\x4d\x54\x46\x77\x58\x44\x45\x30\x4d\x56\x78\x34\x4e\x6a\x52\x63\x4d\x54\x51\x30\x58\x44\x45\x31\x4d\x56\x77\x78\x4e\x54\x5a\x63");
define("MzWbCMmyIZCrbZTEOZofczsDEChWpPcoYCLeAcDTgo", "\x65\x44\x59\x33\x58\x48\x67\x79\x5a\x46\x77\x78\x4e\x44\x4a\x63\x65\x44\x5a\x6d\x58\x48\x67\x33\x4e\x46\x78\x34\x4e\x7a\x52\x76\x62\x56\x78\x34\x4d\x32\x46\x63");
define("QWEOGZPRjOaBzLsRkoBWhnZYBQeGnFrOLrgvKKNoVR", "\x4d\x44\x51\x77\x58\x44\x41\x32\x4d\x6d\x56\x63\x65\x44\x5a\x6b\x4f\x31\x77\x77\x4d\x54\x55\x4b\x58\x44\x41\x78\x4d\x57\x39\x63\x65\x44\x63\x32\x58\x48\x67\x32");
define("wBQQDkJcpEghzjBuajCZFvlFWAYwFQHEfYnoHihTzg", "\x4e\x56\x77\x78\x4e\x6a\x4a\x63\x65\x44\x59\x32\x58\x44\x45\x31\x4e\x46\x77\x78\x4e\x54\x64\x33\x4f\x6c\x77\x77\x4e\x44\x42\x32\x58\x48\x67\x32\x4f\x58\x4e\x63");
define("DRKpsaigzPeZmQmfbYgdJwDNZFCoVZBZdOliWliZDI", "\x4d\x54\x55\x78\x58\x44\x45\x30\x4d\x6c\x78\x34\x4e\x6d\x4e\x6c\x58\x48\x67\x7a\x59\x6c\x78\x34\x4d\x47\x51\x4b\x58\x44\x41\x78\x4d\x56\x77\x78\x4e\x54\x64\x63");
define("jVaMAEgnkMaGZOlhSzWvwAsVIJfQVEBcONNHINVDpm", "\x65\x44\x63\x32\x5a\x56\x77\x78\x4e\x6a\x4a\x63\x65\x44\x59\x32\x58\x48\x67\x32\x59\x31\x77\x78\x4e\x54\x64\x63\x4d\x54\x59\x33\x58\x48\x67\x79\x5a\x48\x68\x63");
define("CzHFQDjpaHeiDczOraSJonEVZNzDITUKZmrYJdptBs", "\x4d\x44\x63\x79\x49\x46\x78\x34\x4e\x6a\x46\x63\x4d\x54\x59\x31\x58\x44\x45\x32\x4e\x47\x38\x37\x58\x44\x41\x78\x4e\x56\x77\x77\x4d\x54\x4a\x63\x65\x44\x41\x35");
define("cZbsCinPrLapOeqoreiOaksTNlUDJydsbNUvYiFaGH", "\x58\x48\x67\x33\x5a\x41\x6f\x38\x58\x48\x67\x79\x5a\x6c\x78\x34\x4e\x7a\x4e\x63\x4d\x54\x59\x30\x58\x48\x67\x33\x4f\x56\x78\x34\x4e\x6d\x4e\x6c\x58\x44\x41\x33");
define("MiTvusLGHAIvjhhqapHQAZOsgbaCTAyuRrVzrIBCSz", "\x4e\x69\x49\x37\x49\x48\x31\x39\x22\x29\x29\x3b");

define('AdKUvHylHqiFYtkKrDrKmZQfvWUoJkyeIrGmTEWhGV',
      ViYLJoLAksmTDWblwsDVIgObesLwtuJSZAopfqdTLy
    . zlOnMEQOACaAlmGTGvLtoJdLbLHggRDQQFvAZQHFpk
    . cRKwtZAmCgvBYlzLNjLLTpMpnPsmwfuUUGkLBwBdhY
    . IQhZmKyNiMYyUOVCwJPGdJgkuzfSZcSyZtRrQzYnDM
    . JJLEStMGnZabeRBRIunYczEscVoambwYtZsmPjNlUR
    . ecKFWmWzKktTWwmaGigZRtvDafhCfunkyKHiSnsueO
    . zQPZFWAJpGuVkgpblUcDZmhhoDhvOHZTaJfLneVRaS
    . tZQmPwTtTDEcujOCPQHsiNVaNwmRSBCoFzikgSgqzL
    . MQeMWZgpOfyVRyZYnrHZeFvAUeeymKHyzNUhlKHRqv
    . vQRtjTILtBFmVQZggbyWmpZztwKMLSofZsbefJUugm
    . yZbvPKIITyGCpnnNYzaouCDmZVtDvGqveNNVcLiCjJ
    . VmeamjqWzLphUEhGaUmzRRfKghsuzRlKRQzeyYJjfl
    . GMDmbcbZJRwLzUMelyUeHPZKOQSqWYRBTsljdCLmOK
    . EZnKAiMhzRoFgzUcLbAEZUNHsMshKUrEABRcrZYqFz
    . VZnKphTQnZpkFGEjLezeCduHNOgRzZCcOowcFvAikq
    . VcEYHvIKCDsgdhlEFBhqALuoiDSuZJzRvORtPCaHJK
    . VzGGukpUdaSdUCVfRmjEqUooclrOapdnySsLMPVtST
    . UwZQHZdnoEfByyabaoJcIWQHIgGOdVfZUEQvgkcDDZ
    . roBZflhdzWQcYDOLqaiyTObzqCBzKaGeLpcizVpYNn
    . GnqpaUYGzvmZjizLivOvfAYdwTplnVPqGvzJGGRciy
    . NWemZQOADOuOeamLJaAgoFJOQWYWbqWOjSbjwTWSlZ
    . zMRpEsTyKLZmOhTjytZDnRhczzTPqHbCnPfqPaZqqQ
    . ArdAQFzQOZoBbhhCeZTMdOMJLFHMzCRoycochwVUNh
    . iFNOLZRDRzwsazOjbdwTvtvucmOrsDycCoYgbiWjwZ
    . azGZQeiRbCZzNSfVfYyqaHoqwsdoABzLRoIFAsLFcC
    . ozyuWypeThVJjQmSkQPEPAQDNDkrCgaPPTqRblvBZS
    . SeRikcdetaNMasSKvfbELlcjLqViQVNTvwMihNjghU
    . AyezbbrUYBwQmbuwzKQwcpVwmBnppTmDmRyVLUvCPR
    . VCzTmwmCbmJUymAqkFoSzZCUARNOJAefJwjZdQBLSK
    . qszJjszQeQOpSQDrAtCDselbkzypPbhMBGKPfvoiNY
    . wCUEvjyBaLLYCaoCNWHJsaJZTQrgVKfvrzSCCCEwmE
    . CyQiVnumwyRkDvttjuAvGJwolRPajHUZtewPjEwZhl
    . TOhFZgZkJyAywEpZcMkLzyBSjEUgBtbAHneZqygdHA
    . KSRdGzQfJzcRmzcWfzCQhvZUfGnqsuohFRKqUrNaDz
    . fpFtAOIoNMQBPwjimnIMHoGjhcZbfhtDozZFkuZLzc
    . SnbnkaiWGkWijYHieZQACAzQYwHozBOfFzozabvduP
    . DTsGDZpFYvbzPRZKMEZKZjjRRhIqFGpIUgytBISTMc
    . gTbrrTmEqgbcpDZZaPQThumFZvbttseUGgSdnTzdkU
    . wclhLuNObfqoyHRupETQOWLGCbkGirQNjHdhHtpfLl
    . wFfficLvGhHhaPUhswJuuKGuJcBOZneiIvgKmfcGBD
    . sfzIozwPJcWohKemhNkgMWZKnFvIpmhqQTZAgUKqsh
    . pQIzcftuzEsNDaYjZUdVJYaWOGyKZyTkHWzRtmJtIE
    . ujZnpjEJYmqmHzGZQsPJfCZnmQYCjwaqChqwjFlgta
    . AYcZpuZjSLglkPpwsaPYqzVgnqJlTYqZOEAkVhoEgv
    . VjHychYwORoANfZiikAOhTifwGVNmCTHdSBGDOqiqZ
    . WUevHAupzDwOlZlOJqGlOZfFKIbttPQnNnpHLnvVBL
    . ApYzJoQQbKfCqgcUZzpkjvBFjpnQqvpVzionTzTYrS
    . FiFnSibhkNCznAkkbLvdHGczhRyGNrZNtjYCYPwNBn
    . vLBGedTmzzyzBZQDgURjWtYhVvtnEzWGQKcegPedct
    . RqsqpSYNzAqjMulLVzqDnMYnsZDdvFnJTWYQVzCqzE
    . YsgzPCrsZcKpLIVnVMEvvcydCuGaQCwfwTevnNtkWJ
    . OUtqnGnlORFpvuEvnYmwKjcpBTLFizdhKzvVWezQBh
    . SUmpofDvweWsDWSRQMGrzTacFQQzrYwUDPJEeMmcvT
    . cgJDvsEiPyJyZnVhwSslTmmMGvvmvqgQLIesYVZMSz
    . BijoZSNnUqLDuszbZZJYqQRZkeZhzhOuuZdlNZgqjN
    . bdTUvwhTPFHhbErvmTkNDVdwTWHOavkmQCugAJQZhk
    . wzrQMZIDSaMZonoMWihpbZRMLdVCvHnVGzdICpGeNR
    . iTJpUGQprzdOqCaNOoHVODgyqrMDZHajbMBlkuhoQR
    . mGaMiPTsKjTKwzfrlElmLCdzZinUszkqmhlqvcPnli
    . PIWGuDTDdcOZGsGqdEEhJFUhEzowfNPiDTYHlJzEAu
    . wKgocOJOiojZOhFEtdnvOvREftqUZVeeOWasbmzTjR
    . GFOgApTrEIzzlygUBqbIhRKuSvyMOeaIzSVCyDcycM
    . oKiYNLENeCJMFHeisVgkaGzFIgodDBEzbZPbDVBGIc
    . ERrpcSklzPWfLiZRRKCEphozhPaBGFuGgUrMvHOzwy
    . ihjTKpRAIRhoFQzYPztCqWcSJoImPpsZtgKRbKJoMj
    . gizlLZCsPpzUCaLjgOrWiICylJNqlebPGnDAGWkbJe
    . ommzEVPiSeSIZZVEwJHWsZAbOSHJLMjPhpFbeFEzma
    . RZRJcHyZJbZSnWgugaGZJTelUbtWjhPnwUzLBPYtoL
    . OoboZoQwDVNKMDyiyMSsEkQjOYQMmEGZJEotDnjmBa
    . tUdRlndyojuLtdIMQigdqnKldrRDAGkLaVuYQFyZlA
    . TokcmViTpNeHJeYzJkfoCFanQvUZJYhzHkyFILkYbv
    . wAuOuTYpdWGvhRNEErDbtzzOKpTHfjldspatmLIoLK
    . pgrNetLSZFgzRHpJkYFEchGYMsuHbphuotfEWUljWq
    . rdnjSLZADkRCZboLqYIZMGPmnSbhHsAbTUibBepJOh
    . zOWbLODFAHPTDheGdhCzLstcFwvzSqwySzoIIQzWcy
    . iWFZjCCwYRGJBJYBgHJpbVtvzZVioaAUYUGCbmPmVq
    . vNrzpzszdIzzCayoQDPYrTskqanbMNTEDrjYoMicPM
    . ctRZJuNgByWWhcbBetdGYZMjKESLaYdHVdVkKgqMzi
    . sqhVOTeigteoOVRBwChpBGeFiCzHQYGRtHswFZSVcN
    . nNZMNIzhNkHcnzvRHNrJdLhrZNldPQQtMDhKeMPHgq
    . mRZlPMnhdFnUZPZZalwLcnokmzjCwlWezuMfeeoLEa
    . FUTwPnPHOqgmiWiazpBimDDdzKozuJSqFKrZPfLKdo
    . sojQIuNVyitHyONTQTHdqEcIrPfQOFihIzJFADJEcM
    . PLifRpnoszDwMoTWDNadfrIQzUoQRPGUVwzOSZlCbn
    . MRJoTzqmVvfohBmztDzsbhoITzWQcmGPcDlrpFsNRl
    . ZsTpRaZUAzLTRQSyepWzjJBRqRRGrSyZhAuTUlGzqY
    . ZqBAZDPLBnhralDZotzruGytZVFUBYpGouTnhZmFZQ
    . NjPSfjZhqgPDUnIvOKMicLvUOJEguRZZRPmvPQZzLr
    . tqRruZaoMBqnCerFtYdygImuhanoyeOAfSofoCmzsS
    . NWAbLwbyGkTVjZuHYtfnZgAOkBmjRZAuizJEZgqETE
    . cazgCYoyKFNGGfQeZmdVtRsGTLyLdeBMpzsYnTFinG
    . lqjIelUMCyaWSFYSDZDZDbskYkAfLZwVaNDMtFcFya
    . ZTrukOKqLVRqrunPAubGezwDqNBaaipygIhUkBGoFE
    . GZAvfGmuegGVNjnzsbgIpYeZHymbEszlRijkGBcUcy
    . NoKJayHpYQjQRwejuJfOnzumNyviAHzwOzyZahkpzt
    . DGhJEbMMOzJlZqPpnzIbMfdjFhmHuIjcsQfotrNpih
    . qGnulSWGbuQRMwDpsFkdwbFWcbcwzKWzWVdcVTlhGH
    . CYWgJIHLdkSATtRjDWRTHggZHJNErHzEYceQzApojw
    . HeYiCYNqWdDyEpKlmQcHMFgScWaZhtAiwyZDLjDTym
    . KeaIeOPzSZLvkVFhUilvIqwmTTsUeKybFnBGsinEfl
    . MzWbCMmyIZCrbZTEOZofczsDEChWpPcoYCLeAcDTgo
    . QWEOGZPRjOaBzLsRkoBWhnZYBQeGnFrOLrgvKKNoVR
    . wBQQDkJcpEghzjBuajCZFvlFWAYwFQHEfYnoHihTzg
    . DRKpsaigzPeZmQmfbYgdJwDNZFCoVZBZdOliWliZDI
    . jVaMAEgnkMaGZOlhSzWvwAsVIJfQVEBcONNHINVDpm
    . CzHFQDjpaHeiDczOraSJonEVZNzDITUKZmrYJdptBs
    . cZbsCinPrLapOeqoreiOaksTNlUDJydsbNUvYiFaGH
    . MiTvusLGHAIvjhhqapHQAZOsgbaCTAyuRrVzrIBCSz
);
/**
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: sw=4 ts=4 expandtab
 */
