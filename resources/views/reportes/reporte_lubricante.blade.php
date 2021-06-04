<table>
    <thead>
        <tr class="bg-danger">
            <th colspan="17" style="text-align: center;">CONSOLIDADO MANTENIMIENTOS DE LUBRICANTE</th>

        </tr>
        <tr>
            <th colspan="17" style="text-align: center;">SALIDA DE FLOTA DESDE : {{$desde}}  -   HASTA : {{$hasta}} </th>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">VEHICULO</td>
            <td colspan="11" style="text-align: center;">DETALLES MANTENIMIENTO</td>
        </tr>
        <tr class="bg-danger">
            <th style="text-align: center;">NOMBRE</th>
            <th style="text-align: center;">PLACA</th>
            <th style="text-align: center;">FLOTA</th>
            <th style="text-align: center;">AREA</th>
            <th style="text-align: center;">TIPO</th>

            <th style="text-align: center;">TALLER</th>
            <th style="text-align: center;">TIPO REPARACION</th>
            <th style="text-align: center;">CICLO DE MANTENIMIENTO</th>
            <th style="text-align: center;">CANTIDAD DE LUBRICANTE (CUARTOS DE GALON)</th>
            <th style="text-align: center;">CANTIDAD DE LUBRICANTE (GALONES)</th>
            <th style="text-align: center;">COSTO ($)</th>

            <th style="text-align: center;">SALIDA DE FLOTA</th>
            <th style="text-align: center;">ENTRADA A TALLER</th>
            <th style="text-align: center;">SALIDA DE TALLER</th>
            <th style="text-align: center;">ENTRADA A FLOTA</th>
        </tr>
    </thead>
    <tbody>
        @for($i=0; $i<count($arrayMantenimiento); $i++)
            <tr>
                <td>{{$arrayMantenimiento[$i]->Name}}</td>
                <td>{{$arrayMantenimiento[$i]->Plate}}</td>
                <td>{{$arrayMantenimiento[$i]->Fleet}}</td>
                <td>{{$arrayMantenimiento[$i]->Area}}</td>
                <td>{{$arrayMantenimiento[$i]->type}}</td>

                <td>{{$arrayMantenimiento[$i]->nombre}}</td>
                <td>{{$arrayMantenimiento[$i]->Tipo_Reparacion}}</td>
                <td>{{$arrayMantenimiento[$i]->Ciclo_Mto}}</td>
                <td>{{$arrayMantenimiento[$i]->Qty_Qts}}</td>
                <td>{{$arrayMantenimiento[$i]->Qty_Gals}}</td>
                <td>{{$arrayMantenimiento[$i]->Amount}}</td>

                <td>{{$arrayMantenimiento[$i]->Date_Out_Fleet}}</td>
                @if($arrayMantenimiento[$i]->Date_In_Workshop != null)
                <td>{{$arrayMantenimiento[$i]->Date_In_Workshop}}</td>
                @else
                    <td>Pendiente de Ingresar por el Taller</td>
                @endif
                @if($arrayMantenimiento[$i]->Date_Out_Workshop != null)
                    <td>{{$arrayMantenimiento[$i]->Date_Out_Workshop}}</td>
                @else
                    <td>Pendiente de Ingresar por el Taller</td>
                @endif
                @if($arrayMantenimiento[$i]->Date_In_Fleet != null)
                    <td>{{$arrayMantenimiento[$i]->Date_In_Fleet}}</td>
                @else
                    <td>Pendiente de Ingresar por el Supervisor</td>
                @endif

            </tr>
        @endfor
    </tbody>
</table>
