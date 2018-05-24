<?php

namespace App\Console\Commands;

use App\Post;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PolymorphicSpeedTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'polymorphic-speed-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Model::unguard();
        \DB::table('posts')->truncate();
        \DB::table('comments')->truncate();
        $this->insertData();
        $this->error('Without indexes');
        $this->testSpeed();


        Schema::table('comments', function (Blueprint $table) {
            $table->index('commentable_id');
            $table->index('commentable_type');
        });
        $this->error('With indexes');
        $this->testSpeed();
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('comments_commentable_id_index');
            $table->dropIndex('comments_commentable_type_index');
        });


        $this->error('Multiple columns index');
        Schema::table('comments', function (Blueprint $table) {
            $table->index(['commentable_id', 'commentable_type']);
        });
        $this->testSpeed();
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('comments_commentable_id_commentable_type_index');
        });
    }

    public function insertData()
    {
        \DB::beginTransaction();
        \DB::table('posts')->insert($this->getTestingPosts());
        $posts = Post::all();
        foreach ($posts as $post) {
            $post->comments()->createMany($this->getTestingComments());
        }
        \DB::commit();
    }

    private function testSpeed()
    {
        \DB::flushQueryLog();
        \DB::enableQueryLog();
        for ($i = 1; $i <= Post::count(); $i++) {
            $post = Post::with('comments')->find($i);
        }
        $log = \DB::getQueryLog();
        $this->parseLog($log);
    }

    private function getTestingPosts(): array
    {
        $posts = [];
        for ($i = 0; $i < 100; $i++) {
            $posts[] = [
                'title' => 'Title',
                'body' => 'body'
            ];
        }
        return $posts;
    }

    private function getTestingComments(): array
    {
        $comments = [];
        for ($i = 0; $i < 100; $i++) {
            $comments[] = [
                'body' => 'body'
            ];
        }
        return $comments;
    }

    private function parseLog(array $log)
    {
        $times = [];
        foreach ($log as $query){
            $times[] = $query['time'];
        };
        $sum = array_sum($times);
        $this->info("Total query time: {$sum} ms");
        $average = $sum/count($times);
        $this->info("Average query time: {$average} ms");
    }
}