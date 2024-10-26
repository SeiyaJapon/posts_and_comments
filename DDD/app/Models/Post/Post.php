<?php

namespace App\Models\Post;

use App\Models\Comment\Comment;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['id', 'title', 'content', 'created_at', 'updated_at'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if ($key === 'id') {
                $query->where($key, '=', $value);
            } else {
                $query->where($key, 'like', '%' . $value . '%');
            }
        }
    }

    public function scopeWithCommentFilter($query, ?string $commentFilter)
    {
        if ($commentFilter) {
            $query->whereHas('comments', function ($q) use ($commentFilter) {
                $q->where('content', 'like', '%' . $commentFilter . '%');
            });
        }
    }

    public function scopePaginateAndSort($query, int $page, int $limit, string $sort, string $direction)
    {
        return $query->orderBy($sort, $direction)
                     ->skip(($page - 1) * $limit)
                     ->take($limit);
    }
}
