<?php

class Login{

        private $usuario;
        private $contrasena;
        

        public function __construct($usuario,$contrasena){
                $this->usuario = $usuario;
                $this->contrasena = $contrasena;
                
        }

    public  function loguear(){

        $conexion=mysqli_connect("localhost","root","","erp");
        
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        //utilizamos consultas preparas para no ser vulnerable a inyeccion sql
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?";
        $statement = $conexion->prepare($consulta);
        $statement->bind_param("ss", $usuario, $contrasena);
        $statement->execute();
        $resultado = $statement->get_result();

        if ($resultado->num_rows > 0) {
            $filas = $resultado->fetch_assoc();
            if ($filas['id_usuario'] == 1 || $filas['id_usuario'] == 2) {
                $response['succes'] = true;
                die(json_encode($response));
            }
        } else {
            $response['succes'] = false;
            die(json_encode($response));
        }

        $statement->close();

    } 
    

}

?>