<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    //Nombre de la table
    protected $table = 'tb_talleres';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion', 'nit', 'nombrecontacto', 'telefono'
    ];

    public function setNombreAttribute($value) 
    {
        $this->attributes['nombre'] = strtoupper($value);
    }

    public function setDescripcionAttribute($value) 
    {
        $this->attributes['descripcion'] = strtoupper($value);
    }

    public function setNombrecontactoAttribute($value) 
    {
        $this->attributes['nombrecontacto'] = strtoupper($value);
    }

}
