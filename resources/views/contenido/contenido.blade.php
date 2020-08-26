@extends('principal')

@section('contenido')

    <template v-if="menu==0">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
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

    <keep-alive include="reporte-anual">
        <template v-if="menu==4">
            <taller-pantalla></taller-pantalla>
        </template>
    </keep-alive>

    <keep-alive include="reporte-recorrido">
        <template v-if="menu==5">
            <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
        </template>
    </keep-alive>

    <keep-alive include="reporte-recorrido">
        <template v-if="menu==6">
            <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
        </template>
    </keep-alive>

    <keep-alive include="indicadores-globales">
        <template v-if="menu==7">
            <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
        </template>
    </keep-alive>

    <template v-if="menu==8">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
    </template>

    <keep-alive include="indicadores-globales">
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

    <template v-if="menu==13">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
    </template>

    <template v-if="menu==14">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
    </template>

    <template v-if="menu==15">
        <h1>ESTO ES UNA PRUEBA NADA MAS, NO TE ASUSTES HAHAHAHAHAHAHAHAHAHA</h1>
    </template>

@endsection