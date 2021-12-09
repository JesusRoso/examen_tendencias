<?php
class estudiantes_asignaturas_MO
{
    private $conexion;
    
    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function seleccionar($esasig_id='')
    {
        if($esasig_id)
        {
            $sql="SELECT * FROM estudiantes_asignaturas WHERE esasig_id ='$esasig_id'";
        }
        else
        {
            $sql="SELECT ea.esasig_id, e.estu_nombres, e.estu_documento, a.asig_nombre, t.tino_nombre, ea.valor_nota 
            FROM estudiantes_asignaturas ea INNER JOIN asignaturas a ON (ea.asig_id=a.asig_id) 
            INNER join estudiantes e ON (ea.estu_id=e.estu_id) INNER JOIN tipo_notas t ON (ea.tino_id=t.tino_id)";
        }
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }
    function seleccionarExiste()
    {
        $sql="SELECT * FROM estudiantes_asignaturas";
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }
    function seleccionarDocumento($estu_id)
    {
        $sql="SELECT * FROM estudiantes WHERE estu_id='$estu_id'";
        $this->conexion->consultar($sql);
        return $this->conexion->extraerRegistro();
    }
    function agregar($estu_id,$asig_id,$tino_id,$valor_nota)
    {
        $sql="INSERT INTO estudiantes_asignaturas (estu_id,asig_id,tino_id,valor_nota) 
        VALUES ('$estu_id','$asig_id','$tino_id','$valor_nota')";
        $this->conexion->consultar($sql);
    }
    function actualizarEstudiantesAsignaturas($esasig_id,$valor_nota)
    {
        $sql="UPDATE estudiantes_asignaturas SET valor_nota='$valor_nota' WHERE esasig_id='$esasig_id'";
        $this->conexion->consultar($sql);
    }
}
?>