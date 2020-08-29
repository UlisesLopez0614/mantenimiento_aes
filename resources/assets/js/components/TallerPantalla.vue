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
                    <i class="fa fa-align-justify"></i> LISTADO DE TALLERES
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success text-white">
                                <i class="fa fa-file-excel-o"></i>&nbsp;EXCEL
                            </button>
                            <button type="button" @click="abrirModal('taller', 'registrar')" class="btn btn-success" data-toggle="modal" data-target="#modalNuevo" title="NUEVO TALLER">
                                <i class="fa fa-plus-circle"></i>&nbsp;NUEVO
                            </button>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered table-striped table-sm">
                        <thead>
                            <tr class="bg-primary">
                                <th style="text-align: center;">OPCIONES</th>
                                <th style="text-align: center;">NOMBRE</th>
                                <th style="text-align: center;">DIRECCIÓN</th>
                                <th style="text-align: center;">NIT</th>
                                <th style="text-align: center;">CONTACTO</th>
                                <th style="text-align: center;">TELÉFONO</th>
                                <th style="text-align: center;">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="taller in arrayTaller" :key="taller.id">
                                <td style="text-align: center;">
                                    <button type="button" @click="abrirModal('taller', 'actualizar', taller)" class="btn btn-warning text-white btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                        <i class="fa fa-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="taller.condicion">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarTaller(taller.id)" title="DESACTIVAR TALLER">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-success btn-sm" @click="activarTaller(taller.id)" title="ACTIVAR TALLER">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td style="text-align: center;" v-text="taller.nombre"></td>
                                <td style="text-align: center;" v-text="taller.descripcion"></td>
                                <td style="text-align: center;" v-text="taller.nit"></td>
                                <td style="text-align: center;" v-text="taller.nombrecontacto"></td>
                                <td style="text-align: center;" v-text="taller.telefono"></td>
                                <td style="text-align: center;">
                                    <div v-if="taller.condicion">
                                        <span class="badge badge-success">ACTIVO</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger">INACTIVO</span>
                                    </div>
                                </td>
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
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                    
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
                                <label class="col-md-3 form-control-label" for="email-input">NOMBRE:</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" name="descripcion" class="form-control" placeholder="INGRESE UN NOMBRE PARA EL TALLER">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">DIRECCIÓN:</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="descripcion" name="descripcion" class="form-control" placeholder="INGRESE UNA DIRECCIÓN PARA EL TALLER">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">NIT:</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nit" name="descripcion" class="form-control" placeholder="INGRESE UN NIT PARA EL TALLER">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">NOMBRE CONTACTO:</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombrecontacto" name="descripcion" class="form-control" placeholder="INGRESE UN NOMBRE DE CONTACTO PARA EL TALLER">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">TELÉFONO:</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" name="descripcion" class="form-control" placeholder="INGRESE UN TELÉFONO PARA EL TALLER">
                                </div>
                            </div>
                            <div v-show="errorTaller" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjTaller" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="cerrarModal()">CERRAR</button>
                        <button type="button" v-if="tipoAccion==1" @click="registrarTaller()" class="btn btn-primary text-white">GUARDAR</button>
                        <button type="button" v-if="tipoAccion==2" @click="actualizarTaller()" class="btn btn-primary text-white">ACTUALIZAR</button>
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

        data (){

            return {

                arrayTaller : [],
                taller_id : 0,
                nombre : '',
                descripcion : '',
                nit : '',
                nombrecontacto : '',
                telefono: '',
                condicion : true,
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorTaller : 0,
                errorMostrarMsjTaller : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''

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

            listarTaller(page, buscar, criterio){

                let me = this;
                var url = '/talleres?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url).then(function (response) {

                    var respuesta = response.data;
                    me.arrayTaller = respuesta.talleres.data;
                    me.pagination = respuesta.pagination;
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            cambiarPagina(page, buscar, criterio){
                
                let me = this;

                me.pagination.current_page = page;
                me.listarTaller(page, buscar, criterio);

            },

            registrarTaller(){

                if(this.validarTaller()){

                    return;
                    
                }

                let me = this;

                axios.post('/talleres/registrar', {

                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'nit': this.nit,
                    'nombrecontacto': this.nombrecontacto,
                    'telefono': this.telefono,

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarTaller(1, '', 'nombre');

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarTaller(){

                if(this.validarTaller()){

                    return;
                    
                }

                let me = this;

                axios.put('/talleres/actualizar', {

                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'nit': this.nit,
                    'nombrecontacto': this.nombrecontacto,
                    'telefono': this.telefono,
                    'id': this.taller_id

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarTaller(1, '', 'nombre');

                }).catch(function (error) {

                    console.log(error);

                });

            },

            desactivarTaller(id){

                const swalWithBootstrapButtons = Swal.mixin({

                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },

                    buttonsStyling: false

                    })

                    swalWithBootstrapButtons.fire({
                    
                        title: 'ESTÁ SEGURO DE DESACTIVAR A ESTE TALLER?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'SÍ, DESACTÍVALO!',
                        cancelButtonText: 'NO, CANCELAR!',
                        reverseButtons: true

                    }).then((result) => {

                        if (result.value) {

                            let me = this;

                            axios.put('/talleres/desactivar', {

                                'id': id

                            }).then(function (response) {

                                me.listarTaller(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'DESACTIVADO!',
                                    'EL TALLER HA SIDO DESACTIVADO.',
                                    'success'
                                )

                            }).catch(function (error) {

                                console.log(error);

                            });

                            
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            
                        }

                });
            },

            activarTaller(id){

                const swalWithBootstrapButtons = Swal.mixin({

                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },

                    buttonsStyling: false

                    })

                    swalWithBootstrapButtons.fire({
                    
                        title: 'ESTÁ SEGURO DE ACTIVAR A ESTE TALLER?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'SÍ, ACTÍVALO!',
                        cancelButtonText: 'NO, CANCELAR!',
                        reverseButtons: true

                    }).then((result) => {

                        if (result.value) {

                            let me = this;

                            axios.put('/talleres/activar', {

                                'id': id

                            }).then(function (response) {

                                me.listarTaller(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'ACTIVADO!',
                                    'EL TALLER HA SIDO ACTIVADO.',
                                    'success'
                                )

                            }).catch(function (error) {

                                console.log(error);

                            });

                            
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            
                        }

                });
            },

            validarTaller(){
                
                this.errorTaller = 0;
                this.errorMostrarMsjTaller = [];

                if(!this.nombre) this.errorMostrarMsjTaller.push("EL NOMBRE DEL TALLER NO PUEDE IR VACÍO.");
                if(this.errorMostrarMsjTaller.length) this.errorTaller = 1;

                return this.errorTaller;

            },

            abrirModal(modelo, accion, data = []){

                switch (modelo) {

                    case 'taller':
                        
                        {

                            switch (accion) {
                                
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'REGISTRAR TALLER'
                                        this.nombre = '';
                                        this.descripcion = '';
                                        this.nit = '';
                                        this.nombrecontacto = '';
                                        this.telefono = '';
                                        this.tipoAccion = 1;
                                        break;
                                    }

                                case 'actualizar':
                                    {
                                         //console.log(data);
                                         this.modal = 1;
                                         this.tituloModal = 'ACTUALIZAR TALLER';
                                         this.tipoAccion = 2;
                                         this.taller_id = data['id'];
                                         this.nombre = data['nombre'];
                                         this.descripcion = data['descripcion'];
                                         this.nit = data['nit'];
                                         this.nombrecontacto = data['nombrecontacto'];
                                         this.telefono = data['telefono'];
                                         break;
                                    }
                            
                            }

                        }
                        
                }
            },

            cerrarModal(){

                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.descripcion = '';
                this.nit = '';
                this.nombrecontacto = '';
                this.telefono = '';

            }

        },

        mounted() {

            this.listarTaller(1, this.buscar, this.criterio);

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

</style>
