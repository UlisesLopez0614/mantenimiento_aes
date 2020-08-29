<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipomanto extends Model
{
    //Nombre de la table
    protected $table = 'tb_tipo_mttos';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'cantidad', 'umedida', 'porcentajealerta'
    ];

    public function setNombreAttribute($value) 
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function setUmedidaAttribute($value) 
    {
        $this->attributes['umedida'] = strtoupper($value);
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'FK_tipoMtto');
    }

}
