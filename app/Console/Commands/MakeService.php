<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceName = $this->argument('name');
        $serviceName = str_replace('/', '\\', $serviceName); // Replace forward slash with backslash
        $parts = explode('\\', $serviceName);
        $className = array_pop($parts);
        $subdirectories = implode('\\', $parts);

        $servicePath = app_path("Services/{$subdirectories}");
        $servicePath .= $subdirectories ? '/' : ''; // Add a slash if subdirectories exist
        $servicePath .= "{$className}.php";

        // Create the directory if it doesn't exist
        if (!File::exists($servicePath)) {
            File::makeDirectory(dirname($servicePath), 0755, true, true);
        }

        if (File::exists($servicePath)) {
            $this->error('Service already exists!');
            return;
        }

//        dd($parts, $className, $subdirectories, $servicePath);
        $stub = File::get(__DIR__ . '/stubs/service.stub.php');
        $stub = str_replace('{{ServiceName}}', $className, $stub);
        if ($subdirectories) {
            $namespace = "App\Services\\{$subdirectories}";
        } else {
            $namespace = "App\Services;";
        }
        $stub = str_replace('{{name_space}}', $namespace, $stub);

        File::put($servicePath, $stub);
        $this->line("Service [<info>{$servicePath}</info>] created successfully.");
    }
}
