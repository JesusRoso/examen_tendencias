<?php
require_once "modelos/estudiantes_MO.php";

class estudiantes_CO
{
    function __construct(){}

    function agregar()
    {
        $conexion=new conexion('all');
        
        $estudiantes_MO=new estudiantes_MO($conexion);

        /*Saber si los campos están vacíos y manejo de carácteres*/
        $estu_nombres=strtoupper(htmlentities($_POST['estu_nombres'],ENT_QUOTES));
        $estu_apellidos=strtoupper(htmlentities($_POST['estu_apellidos'],ENT_QUOTES));
        $estu_documento=strtoupper(htmlentities($_POST['estu_documento'],ENT_QUOTES));
        $arreglo_datos = ['nombres'=>$estu_nombres,'apellidos'=>$estu_apellidos,'documento'=>$estu_documento];
        foreach($arreglo_datos as $indices=>$objeto_datos)
        {
            if(empty($objeto_datos))
            {
                $arreglo_respuesta = [
                    "estado"=>"ERROR",
                    "mensaje"=>"Se debe llenar el campo $indices"
                ];
                exit(json_encode($arreglo_respuesta));
            }
        } 
        /*Fin saber si los campos están vacíos y manejo de carácteres*/

        /*Saber si se supera número de carácteres*/
        $size_estu_nombres=strlen($estu_nombres);
        $size_estu_apellidos=strlen($estu_apellidos);
        $size_estu_documento=strlen($estu_documento);
        $arreglo_size_datos=['nombres'=>$size_estu_nombres,'apellidos'=>$size_estu_apellidos,'documento'=>$size_estu_documento];
        foreach($arreglo_size_datos as $indices_size_datos=>$objetos_size_datos)
        {
            if($objetos_size_datos>45 || ($indices_size_datos=='documento' && $objetos_size_datos>15))
            {
                $arreglo_respuesta = [
                    "estado"=>"ERROR",
                    "mensaje"=>"Se excedi&oacute; la cantidad de car&aacute;cteres en el campo de $indices_size_datos"
                ];
        
                exit(json_encode($arreglo_respuesta));
            }
        }
        /*Fin saber se supera número de carácteres*/

        /*Saber si está duplicado el documento*/
        $arreglo_estudiantes=$estudiantes_MO->seleccionarDocumento($estu_documento);
        if($arreglo_estudiantes)
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"El documento $estu_documento est&aacute; duplicado"
            ];
            exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber si está duplicado el documento*/

        $estudiantes_MO->agregar($estu_nombres,$estu_apellidos,$estu_documento);

        $estu_id=$conexion->lastInsertId();

        $arreglo_respuesta = [
            "estado"=>"EXITO",
            "mensaje"=>"Registro Agregado",
            "estu_id"=>$estu_id
        ];

        echo json_encode($arreglo_respuesta);
    }

    function actualizarEstudiantes()
    {
        $conexion=new conexion('all');
        $estudiantes_MO=new estudiantes_MO($conexion);

        /*Saber si el dato estu_id es numérico*/
        $estu_id=$_POST['estu_id'];
        if(!is_numeric($estu_id))
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"El identificador no es un n&uacute;mero entero"
            ];
            exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber si el dato estu_id es numérico*/

        /*Saber si los campos están vacíos y manejo de carácteres*/
        $estu_nombres=strtoupper(htmlentities($_POST['estu_nombres'],ENT_QUOTES));
        $estu_apellidos=strtoupper(htmlentities($_POST['estu_apellidos'],ENT_QUOTES));
        $arreglo_datos = ['nombres'=>$estu_nombres,'apellidos'=>$estu_apellidos];
        foreach($arreglo_datos as $indices=>$objeto_datos)
        {
            if(empty($objeto_datos))
            {
                $arreglo_respuesta = [
                    "estado"=>"ERROR",
                    "mensaje"=>"Se debe llenar el campo $indices"
                ];
                exit(json_encode($arreglo_respuesta));
            }
        } 
        /*Fin saber si los campos están vacíos y manejo de carácteres*/

        /*Saber si se supera número de carácteres*/
        $size_estu_nombres=strlen($estu_nombres);
        $size_estu_apellidos=strlen($estu_apellidos);
        $arreglo_size_datos=['nombres'=>$size_estu_nombres,'apellidos'=>$size_estu_apellidos];
        foreach($arreglo_size_datos as $indices_size_datos=>$objetos_size_datos)
        {
            if($objetos_size_datos>45 || ($indices_size_datos=='documento' && $objetos_size_datos>15))
            {
                $arreglo_respuesta = [
                    "estado"=>"ERROR",
                    "mensaje"=>"Se excedi&oacute; la cantidad de car&aacute;cteres en el campo de $indices_size_datos"
                ];
        
                exit(json_encode($arreglo_respuesta));
            }
        }
        /*Fin saber se supera número de carácteres*/

        $estudiantes_MO->actualizarEstudiantes($estu_id,$estu_nombres,$estu_apellidos);

        $arreglo_respuesta = [
            "estado"=>"EXITO",
            "mensaje"=>"Registro Actualizado"
        ];

        echo json_encode($arreglo_respuesta);
    }
}
?>