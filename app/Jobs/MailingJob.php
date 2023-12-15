<?php

namespace App\Jobs;

use App\Models\MailingStatus;
use App\Services\Interfaces\ChatappApiInteface;
use App\Services\Interfaces\MailingJobServiceInterface;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MailingJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $message,
        protected string $phone,
        protected MailingStatus $status,
        protected string $token,
        public $delay
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(MailingJobServiceInterface $mailingJobService, ChatappApiInteface $chatappApi): void
    {
        $chatappApi->setToken($this->token);
        dump($this->message, $this->phone, $this->token);
        try {
            $response = $chatappApi->messageWhatsApp($this->message, $this->phone);

            $status = $response['success'];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $body = json_decode($e->getResponse()->getBody(), true);

            dump($body);
            $status = false;
        }
        $mailingJobService->setPhoneMailingStatus($this->status, $status);
        $mailingJobService->eventMailing($this->status->mailing_id);
    }
}
