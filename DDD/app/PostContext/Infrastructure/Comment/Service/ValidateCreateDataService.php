<?php

declare (strict_types=1);

namespace App\PostContext\Infrastructure\Comment\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateCreateDataService
{
    public function validate(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string',
            'abbreviation' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        return $validator->validated();
    }
}