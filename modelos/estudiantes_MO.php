<?php
class estudiantes_MO
{
    private $conexion;
    
    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function seleccionar($estu_id='')
    {
        if($estu_id)
        {
            $sql="SELECT * FROM estudiantes WHERE estu_id='$estu_id'";
        }
        else
        {
            $sql="SELECT * FROM estudiantes";
        }
        
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }
    function seleccionarDocumento($estu_documento)
    {
        $sql="SELECT * FROM estudiantes WHERE estu_documento='$estu_documento'";
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }
    function agregar($estu_nombres,$estu_apellidos,$estu_documento)
    {
        $sql="INSERT INTO estudiantes (estu_nombres,estu_apellidos,estu_documento) 
        VALUES ('$estu_nombres','$estu_apellidos','$estu_documento')";
        $this->conexion->consultar($sql);
    }
    function actualizarEstudiantes($estu_id,$estu_nombres,$estu_apellidos)
    {
        $sql="UPDATE estudiantes SET estu_nombres='$estu_nombres', estu_apellidos='$estu_apellidos' WHERE estu_id='$estu_id'";
        $this->conexion->consultar($sql);
    }
}
?>