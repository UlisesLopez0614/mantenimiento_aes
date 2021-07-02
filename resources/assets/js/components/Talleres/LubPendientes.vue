    <template>
    <main class="main">
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header text-white bg-primary">
                    <i class="fa fa-align-justify"></i> LISTADO DE VEHICULOS CON MANTENIMIENTO AGENDADO
                </div>
                <div class="card-body">
                    <template v-if="loading">
                        <table id="mi-tabla" class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                            <tr class="bg-primary">
                                <th style="text-align: center;" class="align-middle"></th>
                                <th style="text-align: center;" class="align-middle" colspan="2">VEHÍCULO</th>
                            </tr>
                            <tr class="bg-primary">
                                <th style="text-align: center;" class="align-middle"><div class="sizeOpcion">OPCIONES</div></th>
                                <th style="text-align: center;" class="align-middle">PLACA</th>
                                <th style="text-align: center;" class="align-middle">TIPO DE VEHICULO</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="principal in arrayPrincipal" :key="principal.id">
                                <td style="text-align: center;" class="align-middle">
                                    <button type="button" @click="abrirModal(principal)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                        <i class="icon-plus">&nbsp;Agregar Registro</i>
                                    </button> &nbsp;
                                </td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.Plate"></td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.type"></td>
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
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio,  desde, hasta)">Sig</a>
                                </li>
                            </ul>
                        </nav>
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
                        <h4 class="modal-title" v-text="tituloModal + 'Vehiculo : '+placa"></h4>
                        <button type="button" @click="cerrarModal()" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label"><b>FECHA DE INGRESO AL TALLER:</b></label>
                                <div class="col-md-3">
                                    <input type="date" v-model="Date_In_Workshop" :min="fecha_minima" :max="Date_Out_Workshop" class="form-control">
                                </div>
                                <label class="col-md-3 form-control-label"><b>FECHA DE SALIDA DEL TALLER:</b></label>
                                <div class="col-md-3">
                                    <input type="date" v-model="Date_Out_Workshop" :min="Date_In_Workshop" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" >TIPO DE REPARACION (*):</label>
                                <div class="col-md-9">
                                    <input type="textarea" v-model="Tipo_Reparacion" class="form-control" placeholder="Detalles Acerca de la reparacion">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" >CANTIDAD  DE CUARTOS : </label>
                                <div class="col-md-3">
                                    <input type="number" step="1" v-model="Qty_Qts" :min="1" class="form-control" placeholder="CANTIDAD DE CUARTOS DE GALON">
                                </div>

                                <label class="col-md-3 form-control-label" >CANTIDAD DE GALONES : </label>
                                <div class="col-md-3">
                                    {{Qty_Qts/4}}
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

    name: "MantenimientosPendientes",
    data (){

        return {
            tabla : 1,
            loading : true,
            arrayTaller : [],
            arrayTipomanto : [],
            arrayPrincipal : [],
            arrayHistorial : [],
            nombre : '',
            fecha_minima : '',
            // Variables del Registro
            Date_In_Workshop :'',
            Tipo_Reparacion:'',
            Qty_Qts : '',
            Date_Out_Workshop:'',
            //----------
            //Vehiculo
            vehiculo : '',
            placa : '',
            //-------------
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
            offset : 3
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

        listarPrincipal(){

            let me = this;
            var url = '/listado-taller/lubricantes';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayPrincipal = respuesta.records.data;
                me.pagination = respuesta.pagination;
            })
                .catch(function (error) {
                    console.log("ERRORR !!!!!!!!!!!! AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA");
                    console.log(error);
                    console.log("ABANDONEN LA NAVE!!!!!...... AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA")
                })
        },

        cambiarPagina(page, buscar, criterio,  desde, hasta){

            let me = this;

            me.pagination.current_page = page;
            me.listarPrincipal();

        },

        registrarMantenimiento(){

            if(this.validarMantenimiento()){return;}

            let me = this;

            axios.post('/listado-taller/register', {
                'Qty': this.Qty_Qts,
                'Date_In' : this.Date_In_Workshop,
                'Date_Out' : this.Date_Out_Workshop,
                'Details' : this.Tipo_Reparacion,
                'slug': this.nombre,

            }).then(function (response) {

                me.listarPrincipal();
                me.cerrarModal();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Datos Guardados con exito!',
                    showConfirmButton: false,
                    timer: 1500
                });

            }).catch(function (error) {
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

            if(!this.Qty_Qts) this.errorMostrarMsjMantenimiento.push("Ingrese la Cantidad de Cuartos de Galon.");
            if(!this.Date_In_Workshop) this.errorMostrarMsjMantenimiento.push("La Fecha de Ingreso es obligatoria.");
            if(!this.Date_Out_Workshop) this.errorMostrarMsjMantenimiento.push("Fecha de Salida Obligatoria.");
            if(!this.Tipo_Reparacion)this.errorMostrarMsjMantenimiento.push("Ingrese los detalles del mantenimiento.");
            return this.errorMantenimiento;
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
            this.Date_In_Workshop = date;
        },

        abrirModal(data = []){

            this.currentDate();
            this.modal = 1;
            this.tituloModal = 'Ingreso de Datos de Mantenimiento de Lubricantes';
            this.vehiculo = data['vehiculo'].id;
            this.nombre = data.id;
            this.placa = data['vehiculo'].Plate;
            this.tipoAccion = 1;
        },

        cerrarModal(){

            this.modal = 0;
            this.tituloModal = '';
            this.arrayTaller = [];
            this.arrayTipomanto = [];
            this.fecha = '';
            this.vehiculo = '';
            this.nombre = '';
            this.placa = '';
            this.errorMantenimiento = 0;
            this.errorMostrarMsjMantenimiento = [];
        },
    },

    mounted() {
        this.listarPrincipal();
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
