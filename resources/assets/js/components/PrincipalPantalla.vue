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
                    <i class="fa fa-align-justify"></i> ESTADO DEL MANTENIMIENTO DE LOS VEHÍCULOS
                </div>
                <div class="card-body">
                    <template v-if="loading">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" id="opcion" name="opcion">
                                        <option value="idavl">ID AVL</option>
                                        <option value="nombre">NOMBRE</option>
                                        <option value="placa">PLACA</option>
                                        <option value="modelo">MODELO</option>
                                        <option value="color">COLOR</option>
                                    </select>
                                    <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-10">
                                <div class="input-group input-daterange">
                                    <select class="form-control col-md-6">
                                        <option>ODÓMETRO ACTUAL</option>
                                        <option>ODÓMETRO ALERTA</option>
                                    </select>                            
                                    <div class="input-group-addon bg-primary">DESDE</div>
                                    <input type="number" class="form-control">
                                    <div class="input-group-addon bg-primary">HASTA</div>
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group input-daterange">
                                    <div class="input-group-addon bg-primary">TIPO MANTO</div>
                                    <select class="form-control col-md-8">
                                        <option value="">TODOS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-daterange">
                                    <div class="input-group-addon bg-primary">TALLER</div>
                                    <select class="form-control col-md-8">
                                        <option value="">TODOS</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                    <th style="text-align: center;">OPCIONES</th>
                                    <th style="text-align: center;">ID AVL</th>
                                    <th style="text-align: center;">NOMBRE</th>
                                    <th style="text-align: center;">PLACA</th>
                                    <th style="text-align: center;">FLOTA</th>
                                    <th style="text-align: center;">MODELO</th>
                                    <th style="text-align: center;">COLOR</th>
                                    <th style="text-align: center;">ODO. ACTUAL</th>
                                    <th style="text-align: center;">ODO. ALERTA</th>
                                    <th style="text-align: center;">TIPO MANTO.</th>
                                    <th style="text-align: center;">TALLER</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;" class="align-middle">
                                        <button @click="cambiar(0)" type="button" class="btn btn-primary btn-sm">
                                            <i class="icon-eye"></i>
                                        </button> &nbsp;
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalNuevo">
                                            <i class="icon-plus"></i>
                                        </button> &nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalInfo">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </td>
                                    <td style="text-align: center;" class="align-middle">Equipos</td>
                                    <td style="text-align: center;" class="align-middle">Dispositivos electrónicos</td>
                                    <td style="text-align: center;" class="align-middle">
                                        <span class="badge badge-success">Activo</span>
                                    </td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
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
                    </template>
                    <template v-else>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button @click="loading=true" class="btn btn-primary"><i class="fa fa-back"></i> VOLVER</button>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                    <th style="text-align: center;">OPCIONES</th>
                                    <th style="text-align: center;">ESTADO</th>
                                    <th style="text-align: center;">MANTENIMIENTO ASIGNADO</th>
                                    <th style="text-align: center;">CANTIDAD</th>
                                    <th style="text-align: center;">UNIDAD DE MEDIDA</th>
                                    <th style="text-align: center;">ASIGNADO</th>
                                    <th style="text-align: center;">TRAB EXTRA</th>
                                    <th style="text-align: center;">TRAB NORMAL</th>
                                    <th style="text-align: center;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;" class="align-middle">
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEliminar">
                                            <i class="icon-plus"></i>
                                        </button> &nbsp;
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDetalle">
                                            <i class="icon-info"></i>
                                        </button> &nbsp;
                                    </td>
                                    <td style="text-align: center;" class="align-middle">Equipos</td>
                                    <td style="text-align: center;" class="align-middle">Dispositivos electrónicos</td>
                                    <td style="text-align: center;" class="align-middle">
                                        <span class="badge badge-success">Activo</span>
                                    </td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    <td style="text-align: center;" class="align-middle"></td>
                                    
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
                    </template>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">INGRESO DE ASIGNACIÓN DE MANTENIMIENTO A LOS VEHÍCULOS</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary"><i class="icon-refresh"></i>  &nbsp; REFRESCAR ODÓMETRO</button>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">FECHA:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="text-input">26/08/2020</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">HORA:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="text-input">16:41 pm</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">VEHÍCULO:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="text-input"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">ODO SW INICIAL:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="text-input"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">ODO HW INICIAL:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="text-input"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">TALLER (*):</label>
                                <div class="col-md-9">
                                    <select class="form-control">
                                        <option value="0">SELECCIONE UN TALLER</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">TIPO MANTENIMIENTO (*):</label>
                                <div class="col-md-9">
                                    <select class="form-control">
                                        <option value="0">SELECCIONE UN TIPO DE MANTENIMIENTO</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">CANTIDAD:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="text-input"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">UNIDAD DE MEDIDA:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="text-input"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">CORREO ALERTA:</label>
                                <div class="col-md-9">
                                    <input type="email" id="descripcion" name="descripcion" class="form-control" placeholder="INGRESE UN CORREO PARA ALERTAS">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">TELEFONO ALERTA:</label>
                                <div class="col-md-9">
                                    <label class="col-md-3 form-control-label" for="text-input"></label>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                        <button type="button" class="btn btn-primary">GUARDAR</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
        <!-- Inicio del modal Eliminar -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">DETALLE DEL MANTENIMIENTO</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">ESTADO:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">TALLER NOMBRE:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">ENVIO ALERTAS:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">OBSERVACIONES:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">INICIO MANTO:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">FECHA MOD:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">HORA MOD:</label>
                            <div class="col-md-9">
                                <label class="col-md-3 form-control-label" for="text-input"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fin del modal Eliminar -->
        <!-- Inicio del modal Detalle -->
        <div class="modal fade" id="modalDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">DETALLE DE COSTOS POR ITEM</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <h5>No hay registros para mostrar</h5>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fin del modal Eliminar -->
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
