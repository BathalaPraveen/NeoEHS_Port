<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:resource {folder} {filename}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a controller, model, and Blade view in the specified folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folder = $this->argument('folder');
        $folder1 = Str::ucfirst($folder);
        $filename = $this->argument('filename');
        $filename1 = Str::ucfirst($this->argument('filename'));
        public_path();
        // Create controller in the specified folder
        $controllerName = Str::studly($filename) . 'Controller';
        $controllerDirectory = app_path("Http/Controllers/{$folder1}");
        File::makeDirectory($controllerDirectory, 0755, true, true);
        $this->call('make:controller', ['name' => "{$folder1}/{$controllerName}"]);

        // Create model in the specified folder
        $modelDirectory = app_path("Models/{$folder1}");

        File::makeDirectory($modelDirectory, 0755, true, true);
        $this->call('make:model', ['name' => "{$folder1}/{$filename1}"]);

        // Create Blade view in the specified folder
        $views = ['list', 'add', 'edit', 'view', 'excel', 'pdf'];

        $viewDirectory = resource_path("views/{$folder}");
        $viewDirectory1 = resource_path("views/{$folder}/{$filename}");

        //File::makeDirectory($viewDirectory, 0755, true, true);
        File::makeDirectory($viewDirectory1, 0755, true, true);
        foreach ($views as $view) {
            $this->call('make:view', ['name' => "{$folder}/{$filename}/{$view}"]);
        }

        $this->info("Controller, model, and view created in folder '{$folder}' with filename '{$filename}'.");
    }
}
