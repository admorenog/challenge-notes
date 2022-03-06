<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Category extends Model
{
    use HasFactory;
    
    /**
     * Cleans the categories removing the empty ones and the unussed properties
     */
    public static function getCleanedCategories(Collection $categories) : Collection
    {
        $categories = $categories->filter(fn($cat) => $cat->category_id);

        return $categories->map(fn($cat) => [
            "id" => $cat->category_id,
            "name" => $cat->category_name
        ]);
    }
}
