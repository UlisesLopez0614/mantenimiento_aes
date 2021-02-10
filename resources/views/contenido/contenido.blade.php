@extends('principal')

@section('contenido')

    <template v-if="menu==0">
        <escritorio-pantalla></escritorio-pantalla>
    </template>

    <keep-alive include="principa-pantalla">
        <template v-if="menu==1">
            <principal-pantalla></principal-pantalla>
        </template>
    </keep-alive>

    <keep-alive include="supervisor-pantalla">
        <template v-if="menu==2">
            <supervisor-pantalla></supervisor-pantalla>
        </template>
    </keep-alive>

    <keep-alive include="unidmedida-pantalla">
        <template v-if="menu==3">
            <unidmedida-pantalla></unidmedida-pantalla>
        </template>
    </keep-alive>

    <keep-alive include="taller-pantalla">
        <template v-if="menu==4">
            <taller-pantalla></taller-pantalla>
        </template>
    </keep-alive>

    <keep-alive include="item-pantalla">
        <template v-if="menu==5">
            <item-pantalla></item-pantalla>
        </template>
    </keep-alive>

    <keep-alive include="tipomanto-pantalla">
        <template v-if="menu==6">
            <tipomanto-pantalla></tipomanto-pantalla>
        </template>
    </keep-alive>

    <keep-alive include="empresa-catalogo-pantalla">
        <template v-if="menu==7">
            <empresa-catalogo-pantalla></empresa-catalogo-pantalla>
        </template>
    </keep-alive>

    <keep-alive include="empresa-asignacion-pantalla">
        <template v-if="menu==8">
            <empresa-asignacion-pantalla></empresa-asignacion-pantalla>
        </template>
    </keep-alive>

    <!--keep-alive include="indicadores-globales">
        <template v-if="menu==9">
            <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
        </template>
    </keep-alive>

    <template v-if="menu==10">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
    </template>

    <keep-alive include="reporte-cumplimientos">
        <template v-if="menu==11">
            <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
        </template>
    </keep-alive>

    <template v-if="menu==12">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
    </template>

    <!--keep-alive include="acceso-users">
        <template v-if="menu==13">
            <acceso-users></acceso-users>
        </template>
    </keep-alive>

    <template v-if="menu==14">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
    </template>

    <template v-if="menu==15">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
    </template-->

    <template v-if="menu==16">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
    </template>

    <template v-if="menu==17">
        <reporte-mantenimientos></reporte-mantenimientos>
    </template>

@endsection