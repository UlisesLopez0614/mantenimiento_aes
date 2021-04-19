<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baterias_History extends Model
{
    //Nombre de la table
    protected $table = 'tb_baterias_history';

    //Llave primaria
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'vehicle_id', 'Tipo_Bateria','mecanico','Installation_Date','Qty','Amount','Numero_Aviso','Orden_Trabajo','Disposicion_Final'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehicle_id');
    }
}
