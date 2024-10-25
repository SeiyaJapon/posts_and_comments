<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        $randomWords = explode(',', "Cool,Strange,Funny,Laughing,Nice,Awesome,Great,Horrible,Beautiful,PHP,Vegeta,Italy,Joost");
        $contentCombinations = $this->generateContentCombinations($randomWords);
        $content = $this->faker->randomElement($contentCombinations);
        $abbreviation = $this->generateAbbreviation($content);

        return [
            'post_id' => Post::factory(),
            'content' => $content,
            'abbreviation' => $abbreviation,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function generateContentCombinations($words)
    {
        $combinations = [];
        $totalCombinations = pow(2, count($words)) - 1;

        for ($i = 1; $i <= $totalCombinations; $i++) {
            $combination = [];

            for ($j = 0; $j < count($words); $j++) {
                if ($i & (1 << $j)) {
                    $combination[] = strtolower($words[$j]);
                }
            }

            sort($combination);

            $combinations[] = implode(' ', $combination);
        }

        return $combinations;
    }

    private function generateAbbreviation($content)
    {
        $words = explode(' ', $content);
        $abbreviation = '';

        foreach ($words as $word) {
            $abbreviation .= substr($word, 0, 1);
        }

        return $abbreviation;
    }
}