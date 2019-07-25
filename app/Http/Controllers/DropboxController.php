<?php

namespace App\Http\Controllers;

use App\Jobs\SyncDropbox;
use Illuminate\Http\Request;

class DropboxController extends Controller
{
    public function hook(Request $request)
    {
        SyncDropbox::dispatch()->delay(now()->addSeconds(5));
    
        return response($request->challenge)
            ->header('Content-Type', 'text/plain')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    public function show(Request $request)
    {

    }
}
