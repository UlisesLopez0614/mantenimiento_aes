@extends('taller_main_view')

@section('contenido')
    <template v-if="menu==0">
        <listado-manto-general/>
    </template>
    <template v-if="menu==1">
        <listado-taler/>
    </template>
    <template v-if="menu==2">
        <historial-taller/>
    </template>
    <template v-if="menu==3">
        <historial-lub/>
    </template>
@endsection
