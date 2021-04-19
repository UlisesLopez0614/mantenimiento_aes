<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Llantas_History extends Model
{
    //Nombre de la table
    protected $table = 'tb_llantas_history';

    //Llave primaria
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'vehicle_id','Tipo_Llanta','Installation_Date','Installation_Date','Qty','Amount','Numero_Aviso','Orden_Trabajo','Disposicion_Final'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehicle_id');
    }
}
