<?php

namespace MWI\LaravelCrud\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class Crud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @option   {--api}          Crete the resources for an API}
     * @option   {--with}         This will prompt the user to specify what to include
     * @option   {--no-migration} Exclude the migration from this CRUD
     * @argument {model}          The name of the model to create
     * @argument {plural}         The plural of the models name
     *
     * @var string
     */
    protected $signature = 'make:crud
                            {--no-migration : Do not include a migration with this CRUD}
                            {--with : Propmt to specify what resources to include}
                            {--api : Crete the resources for an API}
                            {model : The name of the model to create}
                            {plural : The plural of the models name}';

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
     * The plural of model
     *
     * @var string
     */
    private $plural;

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
        'model'             => 'app/{model}.php',
        'controller'        => 'app/Http/Controllers/{model}Controller.php',
        'api_controller'    => 'app/Http/Controllers/Api/ApiController.php',
        'handler'           => 'app/Services/{model}Handler.php',
        'policy'            => 'app/Policies/{model}Policy.php',
        'request'           => 'app/Http/Requests/{model}Request.php',
        'management'        => 'app/Traits/{model}Management.php',
        'helpers'           => 'app/Traits/{model}Helpers.php',
        'transformer'       => 'app/Transformers/{model}Transformer.php',
        'factory'           => 'database/factories/{model}Factory.php',

        // Views
        'index'             => 'resources/views/{models}/index.blade.php',
        'create'            => 'resources/views/{models}/create.blade.php',
        'show'              => 'resources/views/{models}/show.blade.php',
        'edit'              => 'resources/views/{models}/edit.blade.php',

        // Tests
        'feature'           => 'tests/Feature/{model}Test.php',
        'unit'              => 'tests/Unit/{model}Test.php',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Set the model name
        $this->model = $this->argument('model');
        $this->plural = $this->argument('plural');

        // Prompt user to specify resources required
        if ($this->option('with')) {
            $this->comment('Available Resources: model controller handler policy request management helpers transformer factory views tests');
            $include = $this->ask('What would you like to include from the above options? Separate by spaces');
            $this->resources = explode(' ', $include);
        }

        if ($this->option('api')) {
            $this->files['api'] = 'app/Http/Controllers/Api/{model}Controller.php';
        }

        if (is_array($this->resources)) {
            if (in_array('views', $this->resources)) {
                unset($this->resources[array_search('views', $this->resources)]);
                $this->resources += ['index', 'create', 'show', 'edit'];
            }
            if (in_array('tests', $this->resources)) {
                unset($this->resources[array_search('tests', $this->resources)]);
                $this->resources += ['feature', 'unit'];
            }
        }


        // Create the replacements array for the new files
        $replacements = [
            'TheModels' => $this->plural,
            'themodels' => ltrim(strtolower($this->plural)),
            'the-models' => ltrim(strtolower(implode('-', preg_split('/(?=[A-Z])/', $this->plural))), '-'),
            'the_models' => ltrim(strtolower(implode('_', preg_split('/(?=[A-Z])/', $this->plural))), '_'),
            'themodel' => ltrim(strtolower($this->model)),
            'TheModel' => $this->model,
            'theModel' => lcfirst($this->model),
            'the_model' => ltrim(strtolower(implode('_', preg_split('/(?=[A-Z])/', $this->model))), '_'),
            'the-model' => ltrim(strtolower(implode('-', preg_split('/(?=[A-Z])/', $this->model))), '-'),
            'the model' => ltrim(strtolower(implode(' ', preg_split('/(?=[A-Z])/', $this->model))), ' '),
            'The Model' => ltrim(implode(' ', preg_split('/(?=[A-Z])/', $this->model)), ' ')
        ];

        // Create the migration
        if (! $this->option('no-migration')) {
            $this->call('make:migration', [
                'name' => strtolower('create_' . $replacements['the_models'] . '_table'),
                '--create' => $replacements['the_models']
            ]);
        }

        // Loop through each resource and create an instance for the new model
        foreach ($this->files as $item => $file) {

            // Skip if they didn't specify they needed the file or if the file is api_controller with no API option
            if ((is_array($this->resources) && ! in_array($item, $this->resources)) || ($item == 'api_controller' && ! $this->option('api'))) {
                continue;
            }

            // Create the new filename and get the data from our templates
            $search = ['{model}', '{models}'];
            $replace = [
                $this->model,
                $replacements['the-models']
            ];
            $new_file = str_replace($search, $replace, $file);
            $data_file = file_get_contents(__DIR__."/../".str_replace(['{model}', '{models}'], ['TheModel', 'the-models'], $file));

            // If the folder for the file doesn't exist create it
            if (! file_exists(dirname(base_path($new_file)))) {
                mkdir(dirname(base_path($new_file)), 0777, true);
            }

            // If the file doesn't already exist create it
            if (! file_exists(base_path($new_file))) {
                $data = str_replace(array_keys($replacements), array_values($replacements), $data_file);
                file_put_contents(base_path($new_file), $data);
            }

            $this->info($new_file . ' created');
        }

        // Loop through each view and create an instance for the new model

        $this->comment($this->model . ' is all set up.');
    }
}
