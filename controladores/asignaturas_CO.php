<?php
require_once "modelos/asignaturas_MO.php";

class asignaturas_CO
{
    function __construct(){}

    function agregar()
    {
        $conexion=new conexion('all');
        
        $asignaturas_MO=new asignaturas_MO($conexion);

        /*Saber si los campos están vacíos y manejo de carácteres*/
        $asig_nombre=strtoupper(htmlentities($_POST['asig_nombre'],ENT_QUOTES));
        $asig_descripcion=strtoupper(htmlentities($_POST['asig_descripcion'],ENT_QUOTES));
        $arreglo_datos = ['nombre'=>$asig_nombre,'descripcion'=>$asig_descripcion];
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
        $size_asig_nombre=strlen($asig_nombre);
        $size_asig_descripcion=strlen($asig_descripcion);
        $arreglo_size_datos=['nombre'=>$size_asig_nombre,'descripcion'=>$size_asig_descripcion];
        foreach($arreglo_size_datos as $indices_size_datos=>$objetos_size_datos)
        {
            if(($indices_size_datos=='nombre' && $objetos_size_datos>45) || ($indices_size_datos=='descripcion' && $objetos_size_datos>100))
            {
                $arreglo_respuesta = [
                    "estado"=>"ERROR",
                    "mensaje"=>"Se excedi&oacute; la cantidad de car&aacute;cteres en el campo de $indices_size_datos"
                ];
        
                exit(json_encode($arreglo_respuesta));
            }
        }
        /*Fin saber se supera número de carácteres*/

        /*Saber si está duplicado la asignatura*/
        $arreglo_asignaturas=$asignaturas_MO->seleccionarNombreAsignatura($asig_nombre);
        if($arreglo_asignaturas)
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"La asignatura $asig_nombre est&aacute; duplicada"
            ];
            exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber si está duplicado la asignatura*/

        $asignaturas_MO->agregar($asig_nombre,$asig_descripcion);

        $asig_id=$conexion->lastInsertId();

        $arreglo_respuesta = [
            "estado"=>"EXITO",
            "mensaje"=>"Registro Agregado",
            "asig_id"=>$asig_id
        ];

        echo json_encode($arreglo_respuesta);
    }
    
    
    function actualizarAsignaturas()
    {
        $conexion=new conexion('all');
        
        $asignaturas_MO=new asignaturas_MO($conexion);

        /*Saber si el dato asig_id es numérico*/
        $asig_id=$_POST['asig_id'];
        if(!is_numeric($asig_id))
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"El identificador no es un n&uacute;mero entero"
            ];
    
            exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber sa la asignatura_id es numérico*/

        /*Saber si los campos están vacíos y manejo de carácteres*/
        $asig_nombre=strtoupper(htmlentities($_POST['asig_nombre'],ENT_QUOTES));
        $asig_descripcion=strtoupper(htmlentities($_POST['asig_descripcion'],ENT_QUOTES));
        $arreglo_datos = ['nombre'=>$asig_nombre,'descripcion'=>$asig_descripcion];
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


        /*Saber si está duplicada la asignatura*/
        $arreglo_asignaturas=$asignaturas_MO->seleccionarNombreAsignatura($asig_nombre);
        foreach ($arreglo_asignaturas as $objeto_asignatura ) {
            $asig_id_objeto=$objeto_asignatura->asig_id;
        }
        if($arreglo_asignaturas && ($asig_id!=$asig_id_objeto))
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"La asignatura $asig_nombre est&aacute; duplicada"
            ];
            exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber si está duplicada la asignatura*/

        /*Saber si se supera número de carácteres*/
        $size_asig_nombre=strlen($asig_nombre);
        $size_asig_descripcion=strlen($asig_descripcion);
        $arreglo_size_datos=['nombre'=>$size_asig_nombre,'descripcion'=>$size_asig_descripcion];
        foreach($arreglo_size_datos as $indices_size_datos=>$objetos_size_datos)
        {
            if(($indices_size_datos=='nombre' && $objetos_size_datos>45) || ($indices_size_datos=='descripcion' && $objetos_size_datos>100))
            {
                $arreglo_respuesta = [
                    "estado"=>"ERROR",
                    "mensaje"=>"Se excedi&oacute; la cantidad de car&aacute;cteres en el campo de $indices_size_datos"
                ];
                exit(json_encode($arreglo_respuesta));
            }
        }
        /*Fin saber se supera número de carácteres*/

        $asignaturas_MO->actualizarAsignaturas($asig_id,$asig_nombre,$asig_descripcion);

        $arreglo_respuesta = [
            "estado"=>"EXITO",
            "mensaje"=>"Registro Actualizado"
        ];

        echo json_encode($arreglo_respuesta);
    }
}
?>