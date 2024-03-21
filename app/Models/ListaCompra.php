<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaCompra extends Model
{
    use HasFactory;

    protected $table = 'listas_compras';

    public function productos(){
        return $this->hasMany(ListaProducto::class);
    }
}
