<?php

namespace WhiteFalcon\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;

class ViewMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:views {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new list of blade CRUD files';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->getStubPath();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $paths = (
                new ViewCreator(new Filesystem(), $this->getStub())
            )->create($this->argument('name'),resource_path('views'));

            array_walk($paths, [$this, 'output']);
            
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }

    public function output($path, $view)
    {
        $this->components->info(sprintf('View %s [%s] created successfully.', $view, $path));
    }

    /**
     * Get the stub path for the generator.
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__.'/../stubs';
    }   
}
