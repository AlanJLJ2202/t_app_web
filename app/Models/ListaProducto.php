<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaProducto extends Model
{
    use HasFactory;

    protected $table = 'lista_producto';

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
