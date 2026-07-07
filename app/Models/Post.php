<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Category;

class Post extends Model {
    use HasFactory;

    // protected $fillable = ['title', 'slug', 'author_id', 'category_id', 'body'];

    protected $guarded = ['id'];

    protected $with = ['author', 'category'];
    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function scopeFilter(Builder $query, array $filters) : void {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas('category',
            fn ($q) =>
                $q->where('slug', $category)
            );
        });

        $query->when($filters['author'] ?? false, function ($query, $author) {
            return $query->whereHas('author',
            fn ($q) =>
                $q->where('username', $author)
            );
        });
    }
}
