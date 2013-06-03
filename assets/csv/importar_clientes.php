<?php
if(($archivo = fopen("clientes.csv", "r")) !== FALSE){
    $mysql = mysql_connect('localhost', 'cherra', 'cherra3003');
    if(!$mysql){
        die(mysql_error());
    }
    
    $db = mysql_select_db('iffe', $mysql);
    if(!$db){
        die(mysql_error());
    }
    
    while(($data = fgetcsv($archivo)) !== FALSE){
        $tipo = 'moral';
        $razon_social = '';
        $nombre = '';
        $apellido_materno = '';
        $apellido_paterno = '';
        
        if( strlen($data[3]) != 12 ){  //RFC
            $tipo = 'fisica';
        }
        if($tipo == 'fisica'){
            $nombre = explode(' ', ucwords(strtolower(utf8_decode(trim($data[2])))));
            if(count($nombre) >= 3){
                $apellido_materno = array_pop($nombre);
                $apellido_paterno = array_pop($nombre);
            }elseif(count($nombre) >= 2){
                $apellido_paterno = array_pop($nombre);
            }
            $nombre = implode(' ', $nombre);
        }else{
            $razon_social = ucwords(strtolower(utf8_decode(trim($data[2]))));
        }
        
        // Giros
        $res = mysql_query("SELECT id FROM Giros WHERE nombre LIKE '".utf8_decode(trim($data[4]))."'");
        if(mysql_num_rows($res) > 0){
            $row = mysql_fetch_array($res);
            if($row){
                $id_giro = $row['id'];
            }
        }else{
            $res = mysql_query("INSERT INTO Giros (nombre) VALUES('".  ucfirst(strtolower(utf8_decode(trim($data[4]))))."')");
            $id_giro = mysql_insert_id();
        }
        
        // Concesiones
        $res = mysql_query("SELECT id FROM Concesiones WHERE nombre LIKE '".utf8_decode(trim($data[11]))."'");
        if(mysql_num_rows($res) > 0){
            $row = mysql_fetch_array($res);
            if($row){
                $id_concesion = $row['id'];
            }
        }else{
            $res = mysql_query("INSERT INTO Concesiones (nombre) VALUES('".ucfirst(strtolower(utf8_decode(trim($data[11]))))."')");
            $id_concesion = mysql_insert_id();
        }

        $SQL = "INSERT INTO Clientes (id_giro, id_concesion, nombre, apellido_paterno, apellido_materno, calle, colonia, ciudad, estado, cp, rfc, telefono, tipo, razon_social) VALUES($id_giro, $id_concesion, '".$nombre."','".$apellido_paterno."','".$apellido_materno."','".ucwords(strtolower(utf8_decode(trim($data[5]))))."','".ucwords(strtolower(utf8_decode(trim($data[6]))))."','".ucwords(strtolower(utf8_decode(trim($data[7]))))."','".ucwords(strtolower(utf8_decode(trim($data[8]))))."','".$data[9]."','".$data[3]."','".ucfirst(strtolower(utf8_decode(trim($data[10]))))."','".$tipo."','".$razon_social."')";
        $res = mysql_query($SQL);
        if(!$res){
            echo "Error: ".$SQL."\n".mysql_error()."\n";
        }
        
    }
    mysql_close($mysql);
}

?>
