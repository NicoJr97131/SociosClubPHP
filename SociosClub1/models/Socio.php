<?php
    class Socio extends Conectar{

        public function insert_socio($usu_id,$idDeporte,$nombreSocio,$descripcionSocio){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO socio (idSocio,usu_id,idDeporte,nombreSocio,descripcionSocio,estadoSocio,fech_crea,usu_asig,fech_asig,est) VALUES (NULL,?,?,?,?,'Abierto',now(),NULL,NULL,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $idDeporte);
            $sql->bindValue(3, $nombreSocio);
            $sql->bindValue(4, $descripcionSocio);
            $sql->execute();

            $sql1="select last_insert_id() as 'idSocio';";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        public function listar_socio_x_usu($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                socio.idSocio,
                socio.usu_id,
                socio.idDeporte,
                socio.nombreSocio,
                socio.descripcionSocio,
                socio.estadoSocio,
                socio.fech_crea,
                socio.usu_asig,
                socio.fech_asig,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                deporte.nombreDeporte
                FROM 
                socio
                INNER join deporte on socio.idDeporte = deporte.idDeporte
                INNER join tm_usuario on socio.usu_id = tm_usuario.usu_id
                WHERE
                socio.est = 1
                AND tm_usuario.usu_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_socio_x_id($idSocio){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                socio.idSocio,
                socio.usu_id,
                socio.idDeporte,
                socio.nombreSocio,
                socio.descripcionSocio,
                socio.estadoSocio,
                socio.fech_crea,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                deporte.nombreDeporte
                FROM 
                socio
                INNER join deporte on socio.idDeporte = deporte.idDeporte
                INNER join tm_usuario on socio.usu_id = tm_usuario.usu_id
                WHERE
                socio.est = 1
                AND socio.idSocio = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idSocio);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_socio(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                socio.idSocio,
                socio.usu_id,
                socio.idDeporte,
                socio.nombreSocio,
                socio.descripcionSocio,
                socio.estadoSocio,
                socio.fech_crea,
                socio.usu_asig,
                socio.fech_asig,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                deporte.nombreDeporte
                FROM 
                socio
                INNER join deporte on socio.idDeporte = deporte.idDeporte
                INNER join tm_usuario on socio.usu_id = tm_usuario.usu_id
                WHERE
                socio.est = 1
                ";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_sociodetalle_x_ticket($idSocio){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                td_ticketdetalle.tickd_id,
                td_ticketdetalle.tickd_descrip,
                td_ticketdetalle.fech_crea,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.rol_id
                FROM 
                td_ticketdetalle
                INNER join tm_usuario on td_ticketdetalle.usu_id = tm_usuario.usu_id
                WHERE 
                idSocio =?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idSocio);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticketdetalle($idSocio,$usu_id,$tickd_descrip){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="INSERT INTO td_ticketdetalle (tickd_id,idSocio,usu_id,tickd_descrip,fech_crea,est) VALUES (NULL,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idSocio);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $tickd_descrip);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticketdetalle_cerrar($idSocio,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="call sp_i_ticketdetalle_01(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idSocio);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_socio($idSocio){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="update socio
                set	
                    estadoSocio = 'Cerrado'
                where
                    idSocio = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idSocio);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_socio_asignacion($idSocio,$usu_asig){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="update socio 
                set	
                    usu_asig = ?,
                    fech_asig = now()
                where
                    idSocio = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->bindValue(2, $idSocio);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_socio_total(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM socio";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_socio_totalabierto(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM socio where estadoSocio='Abierto'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_socio_totalcerrado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM socio where estadoSocio='Cerrado'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function get_socio_grafico(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT deporte.nombreDeporte as nom,COUNT(*) AS total
                FROM   socio  JOIN  
                    deporte ON socio.idDeporte = deporte.idDeporte  
                WHERE    
                socio.est = 1
                GROUP BY 
                deporte.nombreDeporte 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

    }
?>