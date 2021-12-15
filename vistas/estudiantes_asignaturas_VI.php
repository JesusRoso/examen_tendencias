<?php
class estudiantes_asignaturas_VI
{
    function __construct(){}

    function agregar()
    {
        require_once "modelos/estudiantes_asignaturas_MO.php";
        require_once "modelos/estudiantes_MO.php";
        require_once "modelos/asignaturas_MO.php";
        require_once "modelos/tipo_notas_MO.php";
        $conexion=new conexion('sel');
        $estudiantes_asignaturas_MO=new estudiantes_asignaturas_MO($conexion);
        $estudiantes_MO=new estudiantes_MO($conexion);
        $asignaturas_MO=new asignaturas_MO($conexion);
        $tipo_notas_MO=new tipo_notas_MO($conexion);

        $arreglo_estudiantes_asignaturas=$estudiantes_asignaturas_MO->seleccionar();
        $arreglo_estudiantes=$estudiantes_MO->seleccionar();
        $arreglo_asignaturas=$asignaturas_MO->seleccionar();
        $arreglo_tipo_notas=$tipo_notas_MO->seleccionar();
        ?>
        <div class="card">
        <div class="card-header">
            Registrar notas
        </div>
        <div class="card-body">
            <form id="formulario_agregar_estudiantes_asignaturas">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estu_id">Estudiante</label>
                            <select class="form-control" name="estu_id" id="estu_nombres">
                                <option value="">Selecionar estudiante</option>
                                <?php
                                if($arreglo_estudiantes)
                                {
                                    foreach($arreglo_estudiantes as $objeto_estudiantes)
                                    {
                                        $estu_id=$objeto_estudiantes->estu_id;
                                        $estu_nombres=$objeto_estudiantes->estu_nombres;
                                        ?>
                                        <option value="<?php echo $estu_id;?>"><?php echo ucwords(strtolower($estu_nombres));?></option>
                                        <?php
                                    }    
                                } 
                                ?>
                            </select>
                            <input type="hidden" id="estu_documento" value="<?php echo ucwords(strtolower($estu_id));?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="asig_id">Asignatura</label>
                            <select class="form-control" name="asig_id" id="asig_nombre">
                                <option value="">Selecionar asignatura</option>
                                <?php
                                if($arreglo_asignaturas)
                                {
                                    foreach($arreglo_asignaturas as $objeto_asignatura)
                                    {
                                        $asig_id=$objeto_asignatura->asig_id;
                                        $asig_nombre=$objeto_asignatura->asig_nombre;
                                        ?>
                                        <option value="<?php echo $asig_id;?>"><?php echo ucwords(strtolower($asig_nombre));?></option>
                                        <?php
                                    }    
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tino_id">Tipo de nota</label>
                            <select class="form-control" name="tino_id" id="tino_nombre">
                                <option value="">Selecionar tipo de nota</option>
                                <?php
                                if($arreglo_tipo_notas)
                                {
                                    foreach($arreglo_tipo_notas as $objeto_tipo_notas)
                                    {
                                        $tino_id=$objeto_tipo_notas->tino_id;
                                        $tino_nombre=$objeto_tipo_notas->tino_nombre;
                                        ?>
                                        <option value="<?php echo $tino_id;?>"><?php echo ucwords(strtolower($tino_nombre));?></option>
                                        <?php
                                    }    
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="valor_nota">Calificaci&oacute;n</label>
                            <input type="number" class="form-control" id="valor_nota" name="valor_nota" required>
                        </div>
                    </div>
                    
                </div>
                <button type="button" onclick="agregarEstudiantesAsignaturas();" class="btn btn-primary float-right">Agregar</button>
            </form>
        </div>
        </div>
        <div class="card">
        <div class="card-header">
            Listar registros
        </div>
        <div class="card-body">
            <table class="table">
            <thead>
                <tr>
                    <th scope="col">Documento</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Asignatura</th>
                    <th scope="col">Tipo de nota</th>
                    <th scope="col">Calificaci&oacute;n</th>
                    <th style="text-align: center;" scope="col">Acci&oacute;n</th>
                </tr>
            </thead>
            <tbody id="lista_estudiantes_asignaturas">
                <?php
                foreach($arreglo_estudiantes_asignaturas as $objeto_estudiantes_asignaturas)
                {
                    $esasig_id=$objeto_estudiantes_asignaturas->esasig_id;
                    $estu_nombres=$objeto_estudiantes_asignaturas->estu_nombres;
                    $estu_documento=$objeto_estudiantes_asignaturas->estu_documento;
                    $asig_nombre=$objeto_estudiantes_asignaturas->asig_nombre;
                    $tino_nombre=$objeto_estudiantes_asignaturas->tino_nombre;
                    $valor_nota=$objeto_estudiantes_asignaturas->valor_nota;
                    ?>
                    <tr>
                        <td id="estu_documento_td_<?php echo $esasig_id;?>"><?php echo ucwords(strtolower($estu_documento));?></td>
                        <td id="estu_nombres_td_<?php echo $esasig_id;?>"><?php echo ucwords(strtolower($estu_nombres));?></td>
                        <td id="asig_nombre_td_<?php echo $esasig_id;?>"><?php echo ucwords(strtolower($asig_nombre));?></td>
                        <td id="tino_nombre_td_<?php echo $esasig_id;?>"><?php echo ucwords(strtolower($tino_nombre));?></td>
                        <td id="valor_nota_td_<?php echo $esasig_id;?>"><?php echo ucwords(strtolower($valor_nota));?></td>
                        <td style="text-align: center;">
                            <input type="hidden" id="estu_documento_<?php echo $esasig_id;?>" value="<?php echo ucwords(strtolower($estu_documento));?>">
                            <input type="hidden" id="estu_nombres_<?php echo $esasig_id;?>" value="<?php echo ucwords(strtolower($estu_nombres));?>">
                            <input type="hidden" id="asig_nombre_<?php echo $esasig_id;?>" value="<?php echo ucwords(strtolower($asig_nombre));?>">
                            <input type="hidden" id="tino_nombre_<?php echo $esasig_id;?>" value="<?php echo ucwords(strtolower($tino_nombre));?>">
                            <input type="hidden" id="valor_nota_<?php echo $esasig_id;?>" value="<?php echo ucwords(strtolower($valor_nota));?>">
                            <i style="cursor: pointer;" class="fas fa-pen-alt" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizarEstudiantesAsignaturas(<?php echo $esasig_id;?>);"></i>
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


        function verActualizarEstudiantesAsignaturas(esasig_id)
        {
            let asig_nombre=document.querySelector('#asig_nombre_'+esasig_id).value;
            let tino_nombre=document.querySelector('#tino_nombre_'+esasig_id).value;
            let valor_nota=document.querySelector('#valor_nota_'+esasig_id).value;
            let formulario=`
            <div class="card">
                <div class="card-header">
                    Actualizar registros
                </div>
                <div class="card-body">
                    <form id="formulario_actualizar_estudiantes_asignaturas">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="valor_nota">${asig_nombre}</label>
                            </div>
                            <div class="form-group">
                                <label for="valor_nota">Calificaci&oacute;n</label>
                                <input type="number" class="form-control" id="valor_nota" name="valor_nota" required>
                            </div>
                        </div>   
                        <input type="hidden" id="esasig_id" name="esasig_id" value="${esasig_id}">
                        <button type="button" onclick="actualizarEstudiantesAsignaturas('${esasig_id}');" class="btn btn-primary float-right">Actualizar</button>
                    </form>
                </div>
            </div>`;
            document.querySelector('#ventana_modal_contenido').innerHTML=formulario;
        }
        function actualizarEstudiantesAsignaturas(esasig_id)
        {
            let cadena = new FormData(document.querySelector('#formulario_actualizar_estudiantes_asignaturas'))
            fetch('estudiantes_asignaturas_CO/actualizarEstudiantesAsignaturas', {
            method: 'POST',
            body: cadena
            })
            .then(res => res.json())
            .then(res=> 
            {
                let valor_nota=document.querySelector('#formulario_actualizar_estudiantes_asignaturas #valor_nota').value;
                if(res.estado=='EXITO')
                {
                    document.querySelector('#valor_nota_td_'+esasig_id).innerHTML=valor_nota;
                    document.querySelector('#valor_nota_'+esasig_id).value=valor_nota;
                    toastr.success(res.mensaje);
                }
                else if(res.estado=='ERROR')
                {
                    toastr.error(res.mensaje);
                }
                
            });
        }  
        function agregarEstudiantesAsignaturas()
        {
            let cadena = new FormData(document.querySelector('#formulario_agregar_estudiantes_asignaturas'))
            fetch('estudiantes_asignaturas_CO/agregar', {
            method: 'POST',
            body: cadena
            })
            .then(res => res.json())
            .then(res=> 
            {
                if(res.estado=='EXITO')
                {
                    let esasig_id=res.esasig_id;
                    let estu_documento=res.estu_documento;
                    let estu_nombres=document.querySelector('#formulario_agregar_estudiantes_asignaturas #estu_nombres');
                    let estu_nombres_selected=estu_nombres.options[estu_nombres.selectedIndex].text;
                    let asig_nombre=document.querySelector('#formulario_agregar_estudiantes_asignaturas #asig_nombre');
                    let asig_nombres_selected=asig_nombre.options[asig_nombre.selectedIndex].text;
                    let tino_nombre=document.querySelector('#formulario_agregar_estudiantes_asignaturas #tino_nombre');
                    let tino_nombres_selected=tino_nombre.options[tino_nombre.selectedIndex].text;
                    let valor_nota=document.querySelector('#formulario_agregar_estudiantes_asignaturas #valor_nota').value;
                    let fila= `
                    <tr>
                        <td id="estu_documento_td_${esasig_id}">${estu_documento}</td>
                        <td id="estu_nombres_td_${esasig_id}">${estu_nombres_selected}</td>
                        <td id="asig_nombre_td_${esasig_id}">${asig_nombres_selected}</td>
                        <td id="tino_nombre_td_${esasig_id}">${tino_nombres_selected}</td>
                        <td id="valor_nota_td_${esasig_id}">${valor_nota}</td>
                        <td style="text-align: center;">
                            <input type="hidden" id="estu_documento_${esasig_id}" value="${estu_documento}">
                            <input type="hidden" id="estu_nombres_${esasig_id}" value="${estu_nombres_selected}">
                            <input type="hidden" id="asig_nombre_${esasig_id}" value="${asig_nombres_selected}">
                            <input type="hidden" id="tino_nombre_${esasig_id}" value="${tino_nombres_selected}">
                            <input type="hidden" id="valor_nota_${esasig_id}" value="${valor_nota}">
                            
                            <i style="cursor: pointer;" class="fas fa-pen-alt" data-toggle="modal" data-target="#ventana_modal" onclick="verActualizarEstudiantesAsignaturas('${esasig_id}');"></i>
                        </td>
                    </tr>
                    `;    
                    document.querySelector('#lista_estudiantes_asignaturas').insertAdjacentHTML('afterbegin',fila)
                    document.querySelector('#formulario_agregar_estudiantes_asignaturas').reset();
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