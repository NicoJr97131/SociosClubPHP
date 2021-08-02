<?php
    require_once("../config/conexion.php");
    require_once("../models/Deporte.php");
    $deporte = new Deporte();

    switch($_GET["op"]){
        case "combo":
            $datos = $deporte->get_deporte();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['idDeporte']."'>".$row['nombreDeporte']."</option>";
                }
                echo $html;
            }
        break;
    }
?>