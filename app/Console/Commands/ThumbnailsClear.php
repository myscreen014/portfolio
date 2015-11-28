<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/* My uses */
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class ThumbnailsClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbnails:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear thumbnails files';

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
        $thumbnailsDir = Config::get('thumbnail.path');
        if (File::deleteDirectory($thumbnailsDir)) {
            $this->info('Thumbnails are cleared.');
        }
    }
}
