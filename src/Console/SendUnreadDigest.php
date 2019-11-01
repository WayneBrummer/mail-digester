<?php

namespace Pace\MailDigester\Console;

use Illuminate\Console\Command;
use Pace\MailDigester\Digester;

class SendUnreadDigest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail-digest:unread {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send All Un-read notifications in a digest to users.';

    /**
     * Create a new command instance.
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
        (new Digester($this->argument('user')))->sendDigest();
    }
}
