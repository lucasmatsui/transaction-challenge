<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProcessEmailJob extends Job
{
    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::get(env('URL_NOTIFY_SEND_EMAIL'));
        $response = $response->json();

        if ($response['message'] != 'Success') {
            return false;
        }

        return $this->data;
    }
}
