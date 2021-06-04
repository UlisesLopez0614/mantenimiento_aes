<table>
    <thead>
        <tr class="bg-danger">
            <th colspan="12" style="text-align: center;">CONSOLIDADO MANTENIMIENTOS DE CAMBIOS DE BATERIAS</th>
        </tr>
        <tr>
            <th colspan="12" style="text-align: center;">FECHA DE INSTALACION DESDE : {{$desde}}  -   HASTA : {{$hasta}} </th>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">VEHICULO</td>
            <td colspan="8" style="text-align: center;">DATOS MANTENIMIENTO</td>
        </tr>
        <tr class="bg-danger">
            <th style="text-align: center;">NOMBRE</th>
            <th style="text-align: center;">PLACA</th>
            <th style="text-align: center;">FLOTA</th>
            <th style="text-align: center;">TIPO</th>

            <th style="text-align: center;">TIPO BATERIA</th>
            <th style="text-align: center;">MECANICO</th>
            <th style="text-align: center;">FECHA INSTALACION</th>
            <th style="text-align: center;">CANTIDAD</th>
            <th style="text-align: center;">NUMERO DE AVISO</th>
            <th style="text-align: center;">ORDEN DE TRABAJO</th>
            <th style="text-align: center;">DISPOSICION FINAL</th>
            <th style="text-align: center;">MONTO (S)</th>
        </tr>
    </thead>
    <tbody>
        @for($i=0; $i<count($arrayMantenimiento); $i++)
            <tr>
                <td>{{$arrayMantenimiento[$i]->Name}}</td>
                <td>{{$arrayMantenimiento[$i]->Plate}}</td>
                <td>{{$arrayMantenimiento[$i]->Fleet}}</td>
                <td>{{$arrayMantenimiento[$i]->type}}</td>

                <td>{{$arrayMantenimiento[$i]->Tipo_Bateria}}</td>
                <td>{{$arrayMantenimiento[$i]->mecanico}}</td>
                <td>{{$arrayMantenimiento[$i]->Installation_Date}}</td>
                <td>{{$arrayMantenimiento[$i]->Qty}}</td>
                @if($arrayMantenimiento[$i]->Numero_Aviso <> null)
                    <td>{{$arrayMantenimiento[$i]->Numero_Aviso}}</td>
                @else
                    <td>Sin Numero de Aviso</td>
                @endif
                @if($arrayMantenimiento[$i]->Orden_Trabajo <> null)
                    <td>{{$arrayMantenimiento[$i]->Orden_Trabajo}}</td>
                @else
                    <td>Sin Orden de Trabajo</td>
                @endif
                @if($arrayMantenimiento[$i]->Disposicion_Final <> null)
                    <td>{{$arrayMantenimiento[$i]->Disposicion_Final}}</td>
                @else
                    <td>Sin Disposicion Final</td>
                @endif
                <td>$ {{$arrayMantenimiento[$i]->Amount}}</td>
            </tr>
        @endfor
    </tbody>
</table>
