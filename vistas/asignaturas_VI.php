<?php
class asignaturas_VI
{
    function __construct(){}

    function agregar()
    {
        require_once "modelos/asignaturas_MO.php";
        $conexion=new conexion('sel');
        $asignaturas_MO=new asignaturas_MO($conexion);

        $arreglo_asignaturas=$asignaturas_MO->seleccionar();
        ?>
        <div class="card">
        <div class="card-header">
            Agregar asignatura
        </div>
        <div class="card-body">
            <form id="formulario_agregar_asignaturas">
                <div class="form-group">
                    <label for="asig_nombre">Nombre de la asignatura</label>
                    <input type="text" class="form-control" id="asig_nombre" name="asig_nombre">
                </div>
                <div class="form-group">
                    <label for="asig_descripcion">Descripci&oacute;n de la asignatura</label>
                      <textarea class="form-control" name="asig_descripcion" id="asig_descripcion" rows="3"></textarea>
                </div>
                <button type="button" onclick="agregarAsignatura();" class="btn btn-primary float-right">Agregar</button>
            </form>
        </div>
        </div>
        <div class="card">
        <div class="card-header">
            Listar asignaturas
        </div>
        <div class="card-body">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th style="text-align: center;" scope="col">Acci&oacute;n</th>
                </tr>
            </thead>
            <tbody id="lista_asignaturas">
                <?php
                foreach($arreglo_asignaturas as $objeto_asignaturas)
                {
                    $asig_id=$objeto_asignaturas->asig_id;
                    $asig_nombre=$objeto_asignaturas->asig_nombre;
                    $asig_descripcion=$objeto_asignaturas->asig_descripcion;
                    ?>
                    <tr>
                        <td id="asig_nombre_td_<?php echo $asig_id;?>"><?php echo ucwords(strtolower($asig_nombre));?></td>
                        <td style="text-align: center;">
                            <input type="hidden" id="asig_nombre_<?php echo $asig_id;?>" value="<?php echo ucwords(strtolower($asig_nombre));?>">
                            <input type="hidden" id="asig_descripcion_<?php echo $asig_id;?>" value="<?php echo ucwords(strtolower($asig_descripcion));?>">
                            <i style="cursor: pointer;" class="fas fa-pen-alt" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizarAsignaturas(<?php echo $asig_id;?>);"></i>
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



        function verActualizarAsignaturas(asig_id)
        {
            let asig_nombre=document.querySelector('#asig_nombre_'+asig_id).value;
            let formulario=`
            <div class="card">
                <div class="card-header">
                    Actualizar asignaturas
                </div>
                <div class="card-body">
                    <form id="formulario_actualizar_asignaturas">
                        <div class="form-group">
                            <label for="asig_nombre">Nombre de la asignatura</label>
                            <input type="text" class="form-control" id="asig_nombre" name="asig_nombre" value="${asig_nombre}">    
                            <label for="asig_descripcion">Descripci&oacute;n de la asignatura</label> 
                            <textarea class="form-control" name="asig_descripcion" id="asig_descripcion" rows="3" ></textarea>     
                        </div>
                        <input type="hidden" id="asig_id" name="asig_id" value="${asig_id}">
                        <button type="button" onclick="actualizarAsignaturas(${asig_id});" class="btn btn-primary float-right">Actualizar</button>
                    </form>
                </div>
            </div>`;
            document.querySelector('#ventana_modal_contenido').innerHTML=formulario;
        }
        function actualizarAsignaturas(asig_id)
        {
            let cadena = new FormData(document.querySelector('#formulario_actualizar_asignaturas'))
            fetch('asignaturas_CO/actualizarAsignaturas', {
            method: 'POST',
            body: cadena
            })
            .then(res => res.json())
            .then(res=> 
            {
                let asig_nombre=document.querySelector('#formulario_actualizar_asignaturas #asig_nombre').value;
                let asig_descripcion=document.querySelector('#formulario_actualizar_asignaturas #asig_descripcion').value;
                if(res.estado=='EXITO')
                {
                    document.querySelector('#asig_nombre_td_'+asig_id).innerHTML=asig_nombre;
                    document.querySelector('#asig_nombre_'+asig_id).value=asig_nombre;
                    document.querySelector('#asig_descripcion_'+asig_id).value=asig_descripcion;
                    toastr.success(res.mensaje);
                }
                else if(res.estado=='ERROR')
                {
                    toastr.error(res.mensaje);
                }
                
            });
        }  
        function agregarAsignatura()
        {
            let cadena = new FormData(document.querySelector('#formulario_agregar_asignaturas'))
            fetch('asignaturas_CO/agregar', {
            method: 'POST',
            body: cadena
            })
            .then(res => res.json())
            .then(res=> 
            {
                if(res.estado=='EXITO')
                {
                    let asig_id=res.asig_id;
                    let asig_nombre=document.querySelector('#formulario_agregar_asignaturas #asig_nombre').value;
                    let asig_descripcion=document.querySelector('#formulario_agregar_asignaturas #asig_descripcion').value;
                    let fila= `
                    <tr>
                        <td id="asig_nombre_td_${asig_id}">${asig_nombre}</td>
                        <td style="text-align: center;">
                            <input type="hidden" id="asig_nombre_${asig_id}" value="${asig_nombre}">
                            <input type="hidden" id="asig_descripcion_${asig_id}" value="${asig_descripcion}">
                            <i style="cursor: pointer;" class="fas fa-pen-alt" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizarAsignaturas('${asig_id}');"></i>
                        </td>
                    </tr>
                    `;    
                    document.querySelector('#lista_asignaturas').insertAdjacentHTML('afterbegin',fila)
                    document.querySelector('#formulario_agregar_asignaturas').reset();
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