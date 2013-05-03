<?php

/*
|--------------------------------------------------------------------------
| asset_url()
|--------------------------------------------------------------------------
|
| Genera una instancia del objeto $CI para obtener el valor la propiedad 'asset_path'
| del archivo config.php
|
*/
if (!function_exists('asset_url'))
{   
    function asset_url()
    {
        $CI =& get_instance();
		return base_url() . $CI->config->item('asset_path');
    }
}

?>