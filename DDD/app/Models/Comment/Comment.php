<?php

namespace App\Models\Comment;

use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['id', 'post_id', 'content', 'abbreviation', 'created_at', 'updated_at'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $field => $value) {
            if ($field === 'start_date' && isset($filters['end_date'])) {
                $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
            } elseif ($field !== 'end_date') {
                if ('id' === $field || 'post_id' === $field) {
                    $query->where($field, '=', $value);
                } else {
                    $query->where($field, 'like', '%' . $value . '%');
                }
            }
        }
    }
}
