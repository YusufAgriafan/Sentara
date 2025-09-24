<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'histories';
    
    protected $fillable = [
        'title',
        'content',
        'category',
        'subcategory',
        'sub_subcategory',
        'order_index',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope untuk mendapatkan data berdasarkan kategori
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope untuk mendapatkan data berdasarkan subcategory
    public function scopeBySubcategory($query, $subcategory)
    {
        return $query->where('subcategory', $subcategory);
    }

    // Scope untuk mendapatkan data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index', 'asc');
    }

    // Method untuk mendapatkan struktur hierarkis
    public static function getHierarchy()
    {
        return self::active()
            ->ordered()
            ->get()
            ->groupBy(['category', 'subcategory', 'sub_subcategory']);
    }

    // Method untuk mendapatkan kategori unik
    public static function getCategories()
    {
        return self::active()
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();
    }

    // Method untuk mendapatkan subcategory berdasarkan category
    public static function getSubcategoriesByCategory($category)
    {
        return self::active()
            ->where('category', $category)
            ->whereNotNull('subcategory')
            ->distinct()
            ->pluck('subcategory')
            ->filter()
            ->values();
    }
}
