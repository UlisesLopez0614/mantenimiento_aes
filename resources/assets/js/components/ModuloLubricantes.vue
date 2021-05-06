<template>
    <!-- Contenido Principal -->
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Mantenimientos</a></li>
            <li class="breadcrumb-item active">Lubricantes</li>
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
                                    <input type="text" v-model="buscar" @keyup="listarPrincipal(1, buscar, criterio,  desde, hasta)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="input-group input-daterange">
                                    <div class="input-group-addon bg-primary">SALIDA DE FLOTA</div>
                                    <div class="input-group-addon bg-primary">DESDE</div>
                                    <input type="date" v-model="desde" @change="cambiarHasta()" :max="fechaMaxima" class="form-control">
                                    <div class="input-group-addon bg-primary">HASTA</div>
                                    <input type="date" v-model="hasta" @change="cambiarDesde()" :max="fechaActual" :min="desde" class="form-control">
                                </div>
                            </div>
                        </div>
                        <table id="mi-tabla" class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                            <tr class="bg-primary">
                                <th style="text-align: center;" class="align-middle"></th>
                                <th style="text-align: center;" class="align-middle" colspan="6">VEHÍCULO</th>
                                <th style="text-align: center;" class="align-middle" colspan="9">MANTENIMIENTO</th>
                            </tr>
                            <tr class="bg-primary">
                                <th style="text-align: center;" class="align-middle"><div class="sizeOpcion">OPCIONES</div></th>
                                <th style="text-align: center;" class="align-middle">EQUIPO</th>
                                <th style="text-align: center;" class="align-middle">PLACA</th>
                                <th style="text-align: center;" class="align-middle">FLOTA</th>
                                <th style="text-align: center;" class="align-middle">AREA</th>
                                <th style="text-align: center;" class="align-middle">TIPO</th>
                                <th style="text-align: center;" class="align-middle">KM ACTUAL</th>

                                <th style="text-align: center;" class="align-middle">TALLER EXTERNO</th>
                                <th style="text-align: center;" class="align-middle">FECHA SALIDA FLOTA</th>
                                <th style="text-align: center;" class="align-middle">FECHA INGRESO TALLER</th>
                                <th style="text-align: center;" class="align-middle">TIPO REPARACION</th>
                                <th style="text-align: center;" class="align-middle">CANT. CUARTOS</th>
                                <th style="text-align: center;" class="align-middle">CANT. GALS </th>
                                <th style="text-align: center;" class="align-middle">FECHA SALIDA TALLER</th>
                                <th style="text-align: center;" class="align-middle">FECHA INGRESO FLOTA</th>
                                <th style="text-align: center;" class="align-middle">CICLO MTTO.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="principal in arrayPrincipal" :key="principal.id">
                                <td style="text-align: center;" class="align-middle">
                                    <button @click="cambiar(principal)" type="button" class="btn btn-primary btn-sm">
                                        <i class="icon-eye"></i>
                                    </button> &nbsp;
                                    <template v-if="principal.nombre ==null">
                                        <button type="button" @click="abrirModal(principal)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                            <i class="icon-plus"/>
                                        </button> &nbsp;
                                    </template>
                                    <template v-else>
                                        <template v-if="principal.Date_Out_Workshop!=null && principal.Date_In_Fleet ==null">
                                            <button type="button" @click="abrirModalIngreso(principal)" class="btn btn-warning btn-sm">
                                                <i class="icon-arrow-right-circle"/>
                                            </button> &nbsp;
                                        </template>
                                        <template v-if="principal.Date_In_Fleet != null">
                                            <button type="button" @click="abrirModal(principal)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                                <i class="icon-plus"/>
                                            </button> &nbsp;
                                        </template>
                                    </template>
                                </td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.Name"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.Plate"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.Fleet"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.Area"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.type"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.kms_inicial"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.nombre"></td>
                                <template v-if="principal.Date_In_Workshop != null">
                                    <td style="text-align: center;" class="align-middle" v-text="principal.Date_Out_Fleet"></td>
                                    <template v-if="principal.Date_In_Workshop != null">
                                        <td style="text-align: center;" class="align-middle" v-text="principal.Date_In_Workshop"></td>
                                        <template v-if="principal.Tipo_Reparacion != null">
                                            <td style="text-align: center;" class="align-middle" v-text="principal.Tipo_Reparacion"></td>
                                            <td style="text-align: center;" class="align-middle" v-text="principal.Qty_Qts"></td>
                                            <td style="text-align: center;" class="align-middle" v-text="principal.Qty_Gals"></td>
                                            <td style="text-align: center;" class="align-middle" v-text="principal.Date_Out_Workshop"></td>
                                            <td style="text-align: center;" class="align-middle" v-text="principal.Date_In_Fleet"></td>
                                            <td style="text-align: center;" class="align-middle">A{{principal.Ciclo_Mto}}</td>
                                        </template>
                                        <template v-else>
                                            <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                            <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                            <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                            <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                            <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                        <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                        <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                        <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                        <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                        <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                    </template>
                                </template>
                                <template v-else>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar</td>
                                </template>
                            </tr>
                            </tbody>
                        </table>
                        <nav>
                            <span class="page-stats">Del {{pagination.from}} al {{pagination.to}} de un total de  {{pagination.total}} registros.</span>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio,  desde, hasta)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio, desde, hasta)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </template>
                    <template v-else>
                        <div class="form-group row">
                            <div class="col-md-2">
                                <button @click="cambiar2" class="btn btn-primary"><i class="fa fa-back"></i> VOLVER</button>
                            </div>
                            <div class="col-md-2">
                                <label class="form-control-label" for="text-input">NOMBRE:</label>
                                <label class="form-control-label" for="text-input" v-text="nombre"></label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-control-label" for="text-input">PLACA:</label>
                                <label class="form-control-label" for="text-input" v-text="placa"></label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-control-label" for="text-input">FLOTA:</label>
                                <label class="form-control-label" for="text-input" v-text="flota"></label>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                            <tr class="bg-primary">
                                <th style="text-align: center;" class="align-middle">FECHA SALIDA FLOTA</th>
                                <th style="text-align: center;" class="align-middle">FECHA INGRESO TALLER</th>
                                <th style="text-align: center;" class="align-middle">TALLER EXTERNO</th>
                                <th style="text-align: center;" class="align-middle">TIPO REPARACION</th>
                                <th style="text-align: center;" class="align-middle">CANT. CUARTOS</th>
                                <th style="text-align: center;" class="align-middle">CANT. GALS </th>
                                <th style="text-align: center;" class="align-middle">FECHA SALIDA TALLER</th>
                                <th style="text-align: center;" class="align-middle">FECHA INGRESO FLOTA</th>
                                <th style="text-align: center;" class="align-middle">MONTO</th>
                                <th style="text-align: center;" class="align-middle">CICLO MTTO.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="historial in arrayHistorial" :key="historial.id">
                                <td style="text-align: center;" class="align-middle" v-text="historial.Date_Out_Fleet"></td>
                                <template v-if="historial.Date_In_Workshop != null">
                                    <td style="text-align: center;" class="align-middle" v-text="historial.Date_In_Workshop"></td>
                                </template>
                                <template v-else>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar por el Taller</td>
                                </template>
                                <td style="text-align: center;" class="align-middle" v-text="historial.taller.nombre"></td>
                                <template v-if="historial.Date_In_Workshop != null">
                                    <td style="text-align: center;" class="align-middle" v-text="historial.Tipo_Reparacion"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="historial.Qty_Qts"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="historial.Qty_Gals"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="historial.Date_Out_Workshop"></td>
                                </template>
                                <template v-else>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar por el Taller</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar por el Taller</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar por el Taller</td>
                                    <td style="text-align: center;" class="align-middle">Sin Asignar por el Taller</td>
                                </template>
                                <template v-if="historial.Date_In_Fleet !=null">
                                    <td style="text-align: center;" class="align-middle" v-text="historial.Date_In_Fleet"></td>
                                </template>
                                <template v-else>
                                    <td style="text-align: center;" class="align-middle">Pendiente de Ingresar</td>
                                </template>
                                <template v-if="historial.Amount == null">
                                    <td style="text-align: center;" class="align-middle" v-text="'$0.00'"></td>
                                </template>
                                <template v-else>
                                    <td style="text-align: center;" class="align-middle" v-text="'$' + historial.Amount"></td>
                                </template>
                                <td style="text-align: center;" class="align-middle" v-text="historial.Ciclo_Mto"></td>
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
                                <label class="col-md-3 form-control-label"><b>FECHA DE SALIDA DE FLOTA :</b></label>
                                <div class="col-md-3">
                                    <input type="date" v-model="fleet_leaving" :min="fecha_minima" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">TALLER (*):</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="taller">
                                        <option value="">SELECCIONE UN TALLER</option>
                                        <option v-for="taller in arrayTaller" :key="taller.id" :value="taller.id" v-text="taller.nombre"></option>
                                    </select>
                                </div>
                            </div>
                            <div v-show="errorMantenimiento" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjlubricantes" :key="error" v-text="error"/>
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

        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalIn}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Registro de Reingreso a Flota</h4>
                        <button type="button" @click="cerrarModal()" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label"><b>FECHA DE INGRESO A FLOTA :</b></label>
                                <div class="col-md-3">
                                    <input type="date" v-model="fleet_incoming" :min="fecha_minima_ingreso" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Monto:</label>
                                <div class="col-md-3">
                                    <input type="number" step="1" v-model="costo" :min="1" class="form-control" placeholder="Monto">
                                </div>
                            </div>
                            <div v-show="errorMantenimiento" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMsgsIn" :key="error" v-text="error"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="cerrarModal()" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click="registrarIngreso()" class="btn btn-primary">Actualizar Mantenimiento</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
    <!-- /Fin del contenido principal -->
