<?php
class tipo_notas_VI
{
    function __construct(){}

    function agregar()
    {
        require_once "modelos/tipo_notas_MO.php";
        $conexion=new conexion('sel');
        $tipo_notas_MO=new tipo_notas_MO($conexion);

        $arreglo_tipo_notas=$tipo_notas_MO->seleccionar();
        ?>
        <div class="card">
        <div class="card-header">
            Agregar Tipo de notas
        </div>
        <div class="card-body">
            <form id="formulario_agregar_tipo_notas">
                <div class="form-group">
                    <label for="tino_nombre">Tipo de notas</label>
                    <input type="text" class="form-control" id="tino_nombre" name="tino_nombre">
                </div>
                <button type="button" onclick="agregarTipoNotas();" class="btn btn-primary float-right">Agregar</button>
            </form>
        </div>
        </div>
        <div class="card">
        <div class="card-header">
            Listar Tipo de Notas
        </div>
        <div class="card-body">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th style="text-align: center;" scope="col">Acci&oacute;n</th>
                </tr>
            </thead>
            <tbody id="lista_tipo_notas">
                <?php
                foreach($arreglo_tipo_notas as $objeto_tipo_notas)
                {
                    $tino_id=$objeto_tipo_notas->tino_id;
                    $tino_nombre=$objeto_tipo_notas->tino_nombre;
                    ?>
                    <tr>
                        <td id="tino_nombre_td_<?php echo $tino_id;?>"><?php echo ucwords(strtolower($tino_nombre));?></td>
                        <td style="text-align: center;">
                            <input type="hidden" id="tino_nombre_<?php echo $tino_id;?>" value="<?php echo ucwords(strtolower($tino_nombre));?>">
                            <i style="cursor: pointer;" class="fas fa-pen-alt" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizarTipoNotas(<?php echo $tino_id;?>);"></i>
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


        function verActualizarTipoNotas(tino_id)
        {
            let tino_nombre=document.querySelector('#tino_nombre_'+tino_id).value;
            let formulario=`
            <div class="card">
                <div class="card-header">
                    Actualizar Tipo de notas
                </div>
                <div class="card-body">
                    <form id="formulario_actualizar_tipo_notas">
                        <div class="form-group">
                            <label for="tino_nombre">Nombres Tipo de notas</label>
                            <input type="text" class="form-control" id="tino_nombre" name="tino_nombre" value="${tino_nombre}">     
                        </div>
                        <input type="hidden" id="tino_id" name="tino_id" value="${tino_id}">
                        <button type="button" onclick="actualizarTipoNotas(${tino_id});" class="btn btn-primary float-right">Actualizar</button>
                    </form>
                </div>
            </div>`;
            document.querySelector('#ventana_modal_contenido').innerHTML=formulario;
        }
        function actualizarTipoNotas(tino_id)
        {
            let cadena = new FormData(document.querySelector('#formulario_actualizar_tipo_notas'))
            fetch('tipo_notas_CO/actualizarTipoNotas', {
            method: 'POST',
            body: cadena
            })
            .then(res => res.json())
            .then(res=> 
            {
                let tino_nombre=document.querySelector('#formulario_actualizar_tipo_notas #tino_nombre').value;
                if(res.estado=='EXITO')
                {
                    document.querySelector('#tino_nombre_td_'+tino_id).innerHTML=tino_nombre;
                    document.querySelector('#tino_nombre_'+tino_id).value=tino_nombre;
                    toastr.success(res.mensaje);
                }
                else if(res.estado=='ERROR')
                {
                    toastr.error(res.mensaje);
                }
                
            });
        }  
        function agregarTipoNotas()
        {
            let cadena = new FormData(document.querySelector('#formulario_agregar_tipo_notas'))
            fetch('tipo_notas_CO/agregar', {
            method: 'POST',
            body: cadena
            })
            .then(res => res.json())
            .then(res=> 
            {
                if(res.estado=='EXITO')
                {
                    let tino_id=res.tino_id;
                    let tino_nombre=document.querySelector('#formulario_agregar_tipo_notas #tino_nombre').value;
                    let fila= `
                    <tr>
                        <td id="tino_nombre_td_${tino_id}">${tino_nombre}</td>
                        <td style="text-align: center;">
                            <input type="hidden" id="tino_nombre_${tino_id}" value="${tino_nombre}">
                            <i style="cursor: pointer;" class="fas fa-pen-alt" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizarTipoNotas('${tino_id}');"></i>
                        </td>
                    </tr>
                    `;    
                    document.querySelector('#lista_tipo_notas').insertAdjacentHTML('afterbegin',fila)
                    document.querySelector('#formulario_agregar_tipo_notas').reset();
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