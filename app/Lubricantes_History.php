<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lubricantes_History extends Model
{
    //Nombre de la table
    protected $table = 'tb_llantas_history';

    //Llave primaria
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'vehicle_id',
        'Date_Out_Fleet',
        'Date_In_Workshop',
        'Ciclo_Mto',
        'Tipo_Reparacion',
        'Qty_Qts',
        'Qty_Gals',
        'Date_Out_Workshop',
        'Date_In_Fleet',
        'Amount'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehicle_id');
    }
}
