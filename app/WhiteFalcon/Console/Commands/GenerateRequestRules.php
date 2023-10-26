<?php

namespace WhiteFalcon\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateRequestRules extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:request {name} {--route : Generate the resource route}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the request rules from columns';

    protected $rules = [];

    protected $columns;
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->columns = \DB::select('DESCRIBE ' . str($this->argument('name'))->snake()->plural());

        $this->outputProgress();

        $this->generate();

        if ($this->option('route')) {
            $this->makeResourceRoute();
        }

        $this->components->alert('Rules are generated successfully');
    }

    protected function outputProgress()
    {
        $this->newLine(1);
        $this->withProgressBar($this->columns, function ($column, $bar) {
            $bar->setOverwrite(true);
            $bar->minSecondsBetweenRedraws(0.000001);
            $this->putToRuleArray($column);
        });
        $this->newLine(1);
    }

    public function putToRuleArray($column)
    {
        if (\in_array($column->Field, ['id', 'created_at', 'updated_at'])) {
            $this->info("\t" . $column->Field . ' => skipping');
            return;
        }
        $this->rules[$column->Field] = $this->makeRule($column);
        
        $this->comment("\t" . $column->Field . ' => ' . $this->rules[$column->Field]);
    }

    public function makeRule($column)
    {
        $rule = $column->Null == 'YES' ? 'nullable' : 'required';
        if (preg_match('~int~', $column->Type)) {
            $rule .= '|integer';
        }
        if (preg_match('~varchar|text~', $column->Type)) {
            $rule .= '|string';
            if (($max = preg_replace('/[^0-9]/', '', $column->Type))) {
                $rule .= '|max:' . $max;
            }
        }
        if (preg_match('~timestamp|date|datetime~', $column->Type)) {
            $rule .= '|date';
        }
        return $rule;
    }


    public function generate()
    {
        foreach ($this->getPaths() as $path)
            (new Filesystem())->put(
                $path,
                preg_replace(
                    ['~\s\s//~', '~false~'],
                    [$this->formateRules(), 'true'],
                    (new Filesystem())->get($path)
                )
            );
    }

    protected function makeResourceRoute()
    {
        $name = \str($this->argument('name')); 
        
        (new Filesystem)->append(
            base_path('routes/web.php'),
            \sprintf(
                "\nRoute::resource('%s', %sController::class);",
                $name->snake()->plural(),
                $name->studly()->singular()
            )
        );
    }


    public function formateRules()
    {
        return preg_replace(
            ['~array \(\n~', '~\n\)~', '~\n~'],
            ['', '', "\n" . str_repeat("\x20", 10)],
            var_export($this->rules, true)
        );
    }

    public function getPaths()
    {
        $paths = ['Store', 'Update'];
        array_walk(
            $paths, 
            fn (&$pathFor) => $pathFor = app_path(
                'Http/Requests/' . $pathFor . $this->argument('name') . 'Request.php'
            )
        );
        return $paths;
    }
}
