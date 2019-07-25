<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\Dropbox\Client;
use App\Sync;
use App\Photo;

class SyncDropbox implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $client = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sync();
    }

    private function sync()
    {
        $this->client = new Client(config('dropbox.access-token'));

        $this->syncPhotos();
        $this->syncTexts();
    }

    private function syncTexts()
    {
        $folder = $this->client->listFolder('/' . config('dropbox.texts-path'));
    
        $dropbox_ids = [];

        foreach($folder['entries'] as $entry) {
            $dropbox_ids[] = $entry['id'];
            
            $file = $this->client->download($entry['id']);

            dd($file);

            /*if(!Photo::where('dropbox_id', $entry['id'])->exists()) {
                $p = new Photo();

                $p->dropbox_id = $entry['id'];
                $p->content = $this->client->getThumbnail($entry['id'], 'jpeg', 'w480h320');

                $p->save();
            }*/
        }

        Photo::whereNotIn('dropbox_id', $dropbox_ids)->delete();

        $s = new Sync();

        $s->folder = config('dropbox.photos-path');

        $s->save();
    }

    private function syncPhotos()
    {
        $folder = $this->client->listFolder('/' . config('dropbox.photos-path'));

        $dropbox_ids = [];

        foreach($folder['entries'] as $entry) {
            $dropbox_ids[] = $entry['id'];
            
            if(!Photo::where('dropbox_id', $entry['id'])->exists()) {
                $p = new Photo();

                $p->dropbox_id = $entry['id'];
                $p->content = $this->client->getThumbnail($entry['id'], 'jpeg', 'w480h320');

                $p->save();
            }
        }

        Photo::whereNotIn('dropbox_id', $dropbox_ids)->delete();

        $s = new Sync();

        $s->folder = config('dropbox.photos-path');

        $s->save();
    }
}
