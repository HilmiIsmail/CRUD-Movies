<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;

class Pelicula extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'sinopsis', 'caratula', 'category_id', 'disponible'];

    //relacion 1:N con category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    //relcion N:M con etiqueta
    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class);
    }

    //accesors y muttators
    public function nombre(): Attribute
    {
        return Attribute::make(
            set: fn ($v) => ucwords($v),
        );
    }
    public function sinopsis(): Attribute
    {
        return Attribute::make(
            set: fn ($v) => ucwords($v),
        );
    }

    /* eso lo creamos para usarlo en UpdateForm  */
    public function getTagsId(): array
    {
        $tags = [];
        foreach ($this->etiquetas as $etiqueta) {
            $tags[] = $etiqueta->id;
        }
        return $tags;
    }
}
