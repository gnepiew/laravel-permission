<?php

namespace Gnepiew\Permission\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider']);
        $this->call('migrate');

        $this->call('vendor:publish', ['--tag' => 'permission-migrations']);
        $this->call('migrate');

        $this->call('vendor:publish', [
            '--tag' => 'permission-config',
            '--force' => true
        ]);
    }
}
