<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;

    static function notInCart(Request $request)
    {
        return collect(static::all())
            ->reject(function ($product) use ($request) {
                return in_array($product->id, $request->session()->get('productsInCart'));
            });
    }

    protected $fillable = [
        'id',
        'title',
        'description',
        'price',
        'image',
    ];
}
