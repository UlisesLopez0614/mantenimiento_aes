@extends('taller_main_view')

@section('contenido')
    <template v-if="menu==0">
        <listado-taler></listado-taler>
    </template>
    <template v-if="menu==1">
        <historial-taler></historial-taler>
    </template>
@endsection
