<?php

namespace WhiteFalcon\Console\Commands;

final class Command
{
    public static function boot($provider)
    {
        (new self)($provider);
    }

    public function __invoke($provider)
    {
        $provider->commands([
            \WhiteFalcon\Console\Commands\RepositoryMakeCommand::class,
            \WhiteFalcon\Decorators\Commands\ModelMakeCommand::class,
            \WhiteFalcon\Console\Commands\ViewMakeCommand::class,
            \WhiteFalcon\Console\Commands\ShowAPIRequest::class,
            \WhiteFalcon\Console\Commands\GenerateRequestRules::class,
            // \WhiteFalcon\Decorators\Commands\MigrateMakeCommand::class,
            
        ]);
    }
}