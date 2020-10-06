<template>
    <!-- Contenido Principal -->
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header text-white bg-primary">
                    <i class="fa fa-align-justify"></i> ESTADO DEL MANTENIMIENTO DE LOS VEHÍCULOS
                </div>
                <div class="card-body">
                    <template v-if="loading">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="idAVL">ID AVL</option>
                                        <option value="Name">NOMBRE</option>
                                        <option value="Plate">PLACA</option>
                                        <option value="Fleet">FLOTA</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup="listarPrincipal(1, buscar, criterio, criterio2, desde, hasta, select_taller, select_tipomanto)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-10">
                                <div class="input-group input-daterange">
                                    <select class="form-control col-md-6" v-model="criterio2">
                                        <option value="tb_vehicles.kms_inicial">ODÓMETRO ACTUAL</option>
                                        <option value="tb_mtto_history.kms_goal">ODÓMETRO ALERTA</option>
                                    </select>                            
                                    <div class="input-group-addon bg-primary">DESDE</div>
                                    <input type="number" v-model="desde" @change="cambiarKmHasta()" :min="minimo_desde" :max="maximo_desde" class="form-control">
                                    <div class="input-group-addon bg-primary">HASTA</div>
                                    <input type="number" v-model="hasta" @change="cambiarKmDesde()" :min="minimo_hasta" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group input-daterange">
                                    <div class="input-group-addon bg-primary">TIPO MANTO</div>
                                    <select class="form-control col-md-8" v-model="select_tipomanto" @change="listarPrincipal(1, buscar, criterio, criterio2, desde, hasta, select_taller, select_tipomanto)">
                                        <option value="">TODOS</option>
                                        <option v-for="nombreTipomanto in arrayTipomanto" :key="nombreTipomanto.id" :value="nombreTipomanto.id" v-text="nombreTipomanto.nombre"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-daterange">
                                    <div class="input-group-addon bg-primary">TALLER</div>
                                    <select class="form-control col-md-8" v-model="select_taller" @change="listarPrincipal(1, buscar, criterio, criterio2, desde, hasta, select_taller, select_tipomanto)">
                                        <option value="">TODOS</option>
                                        <option v-for="nombreTaller in arrayTaller" :key="nombreTaller.id" :value="nombreTaller.id" v-text="nombreTaller.nombre"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                    <th style="text-align: center;" class="align-middle"><div class="sizeOpcion">OPCIONES</div></th>
                                    <th style="text-align: center;" class="align-middle">ID AVL</th>
                                    <th style="text-align: center;" class="align-middle">NOMBRE</th>
                                    <th style="text-align: center;" class="align-middle">PLACA</th>
                                    <th style="text-align: center;" class="align-middle">FLOTA</th>
                                    <th style="text-align: center;" class="align-middle">ODO. ACTUAL</th>
                                    <th style="text-align: center;" class="align-middle">ODO. ALERTA</th>
                                    <th style="text-align: center;" class="align-middle">ODO. ULTO MTTO</th>
                                    <th style="text-align: center;" class="align-middle">TIPO MANTO.</th>
                                    <th style="text-align: center;" class="align-middle">TALLER</th>
                                    <th style="text-align: center;" class="align-middle"><div class="sizeOpcion">ULTO. MTTO.</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="principal in arrayPrincipal" :key="principal.id">
                                    <td style="text-align: center;" class="align-middle">
                                        <button @click="cambiar(principal)" type="button" class="btn btn-primary btn-sm">
                                            <i class="icon-eye"></i>
                                        </button> &nbsp;
                                        <button type="button" @click="abrirModal('principal', 'registrar', principal)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                            <i class="icon-plus"></i>
                                        </button> &nbsp;
                                    </td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.idAVL">Equipos</td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.Name"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.Plate"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.Fleet"></td>      
                                    <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.kms_inicial"></td>
                                    <template v-if="principal.mantenimiento != null">
                                        <td v-if="principal.vehiculo.kms_inicial < principal.mantenimiento.kms_goal" style="text-align: center;" class="align-middle bg-success" v-text="principal.mantenimiento.kms_goal"></td>
                                        <td v-else-if="principal.vehiculo.kms_inicial >= principal.mantenimiento.kms_goal && principal.vehiculo.kms_inicial <= (principal.mantenimiento.kms_goal * 1.15)" style="text-align: center;" class="align-middle bg-warning" v-text="principal.mantenimiento.kms_goal"></td>
                                        <td v-else style="text-align: center;" class="align-middle bg-danger" v-text="principal.mantenimiento.kms_goal"></td>
                                        <td style="text-align: center;" class="align-middle" v-text="principal.mantenimiento.kms_ini"></td>
                                        <td style="text-align: center;" class="align-middle" v-text="principal.mantenimiento.tipomanto.nombre"></td>
                                        <td style="text-align: center;" class="align-middle" v-text="principal.mantenimiento.taller.nombre"></td>
                                        <td style="text-align: center;" class="align-middle" v-text="principal.mantenimiento.date"></td>
                                    </template>
                                    <template v-else>
                                        <td style="text-align: center;" class="align-middle"></td>
                                        <td style="text-align: center;" class="align-middle"></td>
                                        <td style="text-align: center;" class="align-middle"></td>
                                        <td style="text-align: center;" class="align-middle"></td>
                                        <td style="text-align: center;" class="align-middle"></td>
                                    </template>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <span class="page-stats">Del {{pagination.from}} al {{pagination.to}} de un total de  {{pagination.total}} registros.</span>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio, criterio2, select_taller, select_tipomanto)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio, criterio2, desde, hasta, select_taller, select_tipomanto)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio, criterio2, desde, hasta, select_taller, select_tipomanto)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </template>
                    <template v-else>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button @click="cambiar2" class="btn btn-primary"><i class="fa fa-back"></i> VOLVER</button>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                    <th style="text-align: center;">ESTADO</th>
                                    <th style="text-align: center;">MANTENIMIENTO ASIGNADO</th>
                                    <th style="text-align: center;">CANTIDAD</th>
                                    <th style="text-align: center;">UNIDAD DE MEDIDA</th>
                                    <th style="text-align: center;">ASIGNADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="historial in arrayHistorial" :key="historial.id">
                                    <td style="text-align: center;" class="align-middle">FINALIZADO</td>
                                    <td style="text-align: center;" class="align-middle" v-text="historial.tipomanto.nombre"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="historial.tipomanto.cantidad"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="historial.tipomanto.umedida"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="historial.date"></td>                
                                </tr>
                            </tbody>
                        </table>
                    </template>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" @click="cerrarModal()" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary" @click="refrescarOdometro(vehiculo, fecha)"><i class="icon-refresh"></i>  &nbsp; REFRESCAR ODÓMETRO</button>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">FECHA:</label>
                                <div class="col-md-3">
                                    <input type="date" v-model="fecha" :min="fecha_minima" class="form-control">
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">HORA:</label>
                                <div class="col-md-3">
                                    <input type="time" v-model="hora" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">VEHÍCULO:</label>
                                <div class="col-md-9">
                                    <label class="col-md-9 form-control-label" for="text-input" v-text="nombre + '-' + placa + '-' + idAVL"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">ODO SW INICIAL:</label>
                                <div class="col-md-3">
                                    <label class="col-md-3 form-control-label" for="text-input" v-text="odoswinicial"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">ODO HW INICIAL:</label>
                                <div class="col-md-3">
                                    <label class="col-md-3 form-control-label" for="text-input" v-text="odohwinicial"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">TALLER (*):</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="taller1">
                                        <option value="">SELECCIONE UN TALLER</option>
                                        <option v-for="taller in arrayTaller" :key="taller.id" :value="taller.id" v-text="taller.nombre"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">TIPO MANTENIMIENTO (*):</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="tipomanto1" @change="obtenerInfoTipomanto(tipomanto1)">
                                        <option value="">SELECCIONE UN TIPO DE MANTENIMIENTO</option>
                                        <option v-for="tipomanto in arrayTipomanto" :key="tipomanto.id" :value="tipomanto.id" v-text="tipomanto.nombre"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">CANTIDAD:</label>
                                <div class="col-md-3">
                                    <label class="col-md-3 form-control-label" for="text-input" v-text="cantidad"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">UNIDAD DE MEDIDA:</label>
                                <div class="col-md-3">
                                    <label class="col-md-3 form-control-label" for="text-input" v-text="umedida"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">COSTO MANTENIMIENTO:</label>
                                <div class="col-md-9">
                                    <input type="number" step="0.01" v-model="costo" class="form-control" placeholder="INGRESE EL COSTO DEL MANTENIMIENTO">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">CORREO ALERTA:</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="correoalerta" class="form-control" placeholder="INGRESE UN CORREO PARA ALERTAS">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">ENVIO DE ALERTA NARANJA:</label>
                                <div class="col-md-3">
                                    <select class="form-control" v-model="alertanaranja">
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                                <label class="col-md-3 form-control-label" for="email-input">ENVIO DE ALERTA PROXIMA A VENCER:</label>
                                <div class="col-md-3">
                                    <select class="form-control" v-model="alertaproxima">
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">ENVIO DE ALERTA ROJA (VENCIDO):</label>
                                <div class="col-md-3">
                                    <select class="form-control" v-model="alertaroja">
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                                <label class="col-md-3 form-control-label" for="email-input">RECORDATORIO DIARIO (POR VENCERSE):</label>
                                <div class="col-md-3">
                                    <select class="form-control" v-model="recordatorioporven">
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">RECORDATORIO DIARIO (VENCIDO):</label>
                                <div class="col-md-3">
                                    <select class="form-control" v-model="recordatorioven">
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                                <label class="col-md-3 form-control-label" for="email-input">PORCENTAJE ALERTA POR VENCERSE:</label>
                                <div class="col-md-3">
                                    <input type="number" v-model="porcentajealerta" class="form-control" placeholder="PORCENTAJE">
                                </div>
                            </div>
                            <div v-show="errorMantenimiento" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjMantenimiento" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal()" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                        <button type="button" @click="registrarMantenimiento()" class="btn btn-primary">GUARDAR</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
        <!-- Inicio del modal Eliminar -->
        <!--div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">DETALLE DEL MANTENIMIENTO</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">ESTADO:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">TALLER NOMBRE:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">ENVIO ALERTAS:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">OBSERVACIONES:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">INICIO MANTO:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">FECHA MOD:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">HORA MOD:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                    </div>
                </div-->
                <!-- /.modal-content -->
            <!--/div-->
            <!-- /.modal-dialog -->
        <!--/div-->
        <!-- Fin del modal Eliminar -->
        <!-- Inicio del modal Detalle -->
        <!--div class="modal fade" id="modalDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">DETALLE DE COSTOS POR ITEM</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <h5>No hay registros para mostrar</h5>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                    </div>
                </div-->
                <!-- /.modal-content -->
            <!--/div-->
            <!-- /.modal-dialog -->
        <!--/div-->
        <!-- Fin del modal Eliminar -->
    </main>
    <!-- /Fin del contenido principal -->
