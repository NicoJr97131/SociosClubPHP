<?php
    require_once("../config/conexion.php");
    require_once("../models/Socio.php");
    $socio = new Socio();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    require_once("../models/Documento.php");
    $documento = new Documento();

    switch($_GET["op"]){

        case "insert":
            $datos=$socio->insert_socio($_POST["usu_id"],$_POST["idDeporte"],$_POST["nombreSocio"],$_POST["descripcionSocio"]);
            if (is_array($datos)==true and count($datos)>0){
                foreach ($datos as $row){
                    $output["idSocio"] = $row["idSocio"];

                    if ($_FILES['files']['name']==0){

                    }else{
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = "../public/document/".$output["idSocio"]."/";
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']['name'][$index];

                            $documento->insert_documento( $output["idSocio"],$_FILES['files']['name'][$index]);

                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo json_encode($datos);
        break;

        case "update":
            $socio->update_socio($_POST["idSocio"]);
            $socio->insert_ticketdetalle_cerrar($_POST["idSocio"],$_POST["usu_id"]);
        break;

        case "asignar":
            $socio->update_socio_asignacion($_POST["idSocio"],$_POST["usu_asig"]);
        break;

        case "listar_x_usu":
            $datos=$socio->listar_socio_x_usu($_POST["usu_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["idSocio"];
                $sub_array[] = $row["nombreDeporte"];
                $sub_array[] = $row["nombreSocio"];

                if ($row["estadoSocio"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-warning">Sin Asignar</span>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["idSocio"].');"  id="'.$row["idSocio"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listar":
            $datos=$socio->listar_socio();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["idSocio"];
                $sub_array[] = $row["nombreDeporte"];
                $sub_array[] = $row["nombreSocio"];

                if ($row["estadoSocio"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<a onClick="asignar('.$row["idSocio"].');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["idSocio"].');"  id="'.$row["idSocio"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listardetalle":
            $datos=$socio->listar_sociodetalle_x_ticket($_POST["idSocio"]);
            ?>
                <?php
                    foreach($datos as $row){
                        ?>
                            <article class="activity-line-item box-typical">
                                <div class="activity-line-date">
                                    <?php echo date("d/m/Y", strtotime($row["fech_crea"]));?>
                                </div>
                                <header class="activity-line-item-header">
                                    <div class="activity-line-item-user">
                                        <div class="activity-line-item-user-photo">
                                            <a href="#">
                                                <img src="../../public/<?php echo $row['rol_id'] ?>.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-line-item-user-name"><?php echo $row['usu_nom'].' '.$row['usu_ape'];?></div>
                                        <div class="activity-line-item-user-status">
                                            <?php 
                                                if ($row['rol_id']==1){
                                                    echo 'Usuario';
                                                }else{
                                                    echo 'Soporte';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </header>
                                <div class="activity-line-action-list">
                                    <section class="activity-line-action">
                                        <div class="time"><?php echo date("H:i:s", strtotime($row["fech_crea"]));?></div>
                                        <div class="cont">
                                            <div class="cont-in">
                                                <p>
                                                    <?php echo $row["descripcionSocio"];?>
                                                </p>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </article>
                        <?php
                    }
                ?>
            <?php
        break;

        case "mostrar";
            $datos=$socio->listar_socio_x_id($_POST["idSocio"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["idSocio"] = $row["idSocio"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["idDeporte"] = $row["idDeporte"];

                    $output["nombreSocio"] = $row["nombreSocio"];
                    $output["descripcionSocio"] = $row["descripcionSocio"];

                    if ($row["estadoSocio"]=="Abierto"){
                        $output["estadoSocio"] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $output["estadoSocio"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["socio_estado_texto"] = $row["estadoSocio"];

                    $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["nombreDeporte"] = $row["nombreDeporte"];
                }
                echo json_encode($output);
            }   
        break;

        case "insertdetalle":
            $socio->insert_ticketdetalle($_POST["idSocio"],$_POST["usu_id"],$_POST["descripcionSocio"]);
        break;

        case "total";
            $datos=$socio->get_socio_total();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalabierto";
            $datos=$socio->get_socio_totalabierto();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "totalcerrado";
            $datos=$socio->get_socio_totalcerrado();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
        break;

        case "grafico";
            $datos=$socio->get_socio_grafico();  
            echo json_encode($datos);
        break;

    }
?>