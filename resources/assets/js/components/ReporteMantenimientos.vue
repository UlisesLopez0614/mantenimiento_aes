<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">HOME</li>
            <li class="breadcrumb-item"><a href="#">ADMIN</a></li>
            <li class="breadcrumb-item active">DASHBOARD</li>
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
        </div>
    </main>
</template>

<script>
    
    import Vue from 'vue';
    import FileSaver from 'file-saver';
    
    export default { 
        
        data (){

            return {
                desde : '',
                hasta : '',
                fechaMaxima : '',
                fechaActual : '',
                errorReporte : 0,
                errorMostrarMsjReporte : []
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
                var url = '/reportes/consolidado?desde=' + me.desde + '&hasta=' + me.hasta;

                axios.get(url).then(function (response) {
                    
                    axios.get('/reportes/consolidadoDescargar', {
                        
                        responseType: "blob"
                        
                    }).then((response) => {
                        
                        console.log(response.data);
                        FileSaver.saveAs(response.data, 'CONSOLIDADO-MANTENIMIENTOS.xlsx');
                        
                    });
                    
                    
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
                this.fechaMaxima = yyyy + '-' + mm + '-' + dd;

            },

            validarReporte(){

                this.errorReporte = 0;
                this.errorMostrarMsjReporte = [];
                if(!this.desde) this.errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA INICIAL.");
                if(!this.hasta) this.errorMostrarMsjReporte.push("DEBE SELECCIONAR UNA FECHA FINAL.");
        
                if(this.errorMostrarMsjReporte.length) this.errorReporte = 1;
                return this.errorReporte;

            }
            
        }

    }

</script>