</template>

<script>

export default {

    name: "ModuloLubricantes",

    data (){

        return {

            tabla : 1,
            loading : true,
            arrayTaller : [],
            arrayTipomanto : [],
            arrayPrincipal : [],
            arrayHistorial : [],

            //Var Busqueda

            //Variables de Guardado de Datos
            fleet_leaving : '',
            fleet_incoming : '',
            fleet_ : '',
            fecha_minima : '',
            fecha_minima_ingreso:'',
            vehiculo : '',
            nombre : '',
            placa : '',
            taller : '',
            cantidad : '',
            costo : '',
            idRecord:'',
            //--- Variables de Controle de Modal
            modal : 0,
            modalIn : 0,
            //-------
            tituloModal : '',
            tipoAccion: 0,
            errorMantenimiento : 0,
            errorMostrarMsjMantenimiento : [],
            errorMostrarMsjlubricantes : [],
            errorMsgsIn:[],
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
            buscar : '',
            minimo_desde : '',
            minimo_hasta : '',
            maximo_desde : '',
            select_taller : '',
            select_tipomanto : '',
            desde : '',
            hasta : '',
            fechaMaxima : '',
            fechaActual : ''

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

        listarPrincipal(page, buscar, criterio,  desde, hasta){

            let me = this;
            var url = '/oil?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio  + '&desde=' + desde + '&hasta=' + hasta ;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                console.log(respuesta);
                me.arrayPrincipal = respuesta.principales.data;
                me.pagination = respuesta.pagination;
            })
                .catch(function (error) {
                    console.log(error);
                })

        },

        currentDate() {
            const current = new Date();
            let dd = current.getDate();
            let mm = current.getMonth()+1;

            if(dd < 10){
                dd = '0'+dd;
            }

            if(mm < 10){
                mm = '0'+mm;
            }
            const date = `${current.getFullYear()}-${mm}-${dd}`;
            this.fecha_minima = date;
        },

        listarHistorial(vehiculo){

            let me = this;
            var url = '/oil/records?vehiculo=' + vehiculo;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayHistorial = respuesta.mantenimientos;
                console.log(respuesta.mantenimientos);
            })
                .catch(function (error) {
                    console.log(error);
                })
        },

        cambiarPagina(page, buscar, criterio,  desde, hasta,){

            let me = this;

            me.pagination.current_page = page;
            me.listarPrincipal(page, buscar, criterio,  desde, hasta)

        },

        registrarMantenimiento(){

            if(this.validarMantenimiento()){

                return;

            }

            let me = this;

            axios.post('/oil/register', {

                'vehiculo': this.vehiculo,
                'Date_Out_Fleet': this.fleet_leaving,
                'taller' : this.taller

            }).then(function (response) {

                me.listarPrincipal(1, '', 'Name',  '', '');
                me.cerrarModal();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Informacion Archivada!!',
                    showConfirmButton: false,
                    timer: 1500
                });

            }).catch(function (error) {
                console.log(error);
            });

        },

        validarMantenimiento(){

            this.errorMantenimiento = 0;
            this.errorMostrarMsjlubricantes = [];

            if(!this.fleet_leaving) this.errorMostrarMsjpush("Debe Ingresar una fecha.");
            if(!this.taller ) this.errorMostrarMsjpush("Por favor seleccione un taller.");
            if(this.taller=='' ) this.errorMostrarMsjpush("Por favor seleccione un taller.");
            if(this.errorMostrarMsjlength) this.errorMantenimiento = 1;

            return this.errorMantenimiento;

        },

        registrarIngreso(){

            if(this.validarIngreso()){return;}

            let me = this;

            axios.post('/oil/update', {

                'id':this.idRecord,
                'Date_In': this.fleet_incoming,
                'Qty':this.costo

            }).then(function (response) {

                me.listarPrincipal(1, '', 'Name',  '', '');
                me.cerrarModal();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Informacion Archivada!!',
                    showConfirmButton: false,
                    timer: 1500
                });

            }).catch(function (error) {
                console.log(error);
            });

        },

        validarIngreso(){

            this.errorMantenimiento = 0;
            this.errorMsgsIn = [];

            if(!this.fleet_incoming) this.errorMsgsIn.push("Debe Ingresar una fecha.");
            if(!this.costo ) this.errorMsgsIn.push("Por favor el monto del mantenimiento.");
            if(this.errorMsgsIn.length) this.errorMantenimiento = 1;
            return this.errorMantenimiento;

        },

        selectTaller(){

            let me = this;
            var url = '/talleres/selectTaller';

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayTaller = respuesta.talleres;
            })
                .catch(function (error) {

                    console.log(error);

                })

        },

        abrirModal(data = []){

            this.selectTaller();
            this.currentDate();
            this.modal = 1;
            this.tituloModal = 'SALIDA DE FLOTA : ' + data.Name +" - "+data.Plate;
            this.vehiculo = data.vehicle_id;
            this.nombre = data.Name;
            this.placa = data.Plate;
        },

        cerrarModal(){

            this.modal = 0;
            this.modalIn=0;
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
            this.porcentajealerta =  5;
            this.errorMantenimiento = 0;
            this.errorMostrarMsjMantenimiento = [];
        },

        abrirModalIngreso(data = []){
            this.idRecord = data.lubricante_id;
            this.fecha_minima_ingreso = data.Date_Out_Workshop;
            const swalWithBootstrapButtons = Swal.mixin({

                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },

                buttonsStyling: false

            });

            swalWithBootstrapButtons.fire({

                title: 'Porfavor, confirme que el vehiculo esta dentro de las instalaciones',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'SÍ, ESTOY SEGURO!',
                cancelButtonText: 'NO, DEBO REVISAR!',
                reverseButtons: true

            }).then((result) => {

                if (result.value) {
                    this.modalIn = 1;
                }
            });
        },

        cambiar(p){

            let me = this;
            me.loading = false;
            me.placa = p.Plate;
            me.nombre = p.Name;
            me.flota = p.Fleet;

            me.listarHistorial(p.vehicle_id);

            //me.$root.menu = 2;
        },

        cambiar2(){
            let me = this;

            me.loading = true;
            me.placa = '';

            me.arrayHistorial = [];

            //me.$root.menu = 2;
        },

        cambiarDesde(){

            let me = this;
            console.log("Almenos llega aca?");
            if(this.desde == '' && this.hasta != ''){
                console.log("Hasta : "+ this.hasta);
                this.desde = this.hasta;
                console.log("Desde: "+ this.desde);
                this.fechaMaxima = this.hasta;
            }else if(this.hasta == ''){
                console.log("Hasta : "+ this.hasta);
                console.log("Desde: "+ this.desde);
                this.hasta = this.desde;
                console.log("------------");
                this.currentDate();
                console.log("Hasta : "+ this.hasta);
                console.log("Desde: "+ this.desde);
            }else{
                this.fechaMaxima = this.hasta;
                console.log("Desde: "+ this.desde);
            }
            this.listarPrincipal(1, me.buscar, me.criterio, me.desde, me.hasta)

        },

        cambiarHasta(){

            let me = this;
            if(this.hasta == '' && this.desde != ''){

                let hoy = new Date();

                let dd = hoy.getDate();
                let mm = hoy.getMonth()+1;
                let yyyy = hoy.getFullYear();

                if(dd < 10){
                    dd = '0'+dd;
                }

                if(mm < 10){
                    mm = '0'+mm;
                }

                this.hasta = yyyy + '-' + mm + '-' + dd;

            }else if(this.desde == ''){
                this.hasta = '';
                this.currentDate();
            }

            this.listarPrincipal(1, me.buscar, me.criterio, me.desde, me.hasta);

        },

    },

    mounted() {

        this.listarPrincipal(1, this.buscar, this.criterio, this.desde, this.hasta);
        this.selectTaller();
        this.currentDate();
    }
}

</script>
<style>

.modal-content{

    width: 100% !important;
    position: fixed !important;

}

.mostrar{

    display: list-item !important;
    opacity: 1 !important;
    position: fixed !important;
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
