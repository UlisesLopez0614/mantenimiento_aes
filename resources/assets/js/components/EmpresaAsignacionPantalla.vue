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
                    <i class="fa fa-align-justify"></i> LISTADO DE VEHÍCULOS
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success text-white">
                                <i class="fa fa-file-excel-o"></i>&nbsp;EXCEL
                            </button>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered table-striped table-sm">
                        <thead>
                            <tr class="bg-primary">
                                <th style="text-align: center;">OPCIONES</th>
                                <th style="text-align: center;">EMPRESA</th>
                                <th style="text-align: center;">PLACA</th>
                                <th style="text-align: center;">FLOTA</th>
                                <th style="text-align: center;">COLOR</th>
                                <th style="text-align: center;">MODELO</th>
                                <th style="text-align: center;">MARCA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;" class="align-middle">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                </td>
                                <td style="text-align: center;" class="align-middle">Equipos</td>
                                <td style="text-align: center;" class="align-middle">Equipos</td>
                                <td style="text-align: center;" class="align-middle">Equipos</td>
                                <td style="text-align: center;" class="align-middle">Equipos</td>
                                <td style="text-align: center;" class="align-middle">Equipos</td>
                                <td style="text-align: center;" class="align-middle">Equipos</td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#">Ant</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">4</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sig</a>
                            </li>
                        </ul>
                    </nav>
                    
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">AGREGAR/EDITAR EMPRESA</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">PLACA:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="email-input"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">NOMBRE VH:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="email-input"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">EMPRESA:</label>
                                <div class="col-md-9">
                                    <select class="form-control">
                                        <option value="0">SELECCIONE UNA EMPRESA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">SUPERVISOR:</label>
                                <div class="col-md-9">
                                    <select class="form-control">
                                        <option value="0">SELECCIONE UN SUPERVISOR</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">CORREO (NARANJA):</label>
                                <div class="col-md-9">
                                    <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="INGRESE UN CORREO">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">CORREO (POR VENCERSE):</label>
                                <div class="col-md-9">
                                    <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="INGRESE UN CORREO">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">CORREO (ROJA):</label>
                                <div class="col-md-9">
                                    <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="INGRESE UN CORREO">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                        <button type="button" class="btn btn-primary">ACTUALIZAR</button>
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

                tabla : 1,
                prueba : '',
                loading : true

            }

        },

        methods : {

            cambiar(){
                let me = this;
                
                me.loading = false;

                //me.$root.menu = 2;
            }

        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
