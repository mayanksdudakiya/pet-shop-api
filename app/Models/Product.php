<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Product extends Model
{
    use HasFactory;
    use HasJsonRelationships;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'category_uuid',
        'uuid',
        'title',
        'price',
        'description',
        'metadata',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'json',
    ];

    /** @var array<int, string> $with */
    protected $with = [
        'category',
        'brand',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'metadata->brand', 'uuid');
    }
}
