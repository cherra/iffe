<?php
if(($archivo = fopen("calles.csv", "r")) !== FALSE){
    $mysql = mysql_connect('localhost', 'cherra', 'cherra3003');
    if(!$mysql){
        die(mysql_error());
    }
    
    $db = mysql_select_db('iffe', $mysql);
    if(!$db){
        die(mysql_error());
    }
    
    while(($data = fgetcsv($archivo)) !== FALSE){
        $res = mysql_query("INSERT INTO Calles (nombre, precio_base) VALUES('".utf8_decode($data[2])."',".$data[5].")");
        if($res){
            $id_calle = mysql_insert_id();
            $categoria = ($data[4] == 'Modulos' ? 'modulo' : ($data[4] == 'Metros' ? 'metro' : 'local'));
            for($i=1; $i <= $data[3]; $i++){
                $res = mysql_query("INSERT INTO Modulos (id_calle, numero, categoria, precio) VALUES($id_calle, '".$i."', '".$categoria."', ".$data[5].")");
                if(!$res){
                    echo "Error al insertar el módulo: ".mysql_error()."\n";
                }
            }
        }else{
            echo "Error: ".mysql_error()."\n";
        }
        
    }
    mysql_close($mysql);
}

?>
