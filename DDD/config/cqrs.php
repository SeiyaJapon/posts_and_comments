<?php

return [
    'commands' => [
        \App\PostContext\Application\Post\Command\DeletePostById\DeletePostByIdCommand::class => \App\PostContext\Application\Post\Command\DeletePostById\DeletePostByIdCommandHandler::class,
    ],
    'queries' => [
        \App\PostContext\Application\Post\Query\GetPosts\GetPostsQuery::class => \App\PostContext\Application\Post\Query\GetPosts\GetPostsQueryHandler::class,
        \App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQuery::class => \App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQueryHandler::class,
        \App\PostContext\Application\Post\Query\PostExists\PostExistsQuery::class => \App\PostContext\Application\Post\Query\PostExists\PostExistsQueryHandler::class,
    ],
];