<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">HOME</li>
            <li class="breadcrumb-item"><a href="/">ADMIN</a></li>
            <li class="breadcrumb-item active">DASHBOARD</li>
        </ol>
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-primary rounded">
                                <div class="card-header"><strong>SUPERVISORES</strong></div>
                                <div class="card-body">
                                    <div class="text-value">1 SUPERVISOR</div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-success rounded">
                                <div class="card-header"><strong>U. DE MEDIDA</strong></div>
                                <div class="card-body">
                                    <div class="text-value">Kilometros</div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-warning rounded">
                                <div class="card-header"><strong>Cantidad de Talleres</strong></div>
                                <div class="card-body">
                                    <p class="card-text">{{this.KPI.Taller_Count}} Talleres Registrados</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-danger rounded">
                                <div class="card-header"><strong>ITEMS</strong></div>
                                <div class="card-body">
                                    <div class="text-value">No hay Items Actualmente</div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-primary rounded">
                                <div class="card-header"><strong>TIPOS MANTO</strong></div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li v-for="t_mtto in Mantenimientos">{{t_mtto}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-success rounded">
                                <div class="card-header d-flex">
                                    <div class="flex-grow-1"><strong>EMPRESAS</strong></div>
                                    <div class="flex-fill bd-highlight"></div>
                                    <div class="flex-fill bd-highlight">{{ this.KPI.Empresas_Count }}</div>
                                </div>
                                <div class="card-body pb-0">
                                    <ul class="list-unstyled">
                                        <li v-for="emps in Empresas">{{emps}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-warning rounded">
                                <div class="card-header d-flex">
                                    <div class="flex-grow-1"><strong>Vehiculos</strong></div>
                                    <div class="flex-fill bd-highlight"></div>
                                    <div class="flex-fill bd-highlight">{{this.KPI.Vehicles_Count}}</div>
                                </div>
                                <div class="card-body">
                                    <div class="text-value">{{this.KPI.Fleet_Count}} Flotas Registradas</div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-danger rounded">
                                <div class="card-header"><strong>USUARIOS</strong></div>
                                <div class="card-body">
                                    <div class="text-value">No hay usuarios registrados</div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        name : 'Escritorio-Pantalla',
        mounted() {
            this.fetchData()
        },
        data(){
            return{
                KPI:{
                    Taller_Count: '',
                    Empresas_Count:'',
                    Vehicles_Count:'',
                    Fleet_Count:'',
                },
                Empresas: [],
                Mantenimientos:[],
            }
        },
        methods : {
            fetchData(){
                fetch('/home_data')
                .then(response=>response.json())
                .then(data=>{
                    this.KPI.Taller_Count = data.taller_count;
                    this.Empresas = data.Empresas;
                    this.Mantenimientos = data.T_Mtto;
                    this.KPI.Empresas_Count = data.E_Count;
                    this.KPI.Vehicles_Count = data.vehicles_count;
                    this.KPI.Fleet_Count = data.Fleet_Count;
                console.log(data);
                })
            }
        }

    }
</script>
