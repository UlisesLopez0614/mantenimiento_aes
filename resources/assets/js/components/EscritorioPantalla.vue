<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">HOME</li>
            <li class="breadcrumb-item"><a href="#">ADMIN</a></li>
            <li class="breadcrumb-item active">DASHBOARD</li>
        </ol>
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4"></div>
                                    <div>SUPERVISORES</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart1" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-success">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4"></div>
                                    <div>U. DE MEDIDA</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart2" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-warning">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4"></div>
                                    <div>TALLERES</div>
                                </div>
                                <div class="chart-wrapper mt-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart3" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-danger">
                            <div class="card-body pb-0">
                                <div class="text-value display-4"></div>
                                <div>ITEMs</div>
                            </div>
                            <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                <canvas class="chart" id="card-chart4" height="40"></canvas>
                            </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4"></div>
                                    <div>TIPOS MANTO</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart1" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-success">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4"></div>
                                    <div>EMPRESAS</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart2" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-warning">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4"></div>
                                    <div>VEHÍCULOS</div>
                                </div>
                                <div class="chart-wrapper mt-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart3" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-danger">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4"></div>
                                    <div>USUARIOS</div>
                                </div>
                                <div class="chart-wrapper mt-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart3" height="40"></canvas>
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

        methods : {

            

        },

        mounted() {


        }

    }
</script>