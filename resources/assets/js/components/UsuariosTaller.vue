<template>
    <!-- Contenido Principal -->
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Usuarios Taller</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header text-white bg-primary">
                    <i class="fa fa-align-justify"></i> Listado de Usuarios por Taller
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" @click="abrirModal('usuarios', 'registrar')" class="btn btn-success" data-toggle="modal" data-target="#modalNuevo" title="NUEVO SUPERVISOR">
                                <i class="fa fa-plus-circle"></i>&nbsp;NUEVO
                            </button>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered table-striped table-sm">
                        <thead>
                        <tr class="bg-primary">
                            <th style="text-align: center;">OPCIONES</th>
                            <th style="text-align: center;">NOMBRE</th>
                            <th style="text-align: center;">EMAIL</th>
                            <th style="text-align: center;">Ultimo Login</th>
                            <th style="text-align: center;">TALLER</th>
                            <th style="text-align: center;">ESTADO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="usuarios in arrayusuarios" :key="usuarios.id">
                            <td style="text-align: center;">
                                <button type="button" @click="abrirModal('usuarios', 'actualizar', usuarios)" class="btn btn-warning text-white btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                    <i class="fa fa-pencil"></i>
                                </button> &nbsp;
                                <template v-if="usuarios.condicion">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarusuarios(usuarios.id)" title="DESACTIVAR TIPO MANTO">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-success btn-sm" @click="activarusuarios(usuarios.id)" title="ACTIVAR TIPO MANTO">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td style="text-align: center;" v-text="usuarios.nombre"></td>
                            <td style="text-align: center;" v-text="usuarios.email"></td>
                            <td style="text-align: center;" v-text="usuarios.ultimo_login"></td>
                            <td style="text-align: center;" v-text="usuarios.taller"></td>
                            <td style="text-align: center;">
                                <div v-if="usuarios.condicion">
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
                                <label class="col-md-3 form-control-label">Nombre:</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de Usuario" REQUIRED>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Email:</label>
                                <div class="col-md-3">
                                    <input type="email" v-model="email" min="0" class="form-control" placeholder="Ingrese Email del Usuario" required>
                                </div>
                                <label class="col-md-3 form-control-label">Contraseña:</label>
                                <div class="col-md-3">
                                    <input type="password" v-model="password" min="4" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Taller:</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="taller" required>
                                        <option value="">SELECCIONE UN TALLER</option>
                                        <option v-for="taller in arrayTaller" :key="taller.id" :value="taller.id" v-text="taller.nombre"></option>
                                    </select>
                                </div>
                            </div>
                            <div v-show="errorusuarios" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjusuarios" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="cerrarModal()">CERRAR</button>
                        <button type="button" v-if="tipoAccion==1" @click="registrarusuarios()" class="btn btn-primary text-white">GUARDAR</button>
                        <button type="button" v-if="tipoAccion==2" @click="actualizarusuarios()" class="btn btn-primary text-white">ACTUALIZAR</button>
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

            arrayusuarios : [],
            arrayTaller:[],
            usuarios_id : 0,
            nombre : '',
            porcentajealerta : '',
            condicion : true,
            modal : 0,
            tituloModal : '',
            tipoAccion: 0,
            errorusuarios : 0,
            errorMostrarMsjusuarios : [],
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            email:'',
            password:'',
            taller:''

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

        listarusuarios(page, buscar, criterio){

            let me = this;
            var url = '/usuarios-taller?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayusuarios = respuesta.records.data;
                me.pagination = respuesta.pagination;

            })
                .catch(function (error) {

                    console.log(error);

                })

        },

        cambiarPagina(page, buscar, criterio){

            let me = this;

            me.pagination.current_page = page;
            me.listarusuarios(page, buscar, criterio);

        },

        registrarusuarios(){

            if(this.validarusuarios()){

                return;

            }

            let me = this;

            axios.post('/usuarios-taller/registrar', {

                'name': this.nombre,
                'email':this.email,
                'password': this.password,
                'taller': this.taller,

            }).then(function (response) {

                me.cerrarModal();
                me.listarusuarios(1, '', 'nombre');

            }).catch(function (error) {

                console.log(error);

            });

        },

        actualizarusuarios(){

            if(this.validarusuarios()){

                return;

            }

            let me = this;

            axios.put('/usuarios-taller/actualizar', {

                'nombre': this.nombre,
                'cantidad': this.cantidad,
                'umedida': this.umedida,
                'porcentajealerta': this.porcentajealerta,
                'id': this.usuarios_id

            }).then(function (response) {

                me.cerrarModal();
                me.listarusuarios(1, '', 'nombre');

            }).catch(function (error) {

                console.log(error);

            });

        },

        desactivarusuarios(id){

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

                    axios.put('/usuarios-taller/desactivar', {

                        'id': id

                    }).then(function (response) {

                        me.listarusuarios(1, '', 'nombre');
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

        activarusuarios(id){

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

                    axios.put('/usuarios-taller/activar', {

                        'id': id

                    }).then(function (response) {

                        me.listarusuarios(1, '', 'nombre');
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

        validarusuarios(){

            this.errorusuarios = 0;
            this.errorMostrarMsjusuarios = [];

            if(!this.nombre) this.errorMostrarMsjusuarios.push("EL NOMBRE DEL USUARIOS.");
            if(!this.email) this.errorMostrarMsjusuarios.push("INGRESE UN CORREO ELECTRONICO.");
            if(!this.password) this.errorMostrarMsjusuarios.push("INGRESE UNA CONTRASEÑA VALIDA.");
            if(!this.taller) this.errorMostrarMsjusuarios.push("SELECCIONE UN TALLER.");
            if(this.errorMostrarMsjusuarios.length) this.errorusuarios = 1;

            return this.errorusuarios;

        },

        abrirModal(modelo, accion, data = []){

            switch (modelo) {

                case 'usuarios':

                {

                    switch (accion) {

                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'REGISTRAR NUEVO USUARIO DE TALLER'
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
                            this.usuarios_id = data['id'];
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
        this.selectTaller();
        this.listarusuarios(1, this.buscar, this.criterio);

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
