<?php

namespace Pletfix\Hello\Commands;

use Core\Services\Command;

class HelloCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bla:blub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the database.';

    /**
     * Possible arguments of the command.
     *
     * @var array
     */
    protected $arguments = [
//        'file'  => ['type' => 'string', 'description' => 'Migration File'],
        'dummy' => ['type' => 'string', 'default' => 'hello', 'description' => 'Dummy'],
    ];

    /**
     * Possible options of the command.
     *
     * @var array
     */
    protected $options = [
        'rollback' => ['type' => 'bool',   'short' => 'r', 'description' => 'Rollback'],
        'batch'    => ['type' => 'string', 'short' => 'b', 'default' => null, 'description' => 'Batch Number'],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $a = $this->secret('Geheim');
//        fopen('fsdf', 'r');

//          $b = 0;
//          $a = 4 / $b; // Exception
        $this->abort($a);


        $a = $this->confirm('Geheim');
//        $a = $this->choice('ohne', ['alpha', 'beta', 'gamma']);
        $this->line('Your answer ' . $a);

        $this->clear();

        $a = $this->ask('mit', 'hello');
        $this->line('Your answer ' . $a);

//        $this->line('line');
//        $this->info('info');
//        $this->notice('notice');
//        $this->question('question');
//        $this->warn('warn');
//        $this->error('error');
    }
}