<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $append = ['image_path', 'profit_percentage'];

    protected $fillable = [
        'name',
        'description',
        'image',
        'purchase_price',
        'sale_price',
        'stock',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute(){
        return asset('uploads/products/'. $this->image);
    }

    public function getProfitPercentageAttribute(){
        $profitPercentage = (($this->sale_price - $this->purchase_price) * 100) / $this->purchase_price;
        return number_format($profitPercentage, 2);
    }
}
