<?php

namespace MWI\LaravelCrud\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class Crud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mwi:crud {model} {--no-migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates all the necessary files for our basic crud setup.';

    /**
     * The model to create the crud for
     * 
     * @var string
     */
    private $model;

    /**
     * The files to be created
     * 
     * @var array
     */
    private $files = [
        'app/{model}.php',
        'app/Http/Controllers/{model}sController.php',
        'app/Http/Requests/{model}Request.php',
        'app/Policies/{model}Policy.php',
        'app/Services/{model}Crud.php',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->model = $this->argument('model');

        if (!$this->option('no-migration')) {
            $this->call('make:migration', [
                'name' => strtolower('create_' . $this->model . 's_table'),
                '--table' => strtolower($this->model . 's')
            ]);
        }

        foreach ($this->files as $file) {
            $new_file = str_replace('{model}', $this->model, $file);
            $data_file = file_get_contents(__DIR__."/../".str_replace('{model}', 'Model', $file));

            if (!file_exists(dirname(base_path($new_file)))) {
                mkdir(dirname(base_path($new_file)), 0777, true);
            }

            if (!file_exists(base_path($new_file))) {
                $data = str_replace(['Model', ' model', '$model'], [$this->model, ' ' . strtolower($this->model), '$' . strtolower($this->model)], $data_file);
                file_put_contents(base_path($new_file), $data);
            }

            $this->comment($new_file . ' created');
        }

        $this->comment($this->model . ' is all set up.');
    }
}
