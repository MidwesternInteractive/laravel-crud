<?php

namespace MWI\LaravelCrud\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class Crud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @argument {model}          The name of the model to create
     * @option   {--with}         This will prompt the user to specify what to include
     * @option   {--no-migration} Exclude the migration from this CRUD
     * @var string
     */
    protected $signature = 'mwi:crud {model} {--with} {--no-migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates all the necessary files for our basic CRUD setup.';

    /**
     * The model to create the crud for
     * 
     * @var string
     */
    private $model;

    /**
     * The resources to include
     * 
     * @var array
     */
    private $resources = false;

    /**
     * The files to be created
     * 
     * @var array
     */
    private $files = [
        'model'      => 'app/{model}.php',
        'controller' => 'app/Http/Controllers/{model}Controller.php',
        'handler'    => 'app/Services/{model}Handler.php',
        'policy'     => 'app/Policies/{model}Policy.php',
        'request'    => 'app/Http/Requests/{model}Request.php',
        'management' => 'app/Traits/{model}Management.php',
        'helpers'    => 'app/Traits/{model}Helpers.php'
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('with')) {
            $this->comment('Available Resources: model controller handler policy request management helpers');
            $include = $this->ask('What would you like to include from the above options? Separate by spaces');
            $this->resources = explode(' ', $include);
        }
        $this->model = $this->argument('model');

        if (! $this->option('no-migration')) {
            $this->call('make:migration', [
                'name' => strtolower('create' . implode('_', preg_split('/(?=[A-Z])/', $this->model)) . '_table'),
                '--table' => strtolower($this->model . 's')
            ]);
        }

        foreach ($this->files as $item => $file) {
            if (is_array($this->resources) && ! in_array($item, $this->resources)) {
                continue;
            }
            $new_file = str_replace('{model}', $this->model, $file);
            $data_file = file_get_contents(__DIR__."/../".str_replace('{model}', 'TheModel', $file));

            if (!file_exists(dirname(base_path($new_file)))) {
                mkdir(dirname(base_path($new_file)), 0777, true);
            }

            if (!file_exists(base_path($new_file))) {
                $data = str_replace([
                    'TheModel',
                    'themodel',
                    ' model',
                    '$theModel',
                    '->theModel'
                ], [
                    $this->model,
                    strtolower($this->model),
                    ' ' . strtolower($this->model),
                    '$' . strtolower($this->model),
                    '->' . strtolower($this->model)
                ], $data_file);
                file_put_contents(base_path($new_file), $data);
            }

            $this->info($new_file . ' created');
        }

        $this->comment($this->model . ' is all set up.');
    }
}
