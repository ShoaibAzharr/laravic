<?php

namespace WhiteFalcon\Traits;

use function Laravel\Prompts\confirm;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

trait GreyMagic
{
    public function handle()
    {
        if (parent::handle() === false) return;

        if ($this->option('all')) {
            $this->input->setOption('repository', true);
            $this->input->setOption('view', true);
        }

        if ($this->option('repository')) {
            $this->createRepository();
        }

        if ($this->option('blade')) {
            $this->createView();
        }

        if ($this->option('json') || $this->option('api')) {
            $this->createResource();
        }

        if (
            $this->option('requests')
            && !$this->option('all')
            && !$this->option('resource')
            && !$this->option('api')
        ) {
            $this->createRequests();
        }

        if ( 
            ($path = $this->modelMigrationExists())
            && confirm(
                'Do you want to specify columns?',
                hint:'You can add columns to migration'
            )
        ) {
            $this->addColumns($path);
        }

    }

    protected function createRepository()
    {
        $name = Str::studly($this->getNameInput());

        $this->call('make:repository', [
            'name' => "{$name}Repository",
        ]);
    }

    protected function createView()
    {
        $name = Str::lower($this->getNameInput());

        $this->call('make:views', [
            'name' => $name,
        ]);
    }

    protected function createResource()
    {
        $name = Str::studly($this->getNameInput());

        $this->call('make:resource', [
            'name' => "{$name}Resource",
        ]);
    }

    protected function createRequests()
    {
        $storeRequestClass = 'Store'.Str::studly($this->getNameInput()).'Request';

        $this->call('make:request', [
            'name' => $storeRequestClass,
        ]);

        $updateRequestClass = 'Update'.Str::studly($this->getNameInput()).'Request';

        $this->call('make:request', [
            'name' => $updateRequestClass,
        ]);
    }

    protected function addColumns($path)
    {
        $this->handleColumnsAttributes();
        $this->generateMigrationColumns($path);

        $this->info('Columns added to migration');

        !confirm(
            'Do you want to run migrate and generate request rules?',
            hint:'New table will be created for Model with request rules'
        ) ?: $this->runMigrateAndGenerateRules();
    }

    
    protected function runMigrateAndGenerateRules()
    {
        $this->call('migrate');
        $this->call('gen:request', [
            'name' => $this->argument('name'),
            '--route' => true,
        ]);
    }

    public function getOptions(): array
    {
        $options = parent::getOptions();
        $options[] = ['repository', 'o', InputOption::VALUE_NONE, 'Generate a repository for the model'];
        $options[] = ['blade', 'b', InputOption::VALUE_NONE, 'Generate a list of views for the model'];
        $options[] = ['json', 'j', InputOption::VALUE_NONE, 'Generate a json resource for the model'];

        return $options;
    }
}
