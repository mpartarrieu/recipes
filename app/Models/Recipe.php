<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'description', 'image'];

    /**
     * The ingredients of the recipe.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('amount')->withTimestamps();
    }

    /**
     * The recipe image.
     */
    public function getImageUrlAttribute($value): string
    {
        return $this->image ? Storage::url('filament/'.$this->image) : 'https://picsum.photos/600?grayscale&blur&random='.mt_rand(1, 9999);
    }

    /**
     * The recipe url.
     */
    public function getUrlAttribute(): string
    {
        return route('recipe', [
            'recipe' => $this,
            'slug' => Str::slug($this->name),
        ]);
    }
}
