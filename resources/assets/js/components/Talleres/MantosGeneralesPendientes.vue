    <template>
    <main class="main">
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header text-white bg-primary">
                    <i class="fa fa-align-justify"></i> LISTADO DE VEHICULOS CON MANTENIMIENTO INGRESADO
                </div>
                <div class="card-body">
                    <template v-if="loading">
                        <table id="mi-tabla" class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                            <tr class="bg-primary">
                                <th style="text-align: center;" class="align-middle">VALIDAR MANTENIMIENTO</th>
                                <th style="text-align: center;" class="align-middle" colspan="3">VEHÍCULO</th>
                            </tr>
                            <tr class="bg-primary">
                                <th style="text-align: center;" class="align-middle"><div class="sizeOpcion">OPCIONES</div></th>
                                <th style="text-align: center;" class="align-middle">NOMBRE</th>
                                <th style="text-align: center;" class="align-middle">PLACA</th>
                                <th style="text-align: center;" class="align-middle">TIPO DE VEHICULO</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="principal in arrayPrincipal" :key="principal.id">
                                <td style="text-align: center;" class="align-middle">
                                    <button type="button" @click="abrirModalIngreso(principal)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                        <i class="icon-plus"> VALIDAR MANTENIMIENTO</i>
                                    </button> &nbsp;
                                </td>
                                <td style="text-align: center;" class="align-middle" v-text="principal.vehiculo.Name"></td>
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
    </main>
</template>

<script>

export default {

    name: "MantenimientosGeneralesPendientes",
    data (){

        return {
            tabla : 1,
            loading : true,
            arrayPrincipal : [],
            nombre : '',
            fecha_minima : '',
            // Variables del Registro
            Date_Out_Workshop:'',
            //----------
            //Vehiculo
            vehiculo : '',
            placa : '',
            ciclo: '',
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
            var url = '/listado-taller/general';
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

        cambiarPagina(page, buscar, criterio,  desde, hasta)
        {
            let me = this;
            me.pagination.current_page = page;
            me.listarPrincipal();
        },

        validarMantenimiento(){
            let me = this.nombre;
            axios.post('/listado-taller/general/register', {
                'slug': this.nombre
            }).then(function (response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Informacion Archivada!!',
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
            this.listarPrincipal();
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

        abrirModalIngreso(data = []){
            this.nombre = data.id;
            Swal.fire({
                title: 'Por favor, asegurarse que el mantenimiento haya finalizado y el vehiculo este listo para regresar.',
                icon: 'warning',
                footer: '<strong>NOTA</strong>: ESTA ACCION NO SE PUEDE REVERTIR Y EL MANTENIMIENTO QUEDARA REGISTRADO A SU NOMBRE',
                showCancelButton: true,
                confirmButtonText: 'SÍ, ESTOY SEGURO'
            }).then((result) => {

                if (result.value) {
                    this.validarMantenimiento();
                }
            });
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
