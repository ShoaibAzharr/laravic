<?php

namespace WhiteFalcon\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ViewCreator
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The custom app stubs directory.
     *
     * @var string
     */
    protected $stubPath;

    public $CRUDFiles = [
        'index',
        'create',
        'edit',
        'show',
    ];

    /**
     * Create a new view creator instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $stubPath
     * @return void
     */
    public function __construct(Filesystem $files, $stubPath)
    {
        $this->files = $files;
        $this->stubPath = $stubPath;
    }

    /**
     * Create a new view at the given path.
     *
     * @param  string  $name
     * @param  string  $path
     * @param  string|null  $table
     * @param  bool  $create
     * @return string
     *
     * @throws \Exception
     */
    public function create($name, $path)
    {
        $name = \str($name)->plural()->lower();

        $dirPath = $this->getDirPath($name, $path);

        !$this->files->exists($dirPath) ?: throw new \InvalidArgumentException("{$name->singular()->ucfirst()} views already exist");
        
        $this->files->ensureDirectoryExists($dirPath);



        foreach ($this->CRUDFiles as $file) {

            $view = $name . '.' . $file;
            $stub = $this->stubFile($file);
            
            $filePaths[$view] = $this->getPath($name, $path, $file);
            $this->files->put(
                $filePaths[$view], $this->populateStub($stub, $name)
            );
        }

        return $filePaths;
    }


    /**
     * Populate the place-holders in the view stub.
     *
     * @param  string  $stub
     * @param  string|null  $table
     * @return string
     */
    protected function populateStub($stub, $name)
    {
        $name = \str($name);

        $stub = str_replace(
            '{{ entitySingular }}',
            $name->singular()->ucfirst(), $stub
        );
        
        $stub = str_replace(
            '{{ lcEntityPlural }}',
            $name->plural()->lower(), $stub
        );

        $stub = str_replace(
            '{{ lcEntitySingular }}',
            $name->singular()->lower(), $stub
        );

        return $stub;
    }

    /**
     * Get the class name of a view name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getClassName($name)
    {
        return Str::studly($name);
    }

    /**
     * Get the full path to the view.
     *
     * @param  string  $name
     * @param  string  $path
     * @return string
     */
    protected function getDirPath($name, $path)
    {
        return ($path . '/' . $name);
    }

    /**
     * Get the full path to the view.
     *
     * @param  string  $name
     * @param  string  $path
     * @return string
     */
    protected function stubFile($file)
    {
        return $this->files->get($this->stubPath . '/view-' . $file . '.stub');
    }

    /**
     * Get the full path to the view.
     *
     * @param  string  $name
     * @param  string  $path
     * @return string
     */
    protected function getPath($name, $path, $file)
    {
        return ($path.'/'. $name. '/'. $file .'.blade.php');
    }

}