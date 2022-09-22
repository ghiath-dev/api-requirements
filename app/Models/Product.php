<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['sku', 'name', 'price'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function originalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->price,
        );
    }

    public function finalPrice(): Attribute
    {
        $finalPrice = $this->price;

        if ($this->category?->name == 'insurance') {
            $finalPrice = $finalPrice - ($this->price * 30 / 100);
        }

        if ($this->sku == '000003') {
            $finalPrice = $finalPrice - ($this->price * 15 / 100);
        }

        return Attribute::make(
            get: fn() => $finalPrice,
        );
    }

    public function discountPercentage(): Attribute
    {
        $discountPercentage = 0;

        if ($this->category?->name == 'insurance') {
            $discountPercentage += 30;
        }

        if ($this->sku == '000003') {
            $discountPercentage += 15;
        }

        return Attribute::make(
            get: fn() => $discountPercentage == 0 ? null : "$discountPercentage%",
        );
    }

    public function scopeForCategory($q, $category)
    {
        return $q->whereIn('category_id', [Category::where('name', $category)->first()?->id]);
    }

    public function toArray()
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'category' => $this->category?->name,
            'price' => [
                'original' => $this->price,
                'final' => $this->finalPrice,
                'discount_percentage' => $this->discountPercentage,
                "currency" => "EUR",
            ],
        ];
    }

}
