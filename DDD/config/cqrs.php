<?php

return [
    'commands' => [
        \App\PostContext\Application\Post\Command\DeletePostById\DeletePostByIdCommand::class => \App\PostContext\Application\Post\Command\DeletePostById\DeletePostByIdCommandHandler::class,
        \App\PostContext\Application\Comment\Command\CreateComment\CreateCommentCommand::class => \App\PostContext\Application\Comment\Command\CreateComment\CreateCommentCommandHandler::class,
        \App\PostContext\Application\Comment\Command\DeleteCommentById\DeleteCommentByIdCommand::class => \App\PostContext\Application\Comment\Command\DeleteCommentById\DeleteCommentByIdCommandHandler::class,
    ],
    'queries' => [
        \App\PostContext\Application\Post\Query\GetPosts\GetPostsQuery::class => \App\PostContext\Application\Post\Query\GetPosts\GetPostsQueryHandler::class,
        \App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQuery::class => \App\PostContext\Application\Post\Query\GetPostById\GetPostByIdQueryHandler::class,
        \App\PostContext\Application\Comment\Query\GetComments\GetCommentsQuery::class => \App\PostContext\Application\Comment\Query\GetComments\GetCommentsQueryHandler::class,
        \App\PostContext\Application\Comment\Query\GetCommentById\GetCommentByIdQuery::class => \App\PostContext\Application\Comment\Query\GetCommentById\GetCommentByIdQueryHandler::class,
        \App\PostContext\Application\Comment\Query\GetCommentByAbbreviation\GetCommentByAbbreviationQuery::class => \App\PostContext\Application\Comment\Query\GetCommentByAbbreviation\GetCommentByAbbreviationQueryHandler::class,
    ],
];