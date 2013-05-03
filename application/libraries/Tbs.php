<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Tbs
 *
 * @author cherra
 */
require_once("tbs/tbs_class.php");
//require_once("tbs/plugins/tbs_plugin_opentbs.php"); //Plugin para office documents

class Tbs extends clsTinyButStrong {
    
    function __construct($Options = null, $VarPrefix = '', $FctPrefix = '') {
        parent::__construct($Options, $VarPrefix, $FctPrefix);
    }
}

?>
