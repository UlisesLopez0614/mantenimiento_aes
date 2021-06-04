<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">HOME</li>
            <li class="breadcrumb-item"><a href="#">ADMIN</a></li>
            <li class="breadcrumb-item active">DASHBOARD </li>
        </ol>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            <i class="fa fa-align-justify"></i><strong>REPORTE DE MANTENIMIENTOS</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <div class="input-group input-daterange">
                                        <div class="input-group-addon">DESDE</div>
                                        <input type="date" v-model="desde" @change="cambiarHasta()" :max="fechaMaxima" class="form-control">
                                        <div class="input-group-addon">HASTA</div>
                                        <input type="date" v-model="hasta" @change="cambiarDesde()" :max="fechaActual" :min="desde" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" @click="generarReporte()" class="btn btn-primary text-white"><i class="fa fa-file-text"></i> GENERAR REPORTE</button>
                                </div>
                            </div>
                            <div v-show="errorReporte" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjReporte" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            <i class="fa fa-align-justify"></i><strong>REPORTE DE MANTENIMIENTOS DE LUBRICANTES</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <div class="input-group input-daterange">
                                        <div class="input-group-addon">DESDE</div>
                                        <input type="date" v-model="L_INICIO" @change="cambiarHastaL()" :max="L_MAX" class="form-control">
                                        <div class="input-group-addon">HASTA</div>
                                        <input type="date" v-model="L_FIN" @change="cambiarDesdeL()" :max="fechaActual" :min="L_INICIO" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" @click="generarReporteLubricantes()" class="btn btn-primary text-white"><i class="fa fa-file-text"></i> GENERAR REPORTE</button>
                                </div>
                            </div>
                            <div v-show="L_errorReporte" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in L_errorMostrarMsjReporte" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div><!-- LUBRICATES--->
            <br/>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            <i class="fa fa-align-justify"></i><strong>REPORTE DE MANTENIMIENTOS DE LLANTAS</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <div class="input-group input-daterange">
                                        <div class="input-group-addon">DESDE</div>
                                        <input type="date" v-model="Ll_INICIO" @change="cambiarHastaLL()" :max="Ll_MAX" class="form-control">
                                        <div class="input-group-addon">HASTA</div>
                                        <input type="date" v-model="Ll_FIN" @change="cambiarDesdeLL()" :max="fechaActual" :min="Ll_INICIO" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" @click="generarReporteLlantas()" class="btn btn-primary text-white"><i class="fa fa-file-text"></i> GENERAR REPORTE</button>
                                </div>
                            </div>
                            <div v-show="Ll_errorReporte" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in Ll_errorMostrarMsjReporte" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div> <!--- LLANTAS--->
            <br/>
            <div class="row"><!--- BATERAS --->>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            <i class="fa fa-align-justify"></i><strong>REPORTE DE MANTENIMIENTOS DE BATERIAS</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <div class="input-group input-daterange">
                                        <div class="input-group-addon">DESDE</div>
                                        <input type="date" v-model="B_INICIO" @change="cambiarHastaB()" :max="B_MAX" class="form-control">
                                        <div class="input-group-addon">HASTA</div>
                                        <input type="date" v-model="B_FIN" @change="cambiarDesdeB()" :max="fechaActual" :min="B_INICIO" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" @click="generarReporteBateria()" class="btn btn-primary text-white"><i class="fa fa-file-text"></i> GENERAR REPORTE</button>
                                </div>
                            </div>
                            <div v-show="B_errorReporte" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in B_errorMostrarMsjReporte" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import Vue from 'vue';
    import FileSaver from 'file-saver';
    export default {
        data (){
            return {
                // Mantenimientos Generales
                desde : '',
                hasta : '',
                fechaMaxima : '',
                fechaActual : '',
                errorReporte : 0,
                errorMostrarMsjReporte : [],

                //Mantenimientos de Lubricantes
                L_INICIO : '',
                L_FIN : '',
                L_MAX : '',
                L_ACTUAL : '',
                L_errorReporte : 0,
                L_errorMostrarMsjReporte : [],

                //Mantenimientos de Baterias
                B_INICIO : '',
                B_FIN : '',
                B_MAX : '',
                B_ACTUAL : '',
                B_errorReporte : 0,
                B_errorMostrarMsjReporte : [],

                //Mantenimientos de Llantas
                Ll_INICIO : '',
                Ll_FIN : '',
                Ll_MAX : '',
                Ll_ACTUAL : '',
                Ll_errorReporte : 0,
                Ll_errorMostrarMsjReporte : [],
            }

        },

        mounted(){
            this.fechaActual2();
        },

        methods : {

            generarReporte(){

                if(this.validarReporte()){
                    return;
                }

                let me = this;
                var url = '/reportes/consolidado/General?desde=' + me.desde + '&hasta=' + me.hasta;

                axios.get(url).then(function (response) {
                    axios.get('/reportes/Descargar_consolidado/General', {responseType: "blob"}).then((response) => {FileSaver.saveAs(response.data, 'CONSOLIDADO-MANTENIMIENTOS.xlsx');});
                }).catch(function (error) {
                    console.log(error);
                });

            },

            cambiarDesde(){

                if(this.desde == '' && this.hasta != ''){

                    this.desde = this.hasta;
                    this.fechaMaxima = this.hasta;

                }else if(this.hasta == ''){

                    this.desde = '';
                    this.fechaActual2();

                }else{

                    this.fechaMaxima = this.hasta;

                }

            },

            cambiarHasta(){

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

            },

            validarReporte(){

                this.errorReporte = 0;
                this.errorMostrarMsjReporte = [];
                if(!this.desde) this.errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA INICIAL.");
                if(!this.hasta) this.errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA FINAL.");

                if(this.errorMostrarMsjReporte.length) this.errorReporte = 1;
                return this.errorReporte;

            },

            // Metodos de Lubricantes

            generarReporteLubricantes(){

                if(this.validarReporteLubricante()){
                    return;
                }
                let me = this;
                var url = '/reportes/consolidado/Lubricantes?desde=' + me.L_INICIO + '&hasta=' + me.L_FIN;
                axios.get(url).then(function (response) {
                    axios.get('/reportes/Descargar_consolidado/Lubricantes', {responseType: "blob"}).then((response) => {FileSaver.saveAs(response.data, 'CONSOLIDADO_MANTENIMIENTOS_LUBRICANTES.xlsx');});
                }).catch(function (error) {console.log(error);});
            },

            cambiarDesdeL(){

                if(this.L_INICIO == '' && this.L_FIN != ''){

                    this.L_INICIO = this.L_FIN;
                    this.L_MAX = this.L_FIN;

                }else if(this.L_FIN == ''){

                    this.L_INICIO = '';
                    this.fechaActual2();

                }else{

                    this.L_MAX = this.L_FIN;

                }

            },

            cambiarHastaL(){

                if(this.L_FIN == '' && this.L_INICIO != ''){

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

                    this.L_FIN = yyyy + '-' + mm + '-' + dd;

                }else if(this.L_INICIO == ''){

                    this.L_FIN = '';
                    this.fechaActual2();

                }

            },

            validarReporteLubricante(){
                this.L_errorReporte = 0;
                this.L_errorMostrarMsjReporte = [];
                if(!this.L_INICIO) this.L_errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA INICIAL.");
                if(!this.L_FIN) this.L_errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA FINAL.");
                if(this.L_errorMostrarMsjReporte.length) this.L_errorReporte = 1;
                return this.L_errorReporte;
            },

            // Metodos de Baterias

            generarReporteBateria(){

                if(this.validarReporteBateria()){
                    return;
                }

                let me = this;
                var url = '/reportes/consolidado/Baterias?desde=' + me.B_INICIO + '&hasta=' + me.B_FIN;

                axios.get(url).then(function (response) {
                    axios.get('/reportes/Descargar_consolidado/Baterias', {responseType: "blob"}).then((response) => {FileSaver.saveAs(response.data, 'CONSOLIDADO-MANTENIMIENTOS.xlsx');});
                }).catch(function (error) {console.log(error);});
            },

            cambiarDesdeB(){
                if(this.B_INICIO == '' && this.B_FIN != ''){

                    this.B_INICIO = this.B_FIN;
                    this.B_MAX = this.B_FIN;

                }else if(this.B_FIN == ''){

                    this.B_INICIO = '';
                    this.fechaActual2();

                }else{
                    this.B_MAX = this.B_FIN;
                }

            },

            cambiarHastaB(){

                if(this.B_FIN == '' && this.B_INICIO != ''){

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

                    this.B_FIN = yyyy + '-' + mm + '-' + dd;

                }else if(this.B_INICIO == ''){

                    this.B_FIN = '';
                    this.fechaActual2();

                }

            },

            validarReporteBateria(){

                this.B_errorReporte = 0;
                this.B_errorMostrarMsjReporte = [];
                if(!this.B_INICIO) this.B_errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA INICIAL.");
                if(!this.B_FIN) this.B_errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA FINAL.");
                if(this.B_errorMostrarMsjReporte.length) this.B_errorReporte = 1;
                return this.B_errorReporte;
            },

            // Metodos de Llantas

            generarReporteLlantas(){

                if(this.validarReporteLlantas()){
                    return;
                }
                let me = this;
                var url = '/reportes/consolidado/Llantas?desde=' + me.Ll_INICIO + '&hasta=' + me.Ll_FIN;

                axios.get(url).then(function (response) {
                    axios.get('/reportes/Descargar_consolidado/Llantas', {responseType: "blob"}).then((response) => {FileSaver.saveAs(response.data, 'CONSOLIDADO-MANTENIMIENTOS.xlsx');});
                }).catch(function (error) {console.log(error);});
            },

            cambiarDesdeLL(){

                if(this.Ll_INICIO == '' && this.Ll_FIN != ''){

                    this.Ll_INICIO = this.Ll_FIN;
                    this.Ll_MAX = this.Ll_FIN;

                }else if(this.Ll_FIN == ''){

                    this.Ll_INICIO = '';
                    this.fechaActual2();

                }else{

                    this.Ll_MAX = this.Ll_FIN;

                }

            },

            cambiarHastaLL(){

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

            },

            validarReporteLlantas(){
                this.Ll_errorReporte = 0;
                this.Ll_errorMostrarMsjReporte = [];
                if(!this.Ll_INICIO) this.Ll_errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA INICIAL.");
                if(!this.Ll_FIN) this.Ll_errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA FINAL.");
                if(this.Ll_errorMostrarMsjReporte.length) this.Ll_errorReporte = 1;
                return this.Ll_errorReporte;
            },

            fechaActual2(){

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

                this.fechaActual = yyyy + '-' + mm + '-' + dd;
                this.L_MAX = yyyy + '-' + mm + '-' + dd;
                this.B_MAX = yyyy + '-' + mm + '-' + dd;
                this.Ll_MAX = yyyy + '-' + mm + '-' + dd;

            }
        }
    }
</script>
