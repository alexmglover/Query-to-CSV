<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package     ExpressionEngine
 * @author      ExpressionEngine Dev Team
 * @copyright   Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license     http://expressionengine.com/user_guide/license.html
 * @link        http://expressionengine.com
 * @since       Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Query to CSV Plugin
 *
 * @package     ExpressionEngine
 * @subpackage  Addons
 * @category    Plugin
 * @author      Alex Glover
 * @link        http://eecoder.com
 */

$plugin_info = array(
    'pi_name'       => 'Query to CSV',
    'pi_version'    => '1.0',
    'pi_author'     => 'Alex Glover',
    'pi_author_url' => 'http://eecoder.com',
    'pi_description'=> 'Exports query results to CSV',
    'pi_usage'      => Query_to_csv::usage()
);


class Query_to_csv {

    public $return_data;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->EE =& get_instance();

        // load libraries/helpers
        $this->EE->load->dbtil();
        $this->EE->load->helper('download');

        // get parameters
        $query = $this->EE->TMPL->fetch_param('query');
        $filename = ($this->EE->TMPL->fetch_param('filename') != "") ? $this->EE->TMPL->fetch_param('filename') : 'filename.csv';
        $delimiter = ($this->EE->TMPL->fetch_param('delimiter') != "") ? $this->EE->TMPL->fetch_param('delimiter') : ',';

        // run query
        $results = $this->EE->db->query($query);

        // convert to csv
        $this->EE->dbutil->csv_from_result($results, $delimiter);

        // download csv
        force_download($filename, $csv);        
        
        exit(); 

    }
    
    // ----------------------------------------------------------------
    
    /**
     * Plugin Usage
     */
    public static function usage()
    {
        ob_start();
?>

{exp:query_to_csv query="SELECT * FROM exp_channel_data" filename="filename.csv" delimiter="|"}


<?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
}


/* End of file pi.query_to_csv.php */
/* Location: /system/expressionengine/third_party/query_to_csv/pi.query_to_csv.php */