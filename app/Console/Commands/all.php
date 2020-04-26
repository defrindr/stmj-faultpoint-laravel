<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class all extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:all {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model, controller, repository, migration in 1 time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // system("php artisan make:model ".$this->argument('name'). "Model");
        // $this->info('Success Generate Model ... ');
        system("php artisan make:controller ". $this->argument('name'). "Controller --model=Models/". $this->argument('name'));
        $this->info('Success Generate Controller ... ');
        system("php artisan make:request ". $this->argument('name'). "Request");
        $this->info('Success Generate Request ... ');
        // system("php artisan make:migration create_table_". strtolower($this->argument('name')). " --create=". strtolower($this->argument('name')). "s");
        // $this->info('Success Generate Migration ... ');
        // system("php artisan make:seeder ". $this->argument('name'). "Seeder");
        // $this->info('Success Generate Seeder ... ');
        // system("php artisan make:factory ". $this->argument('name'). "Factory --model=Models/". $this->argument('name'). "Model");
        // $this->info('Success Generate Factory ... ');
    }
}
