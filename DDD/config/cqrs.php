<?php

return [
    'commands' => [
    ],
    'queries' => [
        \App\PostContext\Application\Post\Query\GetPosts\GetPostsQuery::class => \App\PostContext\Application\Post\Query\GetPosts\GetPostsQueryHandler::class,
        \App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQuery::class => \App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQueryHandler::class,
        \App\PostContext\Application\Post\Query\DeletePostById\DeletePostByIdQuery::class => \App\PostContext\Application\Post\Query\DeletePostById\DeletePostByIdQueryHandler::class,
    ],
];