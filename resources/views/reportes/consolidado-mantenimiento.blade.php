<table>
    <thead>
        <tr class="bg-danger">
            <th colspan="17" style="text-align: center;">CONSOLIDADO MANTENIMIENTOS {{$desde}}  /  {{$hasta}} </th>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">VEHICULO</td>
            <td colspan="5" style="text-align: center;">MANTENIMIENTO</td>
        </tr>
        <tr class="bg-danger">
            <th style="text-align: center;">NOMBRE</th>
            <th style="text-align: center;">PLACA</th>
            <th style="text-align: center;">FLOTA</th>
            <th style="text-align: center;">TIPO</th>
            <th style="text-align: center;">TIPO MANTENIMIENTO</th>
            <th style="text-align: center;">TALLER</th>
            <th style="text-align: center;">FECHA</th>
            <th style="text-align: center;">COSTO</th>
            <th style="text-align: center;">ESTADO ALERTA</th>
        </tr>
    </thead>
    <tbody>
        @for($i=0; $i<count($arrayMantenimiento); $i++)
            <tr>
                <td>{{$arrayMantenimiento[$i]->Name}}</td>
                <td>{{$arrayMantenimiento[$i]->Plate}}</td>
                <td>{{$arrayMantenimiento[$i]->Fleet}}</td>
                <td>{{$arrayMantenimiento[$i]->type}}</td>
                <td>{{$arrayMantenimiento[$i]->tipomtto}}</td>
                <td>{{$arrayMantenimiento[$i]->taller}}</td>
                <td>{{$arrayMantenimiento[$i]->date}}</td>
                <td>{{$arrayMantenimiento[$i]->costo}}</td>
                <td>{{$arrayMantenimiento[$i]->estado_alerta}}</td>
            </tr>
        @endfor
    </tbody>
</table>