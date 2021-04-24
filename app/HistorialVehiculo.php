<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialVehiculo extends Model
{
    //
    //Nombre de la table
    protected $table = 'tb_summary';

    //Llave primaria
    protected $fillable = [
        'FK_idVehicle',
        'Date',
        'Time',
        'Positions',
        'Distance',
        'AvgSpeed',
        'MaxSpeed',
        'FuelAvg',
        'MovTime',
        'Stops',
        'StopTime',
        'StopTimeOn',
        'GeoEvents'
    ];

    public $timestamps = false;
}
