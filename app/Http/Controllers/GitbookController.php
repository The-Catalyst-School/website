<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class GitbookController extends Controller
{

    protected function validateGithubWebhook($known_token, Request $request)
    {
        if (($signature = $request->headers->get('X-Hub-Signature')) == null) {
            throw new \Exception('Header not set');
        }

        $signature_parts = explode('=', $signature);

        if (count($signature_parts) != 2) {
            throw new \Exception('signature has invalid format');
        }

        $known_signature = hash_hmac('sha1', $request->getContent(), $known_token);

        if (! hash_equals($known_signature, $signature_parts[1])) {
            throw new \Exception('Could not verify request signature ' . $signature_parts[1]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateGithubWebhook(config('app.github_webhook_secret'), $request);
        Artisan::call('gitbook:pull');
    }

}
