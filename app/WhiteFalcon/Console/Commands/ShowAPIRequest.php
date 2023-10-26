<?php

namespace WhiteFalcon\Console\Commands;

use Illuminate\Console\Command;

class ShowAPIRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:request {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the dummy request data for a model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fields = (new ('\App\Http\\Requests\\Store' . $this->argument('name') . 'Request'))->rules();
        $this->newLine(2);
        array_walk($fields, [$this, 'generateOutput']);
        $this->newLine(2);
        $this->withProgressBar($fields, fn($field) => $field );
    }

    public function generateOutput($rules, $column)
    {
        try {
            $value = $column != 'password' ? fake()->$column() : 'testtest';
        } catch(\Throwable $th) {
            $methods = ['paragraph', 'name', 'realText', 'randomNumber'];
            $method = !preg_match('~integer~', $rules) ? $methods[\array_rand($methods)] : 'randomNumber';
            $value = fake()->$method();
        }
        $this->comment( $column . ':' . $value);
    }
}
