<?php
class accesos_MO
{
    private $conexion;
    
    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function iniciarSesion($usuario,$clave)
    {
        $sql="SELECT estu_id FROM accesos WHERE acce_usuario='$usuario' AND acce_clave='$clave'";
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }
}
?>