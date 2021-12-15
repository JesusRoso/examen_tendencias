<?php
require_once "modelos/estudiantes_asignaturas_MO.php";
require_once "modelos/estudiantes_MO.php";

class estudiantes_asignaturas_CO
{
    function __construct(){}

    function agregar()
    {
        $conexion=new conexion('all');
        
        $estudiantes_asignaturas_MO=new estudiantes_asignaturas_MO($conexion);

        /*Saber si los campos están vacíos y manejo de carácteres*/
        $estu_id=strtoupper(htmlentities($_POST['estu_id'],ENT_QUOTES));
        $asig_id=strtoupper(htmlentities($_POST['asig_id'],ENT_QUOTES));
        $tino_id=strtoupper(htmlentities($_POST['tino_id'],ENT_QUOTES));
        $valor_nota=strtoupper(htmlentities($_POST['valor_nota'],ENT_QUOTES));
        $arreglo_datos = ['Estudiante'=>$estu_id,'Asignatura'=>$asig_id,'Tipo de nota'=>$tino_id,'Calificaci&oacute;n'=>$valor_nota];
        foreach($arreglo_datos as $indices=>$objeto_datos)
        {
            if(empty($objeto_datos))
            {
                $arreglo_respuesta = [
                    "estado"=>"ERROR",
                    "mensaje"=>"Se debe llenar o seleccionar el campo $indices"
                ];
                exit(json_encode($arreglo_respuesta));
            }
        } 
        /*Fin saber si los campos están vacíos y manejo de carácteres*/


        /*Saber si se supera número de carácteres*/
        $size_valor_nota=strlen($valor_nota);
        if($size_valor_nota>3)
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"Se excedi&oacute; la cantidad de car&aacute;cteres en el campo de Calificaci&oacute;n"
            ];
             exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber se supera número de carácteres*/

        /*Saber si la nota está en los rangos establecidos*/
        if($valor_nota<0 || $valor_nota>5)
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"Nota fuera de los rangos permitidos (0-5)"
            ];
             exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber si la nota está en los rangos establecidos*/

        /*Saber si el registro ya existe */
        $arreglo_estudiantes_asignaturas=$estudiantes_asignaturas_MO->seleccionarExiste();
        foreach($arreglo_estudiantes_asignaturas as $objeto_estudiantes_asignaturas)
        {
            $estu_id_exist=$objeto_estudiantes_asignaturas->estu_id;
            $asig_id_exist=$objeto_estudiantes_asignaturas->asig_id;
            $tino_id_exist=$objeto_estudiantes_asignaturas->tino_id;
            if($estu_id==$estu_id_exist && $asig_id==$asig_id_exist && $tino_id==$tino_id_exist)
            {
                $arreglo_respuesta = [
                    "estado"=>"ERROR",
                    "mensaje"=>"El registro que intenta agregar ya existe"
                ];
                exit(json_encode($arreglo_respuesta));
            }
        }
        /*Fin saber si el registro ya existe */

        $estudiantes_asignaturas_MO->agregar($estu_id,$asig_id,$tino_id,$valor_nota);
        
        $arreglo_estudiantes=$estudiantes_asignaturas_MO->seleccionarDocumento($estu_id);
        foreach($arreglo_estudiantes as $objeto_estudiantes){
            $estu_documento=$objeto_estudiantes->estu_documento;
        }

        $esasig_id=$conexion->lastInsertId();

        $arreglo_respuesta = [
            "estado"=>"EXITO",
            "mensaje"=>"Registro Agregado",
            "esasig_id"=>$esasig_id,
            "estu_documento"=>$estu_documento
        ];

        echo json_encode($arreglo_respuesta);
    }

    function actualizarEstudiantesAsignaturas()
    {
        $conexion=new conexion('all');
        
        $estudiantes_asignaturas_MO=new estudiantes_asignaturas_MO($conexion);

        /*Saber si el dato esasig_id es numérico*/
        $esasig_id=$_POST['esasig_id'];
        if(!is_numeric($esasig_id))
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"El identificador no es un n&uacute;mero entero"
            ];
    
            exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber si el dato esasig_id es numérico*/

        /*Saber si los campos están vacíos y manejo de carácteres*/
        $valor_nota=strtoupper(htmlentities($_POST['valor_nota'],ENT_QUOTES));
        if(empty($valor_nota))
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"Se debe llenar el campo de Calificaci&oacute;n"
            ];
            exit(json_encode($arreglo_respuesta));
        } 
        /*Fin saber si los campos están vacíos y manejo de carácteres*/

        /*Saber si se supera número de carácteres*/
        $size_valor_nota=strlen($valor_nota);
        if($size_valor_nota>3)
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"Se excedi&oacute; la cantidad de car&aacute;cteres en el campo de Calificaci&oacute;n"
            ];
             exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber se supera número de carácteres*/

        /*Saber si la nota está en los rangos establecidos*/
        if($valor_nota<0 || $valor_nota>5)
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"Nota fuera de los rangos permitidos (0-5)"
            ];
             exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber si la nota está en los rangos establecidos*/

        $estudiantes_asignaturas_MO->actualizarEstudiantesAsignaturas($esasig_id,$valor_nota);

        $arreglo_respuesta = [
            "estado"=>"EXITO",
            "mensaje"=>"Registro Actualizado"
        ];

        echo json_encode($arreglo_respuesta);
    }
}
?>