<template>
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">HISTORIAL DE MANTENIMIENTO DE LUBRICANTES</li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white bg-primary">
                    <i class="fa fa-align-justify"></i> ESTADO DEL MANTENIMIENTO DE LOS VEHÍCULOS
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" v-model="buscar" @keyup="listarPrincipal(1, buscar,  desde, hasta)" class="form-control" placeholder="Placa,Nombre Vehiculo,Tipo de Vehiculo">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <div class="input-group input-daterange">
                                <div class="input-group-addon bg-primary">FECHA FINALIZACION MANTENIMIENTO</div>
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
                            <th style="text-align: center;" class="align-middle" colspan="6">VEHÍCULO</th>
                            <th style="text-align: center;" class="align-middle" colspan="9">DATOS TALLER</th>
                        </tr>
                        <tr class="bg-primary">
                            <th style="text-align: center;" class="align-middle">EQUIPO</th>
                            <th style="text-align: center;" class="align-middle">PLACA</th>
                            <th style="text-align: center;" class="align-middle">TIPO</th>

                            <th style="text-align: center;" class="align-middle">FECHA INGRESO TALLER</th>
                            <th style="text-align: center;" class="align-middle">TIPO REPARACION</th>
                            <th style="text-align: center;" class="align-middle">CANT. CUARTOS</th>
                            <th style="text-align: center;" class="align-middle">CANT. GALS </th>
                            <th style="text-align: center;" class="align-middle">FECHA SALIDA TALLER</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="principal in arrayPrincipal" :key="principal.id">
                            <td style="text-align: center;" class="align-middle" v-text="principal.Name"></td>
                            <td style="text-align: center;" class="align-middle" v-text="principal.Plate"></td>
                            <td style="text-align: center;" class="align-middle" v-text="principal.type"></td>
                            <template v-if="principal.Date_In_Workshop != null">
                                <td style="text-align: center;" class="align-middle" v-text="principal.Date_In_Workshop"></td>
                                <template v-if="principal.Tipo_Reparacion != null">
                                    <td style="text-align: center;" class="align-middle" v-text="principal.Tipo_Reparacion"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.Qty_Qts"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.Qty_Gals"></td>
                                    <td style="text-align: center;" class="align-middle" v-text="principal.Date_Out_Workshop"></td>
                                </template>
                                <template v-else>
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
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar,   desde, hasta)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar,  desde, hasta)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>
</template>

<script>

export default {

    data (){

        return {

            arrayPrincipal:[],
            fecha_minima:'',
            fecha:'',
            nombre:'',
            placa : '',
            idAVL : '',
            odoswinicial : '',
            odohwinicial : '',
            taller1 : '',
            tipomanto1 : '',
            cantidad : '',
            umedida : '',
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

        listarPrincipal(page, buscar,desde, hasta){

            let me = this;
            var url = '/listado-taller/lubricantes/history?page=' + page + '&q=' + buscar + '&desde=' + desde + '&hasta=' + hasta ;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayPrincipal = respuesta.records.data;
                me.pagination = respuesta.pagination;
            })
                .catch(function (error) {
                    console.log(error);
                })

        },



        cambiarPagina(page, buscar,   desde, hasta){

            let me = this;

            me.pagination.current_page = page;
            me.listarPrincipal(page, buscar,   desde, hasta);

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

            this.listarPrincipal(1, this.buscar, this. this. this.desde, this.hasta);

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

            this.listarPrincipal(1, this.buscar, this. this. this.desde, this.hasta);
        },

        cambiarDesde(){

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

            this.listarPrincipal(1, me.buscar, me.desde, me.hasta);

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

            this.listarPrincipal(1, me.buscar, me.desde, me.hasta);

        },

    },

    mounted() {

        this.listarPrincipal(1, this.buscar, this.desde, this.hasta);

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
