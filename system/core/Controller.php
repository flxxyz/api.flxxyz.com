<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    CodeIgniter
 * @author    EllisLab Dev Team
 * @copyright    Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright    Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link    https://codeigniter.com
 * @since    Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Libraries
 * @author        EllisLab Dev Team
 * @link        https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller
{

    /**
     * Reference to the CI singleton
     *
     * @var    object
     */
    private static $instance;

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct()
    {
        self::$instance =& $this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach ( is_loaded() as $var => $class ) {
            $this->$var =& load_class($class);
        }

        $this->load =& load_class('Loader', 'core');
        $this->load->initialize();
        $this->load->helper('url');
        ini_set('date.timezone', 'PRC');
        //date_default_timezone_set('PRC');
        log_message('info', 'Controller Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * Get the CI singleton
     *
     * @static
     * @return    object
     */
    public static function &get_instance()
    {
        return self::$instance;
    }

    /**
     * Return Data Structure (json/xml)
     *
     * @param array  $data
     * @param string $encode
     *
     * @return string
     */
    public function dataStructure($data = [], $encode = 'json')
    {
        if ( $encode == 'xml' ) {
            $keys1 = array_keys($data);

            $str = '<?xml version="1.0" encoding="utf-8"?><DATA>';
            $m = 0;
            foreach ( $keys1 as $v1 ) {
                if ( is_array($data[$v1]) ) {
                    $keys2 = array_keys($data[$v1]);
                    $str .= "<$v1>";
                    foreach ( $keys2 as $v2 ) {
                        $str .= "<$v2>" . $data[$v1][$v2] . "</$v2>";
                    }
                    $str .= "</$keys1[$m]>";
                } else
                    $str .= "<$v1>$data[$v1]</$v1>";
                $m++;
            }
            $str .= '</DATA>';

            //echo '<pre>';
            header("content-type:application/xml;charset:utf-8");
            return $str;
        } else {
            header("content-type:application/json;charset:utf-8");
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

}
