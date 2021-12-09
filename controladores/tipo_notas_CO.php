<?php
require_once "modelos/tipo_notas_MO.php";

class tipo_notas_CO
{
    function __construct(){}

    function agregar()
    {
        $conexion=new conexion('all');
        
        $tipo_notas_MO=new tipo_notas_MO($conexion);

        /*Saber si los campos están vacíos y manejo de carácteres*/
        $tino_nombre=strtoupper(htmlentities($_POST['tino_nombre'],ENT_QUOTES));
        $arreglo_datos = ['nombre'=>$tino_nombre];
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
        $size_tino_nombre=strlen($tino_nombre);
        $arreglo_size_datos=['nombre'=>$size_tino_nombre];
        foreach($arreglo_size_datos as $indices_size_datos=>$objetos_size_datos)
        {
            if($objetos_size_datos>45)
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
        $arreglo_tipo_notas=$tipo_notas_MO->seleccionarNombre($tino_nombre);
        if($arreglo_tipo_notas)
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"El Tipo de nota $tino_nombre est&aacute; duplicado"
            ];
            exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber si está duplicado el documento*/

        $tipo_notas_MO->agregar($tino_nombre);

        $tino_id=$conexion->lastInsertId();

        $arreglo_respuesta = [
            "estado"=>"EXITO",
            "mensaje"=>"Registro Agregado",
            "tino_id"=>$tino_id
        ];

        echo json_encode($arreglo_respuesta);
    }

    function actualizarTipoNotas()
    {
        $conexion=new conexion('all');
        
        $tipo_notas_MO=new tipo_notas_MO($conexion);

        /*Saber si el dato estu_id es numérico*/
        $tino_id=$_POST['tino_id'];
        if(!is_numeric($tino_id))
        {
            $arreglo_respuesta = [
                "estado"=>"ERROR",
                "mensaje"=>"El identificador no es un n&uacute;mero entero"
            ];
    
            exit(json_encode($arreglo_respuesta));
        }
        /*Fin saber si el dato estu_id es numérico*/

        /*Saber si los campos están vacíos y manejo de carácteres*/
        $tino_nombre=strtoupper(htmlentities($_POST['tino_nombre'],ENT_QUOTES));
        $arreglo_datos = ['nombre'=>$tino_nombre];
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

        
       /*Saber si está duplicado el documento*/
       $arreglo_tipo_notas=$tipo_notas_MO->seleccionarNombre($tino_nombre);
       if($arreglo_tipo_notas)
       {
           $arreglo_respuesta = [
               "estado"=>"ERROR",
               "mensaje"=>"El Tipo de nota $tino_nombre est&aacute; duplicado"
           ];
           exit(json_encode($arreglo_respuesta));
       }
       /*Fin saber si está duplicado el documento*/


        /*Saber si se supera número de carácteres*/
        $size_tino_nombre=strlen($tino_nombre);
        $arreglo_size_datos=['nombre'=>$size_tino_nombre];
        foreach($arreglo_size_datos as $indices_size_datos=>$objetos_size_datos)
        {
            if($objetos_size_datos>45)
            {
                $arreglo_respuesta = [
                    "estado"=>"ERROR",
                    "mensaje"=>"Se excedi&oacute; la cantidad de car&aacute;cteres en el campo de $indices_size_datos"
                ];
        
                exit(json_encode($arreglo_respuesta));
            }
        }
        /*Fin saber se supera número de carácteres*/

        $tipo_notas_MO->actualizarTipoNotas($tino_id,$tino_nombre);

        $arreglo_respuesta = [
            "estado"=>"EXITO",
            "mensaje"=>"Registro Actualizado"
        ];

        echo json_encode($arreglo_respuesta);
    }
}
?>