<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Rangos
 *
 * @author cherra
 */
class Rango {
    
    // Convierte un array de numeros a una cadena en forma de rango.
    // ej. array(1,2,3,4,7,9,10,11) => '1-4,7,9-11'
    public function array_to_rango( $rango = array() ){
        if(!empty($rango)){
            $primero = $ultimo = null;
            $output = array();

            foreach ($rango as $item) {
                if ($primero === null) {
                    $primero = $ultimo = $item;
                } else if ($ultimo < $item - 1) {
                    $output[] = $primero == $ultimo ? $primero : $primero . '-' . $ultimo;
                    $primero = $ultimo = $item;
                } else {
                    $ultimo = $item;
                }
            }

            $output[] = $primero == $ultimo ? $primero : $primero . '-' . $ultimo;
            return implode(', ', $output);
        }else{
            return false;
        }
    }
    
    // Convierte una cadena en forma de rango a un array con valores individuales
    // ej. '1-4,7,9-11' => array(1,2,3,4,7,9,10,11)
    public function rango_to_array( $rango = '' ){
        if(!empty($rango)){
            $primero = $ultimo = null;
            $input = explode(',', $rango);
            $output = array();
            foreach($input as $item){
                if(($posicion = strpos($item, '-'))){
                    $primero = (int)strstr($item, '-', true);
                    $ultimo = (int)substr($item, $posicion+1);
                    $output = array_merge($output, range($primero, $ultimo));
                    //$cadena = $output;
                }else{
                    $primero = $ultimo = $item;
                    $output[] = (int)$primero;
                }
                
            }
            return $output;
        }else{
            return false;
        }
    }
}

?>
