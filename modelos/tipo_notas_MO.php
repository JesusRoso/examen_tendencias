<?php
class tipo_notas_MO
{
    private $conexion;
    
    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function seleccionar($tino_id='')
    {
        if($tino_id)
        {
            $sql="SELECT * FROM tipo_notas WHERE tino_id='$tino_id'";
        }
        else
        {
            $sql="SELECT * FROM tipo_notas";
        }
        
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }
    function seleccionarNombre($tino_nombre)
    {
        $sql="SELECT * FROM tipo_notas WHERE tino_nombre='$tino_nombre'";
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }
    function agregar($tino_nombre)
    {
        $sql="INSERT INTO tipo_notas (tino_nombre) 
        VALUES ('$tino_nombre')";
        $this->conexion->consultar($sql);
    }
    function actualizarTipoNotas($tino_id,$tino_nombre)
    {
        $sql="UPDATE tipo_notas SET tino_nombre='$tino_nombre' WHERE tino_id='$tino_id'";
        $this->conexion->consultar($sql);
    }
}
?>