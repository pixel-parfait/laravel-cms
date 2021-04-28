<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Page;

class CreatePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new page';

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
     * @return int
     */
    public function handle()
    {
        $index = $this->ask("Index");
        $title = $this->ask("Title");

        $page = Page::create([
            'index' => $index,

            config('app.locale') => [
                'title' => $title,
                'slug' => Str::slug($title),
            ],
        ]);

        $this->info("The page \"{$title}\" has been created with the ID #{$page->id}");

        return 0;
    }
}
