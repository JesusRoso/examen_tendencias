<?php
class estudiantes_VI
{
    function __construct(){}

    function agregar()
    {
        require_once "modelos/estudiantes_MO.php";
        $conexion=new conexion('sel');
        $estudiantes_MO=new estudiantes_MO($conexion);

        $arreglo_estudiantes=$estudiantes_MO->seleccionar();
        ?>
        <div class="card">
        <div class="card-header">
            Agregar estudiantes
        </div>
        <div class="card-body">
            <form id="formulario_agregar_estudiantes">
                <div class="form-group">
                    <label for="estu_documento">N&uacute;mero de documento</label>
                    <input type="number" class="form-control" id="estu_documento" name="estu_documento">
                </div>
                <div class="form-group">
                    <label for="estu_nombres">Nombres estudiante</label>
                    <input type="text" class="form-control" id="estu_nombres" name="estu_nombres">
                </div>
                <div class="form-group">
                    <label for="estu_apellidos">Apellidos estudiante</label>
                    <input type="text" class="form-control" id="estu_apellidos" name="estu_apellidos">
                </div>
                <button type="button" onclick="agregarEstudiantes();" class="btn btn-primary float-right">Agregar</button>
            </form>
        </div>
        </div>
        <div class="card">
        <div class="card-header">
            Listar estudiantes
        </div>
        <div class="card-body">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th style="text-align: center;" scope="col">Acci&oacute;n</th>
                </tr>
            </thead>
            <tbody id="lista_estudiantes">
                <?php
                foreach($arreglo_estudiantes as $objeto_estudiantes)
                {
                    $estu_id=$objeto_estudiantes->estu_id;
                    $estu_nombres=$objeto_estudiantes->estu_nombres;
                    $estu_apellidos=$objeto_estudiantes->estu_apellidos;
                    ?>
                    <tr>
                        <td id="estu_nombres_td_<?php echo $estu_id;?>"><?php echo ucwords(strtolower($estu_nombres));?></td>
                        <td style="text-align: center;">
                            <input type="hidden" id="estu_nombres_<?php echo $estu_id;?>" value="<?php echo ucwords(strtolower($estu_nombres));?>">
                            <input type="hidden" id="estu_apellidos_<?php echo $estu_id;?>" value="<?php echo ucwords(strtolower($estu_apellidos));?>">
                            <i style="cursor: pointer;" class="fas fa-pen-alt" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizarEstudiantes(<?php echo $estu_id;?>);"></i>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            </table>
        </div>
        </div>
        <script>


        function verActualizarEstudiantes(estu_id)
        {
            let estu_nombres=document.querySelector('#estu_nombres_'+estu_id).value;
            let estu_apellidos=document.querySelector('#estu_apellidos_'+estu_id).value;
            let formulario=`
            <div class="card">
                <div class="card-header">
                    Agregar estudiantes
                </div>
                <div class="card-body">
                    <form id="formulario_actualizar_estudiantes">
                        <div class="form-group">
                            <label for="estu_nombres">Nombres estudiante</label>
                            <input type="text" class="form-control" id="estu_nombres" name="estu_nombres" value="${estu_nombres}">    
                            <label for="estu_apellidso">Apellidos estudiante</label>
                            <input type="text" class="form-control" id="estu_apellidos" name="estu_apellidos" value="${estu_apellidos}">      
                        </div>
                        <input type="hidden" id="estu_id" name="estu_id" value="${estu_id}">
                        <button type="button" onclick="actualizarEstudiantes(${estu_id});" class="btn btn-primary float-right">Actualizar</button>
                    </form>
                </div>
            </div>`;
            document.querySelector('#ventana_modal_contenido').innerHTML=formulario;
        }
        function actualizarEstudiantes(estu_id)
        {
            let cadena = new FormData(document.querySelector('#formulario_actualizar_estudiantes'))
            fetch('estudiantes_CO/actualizarEstudiantes', {
            method: 'POST',
            body: cadena
            })
            .then(res => res.json())
            .then(res=> 
            {
                let estu_nombres=document.querySelector('#formulario_actualizar_estudiantes #estu_nombres').value;
                if(res.estado=='EXITO')
                {
                    document.querySelector('#estu_nombres_td_'+estu_id).innerHTML=estu_nombres;
                    document.querySelector('#estu_nombres_'+estu_id).value=estu_nombres;
                    toastr.success(res.mensaje);
                }
                else if(res.estado=='ERROR')
                {
                    toastr.error(res.mensaje);
                }
                
            });
        }  
        function agregarEstudiantes()
        {
            let cadena = new FormData(document.querySelector('#formulario_agregar_estudiantes'))
            fetch('estudiantes_CO/agregar', {
            method: 'POST',
            body: cadena
            })
            .then(res => res.json())
            .then(res=> 
            {
                if(res.estado=='EXITO')
                {
                    let estu_id=res.estu_id;
                    let estu_nombres=document.querySelector('#formulario_agregar_estudiantes #estu_nombres').value;
                    let estu_apellidos=document.querySelector('#formulario_agregar_estudiantes #estu_apellidos').value;
                    let fila= `
                    <tr>
                        <td id="estu_nombres_td_${estu_id}">${estu_nombres}</td>
                        <td style="text-align: center;">
                            <input type="hidden" id="estu_nombres_${estu_id}" value="${estu_nombres}">
                            <input type="hidden" id="estu_apellidos_${estu_id}" value="${estu_apellidos}">
                            <i style="cursor: pointer;" class="fas fa-pen-alt" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizarEstudiantes('${estu_id}');"></i>
                        </td>
                    </tr>
                    `;    
                    document.querySelector('#lista_estudiantes').insertAdjacentHTML('afterbegin',fila)
                    document.querySelector('#formulario_agregar_estudiantes').reset();
                    toastr.success(res.mensaje);
                }
                else if(res.estado=='ERROR')
                {
                    toastr.error(res.mensaje);
                }
                
            });
        }
        </script>
        <?php
    }
}
?>