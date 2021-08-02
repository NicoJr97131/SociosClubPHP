<?php
    class Deporte extends Conectar{

        public function get_deporte(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM deporte WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>