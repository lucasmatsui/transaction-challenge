<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Http;
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
        $response = Http::timeout(15)->get(env('URL_NOTIFY_SEND_EMAIL'));
        $response = $response->json();

        if ($response['message'] != 'Success') {
            throw new NotFoundHttpException("Algo deu errado ao disparar e-mail");
        }

        return $this->data;
    }
}
