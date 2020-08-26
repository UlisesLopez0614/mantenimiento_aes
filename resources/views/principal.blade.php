<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Modulo Mantenimiento- AES">
        <meta name="author" content="Disatel GPS">
        <meta name="keyword" content="Modulo de Mantenimiento de AES">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="img/favicon.png">
        <title>Módulo Mantenimiento - AES</title>
        <!-- Icons -->
        <!-- Main styles for this application -->
        <link href="css/plantilla.css" rel="stylesheet">
    </head>

    <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
        <div id="app">
            
            @include('plantilla.header')

            <div class="app-body">
                
                @include('plantilla.sidebar')

                @yield('contenido')

            </div>

            @include('plantilla.footer')
        </div>

        <!-- Bootstrap and necessary plugins -->
        <script src="js/app.js"></script>
        <script src="js/plantilla.js"></script>

        <script>
            $(document).ready(function(){
                
                $('.dropdown-toggle').dropdown();


                $('form').keypress(function(e){   
                    if(e == 13){
                    return false;
                    }
                });

                $('input').keypress(function(e){
                    if(e.which == 13){
                    return false;
                    }
                });
            });
        </script>

        
    </body>

</html>
