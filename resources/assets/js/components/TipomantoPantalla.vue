<template>
    <!-- Contenido Principal -->
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Tipos Mantenimiento</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header text-white bg-primary">
                    <i class="fa fa-align-justify"></i> LISTADO DE TIPOS DE MANTENIMIENTO
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success text-white">
                                <i class="fa fa-file-excel-o"></i>&nbsp;EXCEL
                            </button>
                            <button type="button" @click="abrirModal('tipomanto', 'registrar')" class="btn btn-success" data-toggle="modal" data-target="#modalNuevo" title="NUEVO SUPERVISOR">
                                <i class="fa fa-plus-circle"></i>&nbsp;NUEVO
                            </button>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered table-striped table-sm">
                        <thead>
                            <tr class="bg-primary">
                                <th style="text-align: center;">OPCIONES</th>
                                <th style="text-align: center;">NOMBRE</th>
                                <th style="text-align: center;">CANTIDAD</th>
                                <th style="text-align: center;">UNIDAD DE MEDIDA</th>
                                <th style="text-align: center;">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="tipomanto in arrayTipomanto" :key="tipomanto.id">
                                <td style="text-align: center;">
                                    <button type="button" @click="abrirModal('tipomanto', 'actualizar', tipomanto)" class="btn btn-warning text-white btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                        <i class="fa fa-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="tipomanto.condicion">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarTipomanto(tipomanto.id)" title="DESACTIVAR TIPO MANTO">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-success btn-sm" @click="activarTipomanto(tipomanto.id)" title="ACTIVAR TIPO MANTO">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td style="text-align: center;" v-text="tipomanto.nombre"></td>
                                <td style="text-align: center;" v-text="tipomanto.cantidad"></td>
                                <td style="text-align: center;" v-text="tipomanto.umedida"></td>
                                <td style="text-align: center;">
                                    <div v-if="tipomanto.condicion">
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
                                <label class="col-md-3 form-control-label" >TIPO DE MANTENIMIENTO:</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="INGRESE UN NOMBRE PARA EL TIPO DE MANTENIMIENTO">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">CANTIDAD:</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="cantidad" min="0" class="form-control" placeholder="INGRESE LA CANTIDAD">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">UNIDAD DE MEDIDA:</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="umedida">
                                        <option value="">SELECCIONE UNA UNIDAD DE MEDIDA</option>
                                        <option value="KILOMETRO">KILÓMETRO</option>
                                        <option value="ESTANDAR">ESTANDAR</option>
                                    </select>
                                </div>
                            </div>
                            <div v-show="errorTipomanto" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjTipomanto" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="cerrarModal()">CERRAR</button>
                        <button type="button" v-if="tipoAccion==1" @click="registrarTipomanto()" class="btn btn-primary text-white">GUARDAR</button>
                        <button type="button" v-if="tipoAccion==2" @click="actualizarTipomanto()" class="btn btn-primary text-white">ACTUALIZAR</button>
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

                arrayTipomanto : [],
                tipomanto_id : 0,
                nombre : '',
                cantidad : '',
                umedida : '',
                porcentajealerta : '',
                condicion : true,
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorTipomanto : 0,
                errorMostrarMsjTipomanto : [],
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

            listarTipomanto(page, buscar, criterio){

                let me = this;
                var url = '/tipomantos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then(function (response) {

                    var respuesta = response.data;
                    me.arrayTipomanto = respuesta.tipomantos.data;
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
                me.listarTipomanto(page, buscar, criterio);

            },

            registrarTipomanto(){

                if(this.validarTipomanto()){

                    return;

                }

                let me = this;

                axios.post('/tipomantos/registrar', {

                    'nombre': this.nombre,
                    'cantidad': this.cantidad,
                    'umedida': this.umedida,
                    'porcentajealerta': this.porcentajealerta

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarTipomanto(1, '', 'nombre');

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarTipomanto(){

                if(this.validarTipomanto()){

                    return;

                }

                let me = this;

                axios.put('/tipomantos/actualizar', {

                    'nombre': this.nombre,
                    'cantidad': this.cantidad,
                    'umedida': this.umedida,
                    'porcentajealerta': this.porcentajealerta,
                    'id': this.tipomanto_id

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarTipomanto(1, '', 'nombre');

                }).catch(function (error) {

                    console.log(error);

                });

            },

            desactivarTipomanto(id){

                const swalWithBootstrapButtons = Swal.mixin({

                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },

                    buttonsStyling: false

                    })

                    swalWithBootstrapButtons.fire({

                        title: 'ESTÁ SEGURO DE DESACTIVAR A ESTE TIPO MANTENIMEINTO?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'SÍ, DESACTÍVALO!',
                        cancelButtonText: 'NO, CANCELAR!',
                        reverseButtons: true

                    }).then((result) => {

                        if (result.value) {

                            let me = this;

                            axios.put('/tipomantos/desactivar', {

                                'id': id

                            }).then(function (response) {

                                me.listarTipomanto(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'DESACTIVADO!',
                                    'EL TIPO MANTENIMIENTO HA SIDO DESACTIVADO.',
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

            activarTipomanto(id){

                const swalWithBootstrapButtons = Swal.mixin({

                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },

                    buttonsStyling: false

                    })

                    swalWithBootstrapButtons.fire({

                        title: 'ESTÁ SEGURO DE ACTIVAR A ESTE TIPO MANTENIMIENTO?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'SÍ, ACTÍVALO!',
                        cancelButtonText: 'NO, CANCELAR!',
                        reverseButtons: true

                    }).then((result) => {

                        if (result.value) {

                            let me = this;

                            axios.put('/tipomantos/activar', {

                                'id': id

                            }).then(function (response) {

                                me.listarTipomanto(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'ACTIVADO!',
                                    'EL TIPO MANTENIMIENTO HA SIDO ACTIVADO.',
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

            validarTipomanto(){

                this.errorTipomanto = 0;
                this.errorMostrarMsjTipomanto = [];

                if(!this.nombre) this.errorMostrarMsjTipomanto.push("EL NOMBRE DEL TIPO MANTENIMIENTO NO PUEDE IR VACÍO.");
                if(!this.cantidad) this.errorMostrarMsjTipomanto.push("LA CANTIDAD DEL TIPO MANTENIMIENTO NO PUEDE IR VACÍA.");
                if(!this.umedida) this.errorMostrarMsjTipomanto.push("LA UNIDAD DE MEDIDA DEL TIPO MANTENIMIENTO NO PUEDE IR VACÍA.");
                if(this.errorMostrarMsjTipomanto.length) this.errorTipomanto = 1;
                return this.errorTipomanto;

            },

            abrirModal(modelo, accion, data = []){

                switch (modelo) {

                    case 'tipomanto':

                        {

                            switch (accion) {

                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'REGISTRAR TIPO MANTENIMIENTO'
                                        this.nombre = '';
                                        this.cantidad = '';
                                        this.umedida = '';
                                        this.porcentajealerta = '';
                                        this.tipoAccion = 1;
                                        break;
                                    }

                                case 'actualizar':
                                    {
                                         //console.log(data);
                                         this.modal = 1;
                                         this.tituloModal = 'ACTUALIZAR TIPO MANTENIMIENTO';
                                         this.tipoAccion = 2;
                                         this.tipomanto_id = data['id'];
                                         this.nombre = data['nombre'];
                                         this.cantidad = data['cantidad'];
                                         this.umedida = data['umedida'];
                                         this.porcentajealerta = data['porcentajealerta'];
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
                this.cantidad = '';
                this.umedida = '';
                this.porcentajealerta = '';

            }

        },

        mounted() {

            this.listarTipomanto(1, this.buscar, this.criterio);

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
