<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product Class.
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $description
 * @property string $category
 * @property string $image_url
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'price',
        'description',
        'category',
        'image_url',
    ];
}