</template>

<script>
    export default {

        data (){

            return {

                tabla : 1,
                prueba : '',
                loading : true,
                arrayTaller : [],
                arrayTipomanto : [],
                arrayPrincipal : [],
                arrayHistorial : [],
                fecha : '',
                fecha_minima : '',
                hora : '',
                vehiculo : '',
                nombre : '',
                placa : '',
                idAVL : '',
                odoswinicial : '',
                odohwinicial : '',
                taller1 : '',
                tipomanto1 : '',
                cantidad : '',
                umedida : '',
                correoalerta : '',
                costo : '',
                alertanaranja : 1,
                alertaproxima : 1,
                alertaroja : 1,
                recordatorioporven : 1,
                recordatorioven : 1,
                porcentajealerta:  '',
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorMantenimiento : 0,
                errorMostrarMsjMantenimiento : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'Name',
                criterio2 : 'tb_vehicles.kms_inicial',
                buscar : '',
                desde : '',
                hasta : '',
                minimo_desde : '',
                minimo_hasta : '',
                maximo_desde : '',
                select_taller : '',
                select_tipomanto : ''

            }

        },

        computed : {

            isActived : function(){
                return this.pagination.current_page;
            },

            pagesNumber: function() {

                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;

                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);

                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];

                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;

            }

        },

        methods : {

            listarPrincipal(page, buscar, criterio, criterio2, desde, hasta, select_taller, select_tipomanto){

                let me = this;
                var url = '/principales?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&criterio2=' + criterio2 + '&desde=' + desde + '&hasta=' + hasta + '&select_taller=' + select_taller + '&select_tipomanto=' + select_tipomanto;
                
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayPrincipal = respuesta.principales.data;
                    me.pagination = respuesta.pagination;
                    console.log(respuesta);
                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            listarHistorial(vehiculo, buscar, criterio){

                let me = this;
                var url = '/mantenimientos?vehiculo=' + vehiculo + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayHistorial = respuesta.mantenimientos;
                    console.log(respuesta);
                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            cambiarPagina(page, buscar, criterio, criterio2, desde, hasta, select_taller, select_tipomanto){
                
                let me = this;

                me.pagination.current_page = page;
                me.listarPrincipal(page, buscar, criterio, criterio2, desde, hasta, select_taller, select_tipomanto);

            },

            registrarMantenimiento(){

                if(this.validarMantenimiento()){

                    return;
                    
                }

                let me = this;

                axios.post('/mantenimientos/registrar', {

                    'vehiculo': this.vehiculo,
                    'fecha': this.fecha,
                    'hora' : this.hora,
                    'odohwinicial' : this.odohwinicial,
                    'cantidad' : this.cantidad,
                    'taller' : this.taller1,
                    'tipomanto' : this.tipomanto1,
                    'correoalerta' : this.correoalerta,
                    'costo' : this.costo,
                    'alertaroja' : this.alertaroja,
                    'alertanaranja' : this.alertanaranja,
                    'alertaproxima' : this.alertaproxima,
                    'recordatorioporven' : this.recordatorioporven,
                    'recordatorioven' : this.recordatorioven,
                    'porcentajealerta' : this.porcentajealerta

                }).then(function (response) {

                    me.listarPrincipal(1, '', 'Name', '', 'tb_vehicles.kms_inicial', '', '');
                    me.cerrarModal();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'MANTENIMIENTO INGRESADO CON ÉXITO!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

            validarMantenimiento(){
                
                this.errorMantenimiento = 0;
                this.errorMostrarMsjMantenimiento = [];

                if(!this.taller1 || this.taller1 == "0") this.errorMostrarMsjMantenimiento.push("DEBE SELECCIONAR UN TALLER PARA EL MANTENIMIENTO.");
                if(!this.tipomanto1 || this.tipomanto1 == "0") this.errorMostrarMsjMantenimiento.push("DEBE SELECCIONAR UN TIPO DE MANTENIMIENTO PARA EL MANTENIMIENTO.");
                if(!this.porcentajealerta) this.errorMostrarMsjMantenimiento.push("DEBE INGRESAR UN PORCENTAJE DE ALERTA");
                if(this.errorMostrarMsjMantenimiento.length) this.errorMantenimiento = 1;

                return this.errorMantenimiento;

            },

            selectTaller(){

                let me = this;
                var url = '/talleres/selectTaller';
                
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayTaller = respuesta.talleres;
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            selectTipomanto(){

                let me = this;
                var url = '/tipomantos/selectTipomanto';
                
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayTipomanto = respuesta.tipomantos;
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            fechaActual2(){
                
                let hoy = new Date();

                let dd = hoy.getDate();
                let mm = hoy.getMonth()+1;
                let yyyy = hoy.getFullYear();
                let hh = hoy.getHours();
                let min = hoy.getMinutes();

                if(dd < 10){
                    dd = '0'+dd;
                }

                if(mm < 10){
                    mm = '0'+mm;
                }

                if(hh < 10){
                    hh = '0'+hh;
                }

                if(min < 10){
                    min = '0'+min;
                }
        
                this.fecha = yyyy + '-' + mm + '-' + dd;
                this.hora = hh + ':' + min;

            },

            abrirModal(modelo, accion, data = []){

                this.selectTaller();
                this.selectTipomanto();
                this.fechaActual2();

                switch (modelo) {

                    case 'principal':
                        
                        {

                            switch (accion) {
                                
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'INGRESO DE ASIGNACIÓN DE MANTENIMIENTO A LOS VEHÍCULOS';
                                        this.vehiculo = data['vehiculo'].id;
                                        this.nombre = data['vehiculo'].Name;
                                        this.placa = data['vehiculo'].Plate;
                                        this.idAVL = data['vehiculo'].idAVL;
                                        this.correoalerta = data['vehiculo'].correo;
                                        this.taller1 = data['mantenimiento'].taller.id;
                                        this.tipomanto1 = data['mantenimiento'].tipomanto.id;
                                        this.cantidad = data['mantenimiento'].tipomanto.cantidad;
                                        this.umedida = data['mantenimiento'].tipomanto.umedida;
                                        this.fecha_minima = data['mantenimiento'].date;
                                        //this.odohwinicial = data['vehiculo'].kms_inicial;
                                        this.tipoAccion = 1;
                                        break;
                                    }
                            
                            }

                        }
                        
                }
            },

            cerrarModal(){

                this.modal = 0;
                this.tituloModal = '';
                this.arrayTaller = [];
                this.arrayTipomanto = [];
                this.fecha = '';
                this.hora = '';
                this.vehiculo = '';
                this.nombre = '';
                this.placa = '';
                this.idAVL = '';
                this.odoswinicial = '';
                this.odohwinicial = '';
                this.taller1 = '';
                this.tipomanto1 = '';
                this.cantidad = '';
                this.umedida = '';
                this.correoalerta = '';
                this.alertanaranja = 1;
                this.alertaproxima = 1;
                this.alertaroja = 1;
                this.recordatorioporven = 1;
                this.recordatorioven = 1;
                this.porcentajealerta =  '';
                this.errorMantenimiento = 0;
                this.errorMostrarMsjMantenimiento = [];
            },

            cambiar(p){
                let me = this;
                
                me.loading = false;

                me.listarHistorial(p.vehiculo.id, me.buscar, me.criterio);

                //me.$root.menu = 2;
            },

            cambiar2(){
                let me = this;
                
                me.loading = true;
                me.arrayHistorial = [];

                //me.$root.menu = 2;
            },

            obtenerInfoTipomanto(r){
                console.log(r);
                let me = this;
                var url = '/tipomantos/info?id_tipomanto=' + r;
                
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.cantidad = respuesta.tipomantos.cantidad;
                    me.umedida = respuesta.tipomantos.umedida;
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            refrescarOdometro(vehiculo, fecha){

                console.log(vehiculo);
                let me = this;
                var url = '/vehiculos/historial?vehiculo=' + vehiculo + '&fecha=' + fecha;
                
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.odohwinicial = respuesta.distancia
                    //me.arrayTaller = respuesta.talleres;
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })
            },

            cambiarKmDesde(){

                if(this.desde == '' && this.hasta != ''){
                    this.desde = this.hasta;
                    this.maximo_desde = this.hasta;
                }else if(this.hasta == ''){
                    this.desde = '';
                }else{
                    this.maximo_desde = this.hasta;
                }

                this.listarPrincipal(1, this.buscar, this.criterio, this.criterio2, this.desde, this.hasta, this.select_taller, this.select_tipomanto);
                
            },

            cambiarKmHasta(){

                if(this.hasta == '' && this.desde != ''){

                    this.hasta = this.desde;
                    this.minimo_hasta = this.desde;
                    this.maximo_desde = this.hasta;

                }else if(this.desde == ''){
                    this.hasta = '';
                }else{
                    this.maximo_desde = this.hasta;
                    this.minimo_hasta = this.desde;
                }

                this.listarPrincipal(1, this.buscar, this.criterio, this.criterio2, this.desde, this.hasta, this.select_taller, this.select_tipomanto);             
            },

        },

        mounted() {
            
            this.listarPrincipal(1, this.buscar, this.criterio, this.criterio2, this.desde, this.hasta, this.select_taller, this.select_tipomanto);
            this.selectTaller();
            this.selectTipomanto();

        }
    }
</script>

<style>

    .modal-content{

        width: 100% !important;
        position: absolute !important;

    }

    .mostrar{

        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
        overflow-y: auto;

    }

    .div-error{

        display: flex;
        justify-content: center;

    }

    .text-error{
        color: blue !important;
        font-weight: bold;
    }

    .pagination > li > a{
        background-color: white;
        color: #20a8d8 !important;
    }

    .pagination > li > a:focus,
    .pagination > li > a:hover,
    .pagination > li > span:focus,
    .pagination > li > span:hover{
        color: #20a8d8 !important;
        background-color: #eee !important;
        border-color: #ddd !important;
    }

    .pagination > .active > a{
        color: white !important;
        background-color: #20a8d8 !important;
        border: solid 1px #20a8d8 !important;
    }

    .pagination > .active > a:hover{
        background-color: #20a8d8 !important;
        border: solid 1px #20a8d8 !important;
    }

    .sizeOpcion{
        width: 90px;
    }

</style>
