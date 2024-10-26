<?php

namespace Database\Seeders;

use App\Models\Comment\Comment;
use App\Models\Post\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $randomWords = explode(',', "Cool,Strange,Funny,Laughing,Nice,Awesome,Great,Horrible,Beautiful,PHP,Vegeta,Italy,Joost");

        $contentCombinations = $this->generateContentCombinations($randomWords);

        $posts = Post::all();

        foreach ($contentCombinations as $content) {
            $post = $posts->random();
            Comment::create([
                'post_id' => $post->id,
                'content' => $content,
                'abbreviation' => $this->generateAbbreviation($content),
            ]);
        }
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
