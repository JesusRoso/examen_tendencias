<?php
class asignaturas_MO
{
    private $conexion;
    
    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function seleccionar($asig_id='')
    {
        if($asig_id)
        {
            $sql="SELECT * FROM asignaturas WHERE asig_id='$asig_id'";
        }
        else
        {
            $sql="SELECT * FROM asignaturas";
        }
        
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }


    function seleccionarNombreAsignatura($asig_nombre)
    {
        $sql="SELECT * FROM asignaturas WHERE asig_nombre='$asig_nombre'";
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }

    
    function agregar($asig_nombre,$asig_descripcion)
    {
        $sql="INSERT INTO asignaturas (asig_nombre,asig_descripcion) 
        VALUES ('$asig_nombre','$asig_descripcion')";
        $this->conexion->consultar($sql);
    }
    
    function actualizarAsignaturas($asig_id,$asig_nombre,$asig_descripcion)
    {
        $sql="UPDATE asignaturas SET asig_nombre='$asig_nombre', asig_descripcion='$asig_descripcion' WHERE asig_id='$asig_id'";
        $this->conexion->consultar($sql);
    }
}
?>