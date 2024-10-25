<?php

declare (strict_types=1);

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    public function getPaginated(array $filters, int $page, int $limit, string $sort, string $direction): array
    {
        $query = Comment::query();

        foreach ($filters as $field => $value) {
            if ($field === 'start_date' && isset($filters['end_date'])) {
                $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
            } elseif ($field !== 'end_date') {
                if (is_int($value)) {
                    $query->where($field, $value);
                } else {
                    $query->where($field, 'like', '%' . $value . '%');
                }
            }
        }

        return [
            'result' => $query->orderBy($sort, $direction)
                               ->paginate($limit, ['*'], 'page', $page)
                               ->items(),
            'count' => $query->count()
        ];
    }

    public function getCommentById(int $id, array $with = []): ?Comment
    {
        $query = Comment::query();

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->find($id);
    }

    public function deleteById($id): bool
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return false;
        }

        return $comment->delete();
    }

    public function create(array $data): Comment
    {
        try {
            return Comment::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}