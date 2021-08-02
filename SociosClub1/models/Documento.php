<?php
    class Documento extends Conectar{
        public function insert_documento($idSocio,$doc_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="INSERT INTO td_documento (doc_id,idSocio,doc_nom,fech_crea,est) VALUES (null,?,?,now(),1);";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$idSocio);
            $sql->bindParam(2,$doc_nom);
            $sql->execute();
        }

        public function get_documento_x_Socio($idSocio){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM td_documento WHERE idSocio=?";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$idSocio);
            $sql->execute();
            return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
        }
    }
?>