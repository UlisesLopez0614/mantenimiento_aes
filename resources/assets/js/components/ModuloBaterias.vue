<template>
    <!-- Contenido Principal -->
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Mantenimientos</a></li>
            <li class="breadcrumb-item active">Baterias</li>
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
                                    <input type="text" v-model="buscar" @keyup="listarPrincipal(1, buscar, criterio,  desde, hasta)" class="form-control" placeholder="Placa,Flota,Nombre,Area,Detalles de las baterias...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="input-group input-daterange">
                                    <div class="input-group-addon bg-primary">Fecha Instalacion</div>
                                    <div class="input-group-addon bg-primary">Inicio</div>
                                    <input type="date" v-model="desde" @change="cambiarHasta()" :max="fechaMaxima" class="form-control">
                                    <div class="input-group-addon bg-primary">Fin</div>
                                    <input type="date" v-model="hasta" @change="cambiardesde()" :max="fechaActual" :min="desde" class="form-control">
                                </div>
                            </div>
                        </div>

                        <table id="mi-tabla" class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                            <tr class="bg-primary">
                                <th style="text-align: center;" class="align-middle"></th>
                                <th style="text-align: center;" class="align-middle" colspan="7">VEHÍCULO</th>
                                <th style="text-align: center;" class="align-middle" colspan="8">DATOS MECANICOS</th>

                            </tr>
                            <tr class="bg-primary">
                                <th style="text-align: center;" class="align-middle"><div class="sizeOpcion">OPCIONES</div></th>
                                <th style="text-align: center;" class="align-middle">NOMBRE</th>
                                <th style="text-align: center;" class="align-middle">PLACA</th>
                                <th style="text-align: center;" class="align-middle">EMPRESA</th>
                                <th style="text-align: center;" class="align-middle">AREA</th>
                                <th style="text-align: center;" class="align-middle">TIPO DE VEHICULO</th>
                                <th style="text-align: center;" class="align-middle">KM ACTUAL</th>
                                <th style="text-align: center;" class="align-middle">TOTAL DE BATERAS ASIGNADAS</th>

                                <th style="text-align: center;" class="align-middle">CANTIDAD DE BATERIAS INSTALADAS</th>
                                <th style="text-align: center;" class="align-middle">TIPO DE BATERIA</th>
                                <th style="text-align: center;" class="align-middle">MECANICO</th>
                                <th style="text-align: center;" class="align-middle">MONTO</th>
                                <th style="text-align: center;" class="align-middle">NUMERO DE AVISO</th>
                                <th style="text-align: center;" class="align-middle">ORDEN DE TRABAJO</th>
                                <th style="text-align: center;" class="align-middle">DISPOSICION FINAL</th>
                                <th style="text-align: center;" class="align-middle"><div class="sizeOpcion">FECHA INSTALACION</div></th>

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
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.Name"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.Plate"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.Fleet"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.Area"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.type"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.kms_inicial"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.tbaterias"></td>
                                <template v-if="principal.baterias != null">
                                    <td style="text-align: center;" class="align-middle" v-text="principal.baterias.Qty"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.baterias.Tipo_Bateria"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.baterias.mecanico"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="'$' + principal.baterias.Amount"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.baterias.Numero_Aviso"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.baterias.Orden_Trabajo"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.baterias.Disposicion_Final"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.baterias.Installation_Date"></td>
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
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio,  select_taller, select_tipomanto)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio,  desde, hasta)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio,  desde, hasta)">Sig</a>
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
                                <label class="form-control-label" >NOMBRE:</label>
                                <label class="form-control-label"  v-text="nombre"></label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-control-label" >PLACA:</label>
                                <label class="form-control-label"  v-text="placa"></label>
                            </div>
                            <div class="col-md-3">
                                <label class="form-control-label" >FLOTA:</label>
                                <label class="form-control-label"  v-text="flota"></label>
                            </div>
                            <div class="col-md-3">
                                <label class="form-control-label" >AREA:</label>
                                <label class="form-control-label"  v-text="area"></label>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                            <tr class="bg-primary">
                                <th style="text-align: center;">TIPO BATERIA</th>
                                <th style="text-align: center;">MECANICO</th>
                                <th style="text-align: center;">FECHA DE INSTALACION </th>
                                <th style="text-align: center;">NUMERO AVISO</th>
                                <th style="text-align: center;">ORDEN DE TRABAJO</th>
                                <th style="text-align: center;">DISPOSICION FINAL</th>
                                <th style="text-align: center;">MONTO</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="historial in arrayHistorial" :key="historial.id">
                                <td style="text-align: center;" class="align-middle" v-text="historial.Tipo_Bateria"></td>
                                <td style="text-align: center;" class="align-middle" v-text="historial.mecanico"></td>
                                <td style="text-align: center;" class="align-middle" v-text="historial.Installation_Date"></td>
                                <td style="text-align: center;" class="align-middle" v-text="historial.Numero_Aviso"></td>
                                <td style="text-align: center;" class="align-middle" v-text="historial.Orden_Trabajo"></td>
                                <td style="text-align: center;" class="align-middle" v-text="historial.Disposicion_Final"></td>
                                <template v-if="historial.Amount == null">
                                    <td style="text-align: center;" class="align-middle" v-text="'$0.00'"></td>
                                </template>
                                <template v-else>
                                    <td style="text-align: center;" class="align-middle" v-text="'$' + historial.Amount"></td>
                                </template>
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
                                <label class="col-md-3 form-control-label"><b>FECHA DE INSTALACION:</b></label>
                                <div class="col-md-3">
                                    <input type="date" v-model="fecha" :min="fecha_minima" class="form-control" required>
                                </div>
                                <label class="col-md-3 form-control-label" >VEHÍCULO:</label>
                                <div class="col-md-3">
                                    <label class="col-md-9 form-control-label"  v-text="nombre"></label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" >TIPO BATERIA (*):</label>
                                <div class="col-md-9">
                                    <input v-model="tipo_bateria" class="form-control" placeholder="BATERIA YELLOW TOP" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" >MECANICO (*):</label>
                                <div class="col-md-9">
                                    <input v-model="mecanico" class="form-control" placeholder="NOMBRE DEL MECANICO QUE REALIZO LA INSTALACION" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" >CANTIDAD  DE BATERIAS INSTALADAS (*) :</label>
                                <div class="col-md-3">
                                    <input type="number" step="1" v-model="qty_battery" class="form-control" placeholder="CANTIDAD DE BATERIAS INSTALADAS">
                                </div>
                                <label class="col-md-3 form-control-label" >MONTO:</label>
                                <div class="col-md-3">
                                    <input type="number" step="1" v-model="amount" class="form-control" placeholder="$ 20.00" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" >NUMERO DE AVISO (*):</label>
                                <div class="col-md-9">
                                    <input v-model="numero_aviso" class="form-control" placeholder="EX: 1000322466" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" >ORDEN DE TRABAJO (*):</label>
                                <div class="col-md-9">
                                    <input v-model="orden_trabajo" class="form-control" placeholder="EX: 2000643229" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" >DISPOSICION FINAL :</label>
                                <div class="col-md-9">
                                    <input v-model="disposicion_final" class="form-control" placeholder="EX: A003">
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

    </main>
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
            nombre : '',
            fecha_minima : '',
            hora : '',

            fecha : '',
            vehiculo : '',
            tipo_bateria : '',
            mecanico : '',
            qty_battery: 1,
            amount : 30,
            numero_aviso:'',
            orden_trabajo:'',
            disposicion_final:'',

            placa : '',
            idAVL : '',
            odoswinicial : '',
            odohwinicial : '',
            taller1 : '',
            tipomanto1 : '',
            cantidad : '',
            umedida : '',

            costo : '',
            alertanaranja : 1,
            alertaproxima : 1,
            alertaroja : 1,
            recordatorioporven : 1,
            recordatorioven : 1,
            porcentajealerta:  5,
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
            buscar : '',
            minimo_desde : '',
            minimo_hasta : '',
            maximo_desde : '',

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
            var url = '/baterias?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio  + '&desde=' + desde + '&hasta=' + hasta ;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayPrincipal = respuesta.principales.data;
                me.pagination = respuesta.pagination;
            })
                .catch(function (error) {

                    console.log(error);

                })

        },

        listarHistorial(vehiculo){

            let me = this;
            var url = '/battery_records?vehiculo=' + vehiculo;
            console.log("URL : "+url);
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayHistorial = respuesta.mantenimientos;
                console.log(respuesta);
            })
                .catch(function (error) {

                    console.log(error);

                })

        },

        cambiarPagina(page, buscar, criterio,  desde, hasta){

            let me = this;

            me.pagination.current_page = page;
            me.listarPrincipal(page, buscar, criterio,  desde, hasta);

        },

        registrarMantenimiento(){

            if(this.validarMantenimiento()){

                return;

            }

            let me = this;

            axios.post('/baterias/registrar', {

                'vehiculo': this.vehiculo,
                'tipo_bateria': this.tipo_bateria,
                'mecanico' : this.mecanico,
                'qty_battery' : this.qty_battery,
                'amount' : this.amount,
                'numero_aviso' : this.numero_aviso,
                'orden_trabajo' : this.orden_trabajo,
                'disposicion_final' : this.disposicion_final,
                'Installation_Date' : this.fecha,

            }).then(function (response) {

                me.listarPrincipal(1, '', 'Name', '', 'vehicles.kms_inicial', '', '');
                me.cerrarModal();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'MANTENIMIENTO REGISTRADO CON ÉXITO!',
                    showConfirmButton: false,
                    timer: 1500
                });

            }).catch(function (error) {
                console.log(error);
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Hubo un error al ingresar los datos, intente de nuevo porfavor!',
                    showConfirmButton: false,
                    timer: 1500
                });

            });

        },

        validarMantenimiento(){

            this.errorMostrarMsjMantenimiento = [];

            if(!this.fecha) this.errorMostrarMsjMantenimiento.push("Ingrese una fecha");
            if(!this.vehiculo) this.errorMostrarMsjMantenimiento.push("Error de Vehiculo");
            if(!this.tipo_bateria) this.errorMostrarMsjMantenimiento.push("Ingrese el tipo de bateria");
            if(!this.mecanico)this.errorMostrarMsjMantenimiento.push("Ingrese el nombre del mecanico");
            if(!this.qty_battery|| this.qty_battery  < 1 )this.errorMostrarMsjMantenimiento.push("Verifique la cantidad de baterias a instala");
            if(!this.amount || this.amount  < 1 )this.errorMostrarMsjMantenimiento.push("Verifique el monto del mantenimiento");
            if(!this.numero_aviso)this.errorMostrarMsjMantenimiento.push("Ingrese un numero de aviso");
            if(!this.orden_trabajo)this.errorMostrarMsjMantenimiento.push("Ingrese una orden de trabajo");
            if(this.errorMostrarMsjMantenimiento.length) this.errorMantenimiento = 1;
            return this.errorMantenimiento;

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

            this.fechaActual2();

            switch (modelo) {

                case 'principal':

                {

                    switch (accion) {

                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'INGRESO DE MANTENIMIENTO DE BATERIA';
                            this.vehiculo = data['vehiculo'].id;
                            this.nombre = data['vehiculo'].Name;
                            this.correoalerta = data['vehiculo'].correo;
                            this.taller1 = data['mantenimiento'].taller.id;
                            this.tipomanto1 = data['mantenimiento'].tipomanto.id;
                            this.cantidad = data['mantenimiento'].tipomanto.cantidad;
                            this.umedida = data['mantenimiento'].tipomanto.umedida;
                            this.fecha_minima = data['mantenimiento'].date;
                            this.odohwinicial = data['vehiculo'].kms_inicial;
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
            this.porcentajealerta =  5;
            this.errorMantenimiento = 0;
            this.errorMostrarMsjMantenimiento = [];
        },

        cambiar(p){

            let me = this;
            me.loading = false;
            me.placa = p.vehiculo.Plate;
            me.nombre = p.vehiculo.Name;
            me.flota = p.vehiculo.Fleet;
            me.area = p.vehiculo.Area;
            me.listarHistorial(p.vehiculo.id);
            //me.$root.menu = 2;
        },

        cambiar2(){
            let me = this;

            me.loading = true;
            me.placa = '';

            me.arrayHistorial = [];

            //me.$root.menu = 2;
        },

        obtenerInfoTipomanto(r){
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

        cambiarKmdesde(){

            if(this.desde == '' && this.hasta != ''){
                this.desde = this.hasta;
                this.maximo_desde = this.hasta;
            }else if(this.hasta == ''){
                this.desde = '';
            }else{
                this.maximo_desde = this.hasta;
            }

            this.listarPrincipal(1, this.buscar, this.criterio, this. this.desde, this.hasta);

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

            this.listarPrincipal(1, this.buscar, this.criterio, this. this.desde, this.hasta);
        },

        cambiardesde(){

            let me = this;

            if(this.desde == '' && this.hasta != ''){
                this.desde = this.hasta;
                this.fechaMaxima = this.hasta;
            }else if(this.hasta == ''){
                this.desde = '';
                this.fechaActual2();
            }else{
                this.fechaMaxima = this.hasta;
            }

            this.listarPrincipal(1, me.buscar, me.criterio, me. me.desde, me.hasta);

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
                this.fechaActual2();
            }

            this.listarPrincipal(1, me.buscar, me.criterio, me. me.desde, me.hasta);

        },

    },

    mounted() {

        this.listarPrincipal(1, this.buscar, this.criterio, this.desde, this.hasta);

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

