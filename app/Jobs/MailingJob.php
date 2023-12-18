<?php

namespace App\Jobs;

use App\Models\MailingStatus;
use App\Services\Interfaces\ChatappApiInterface;
use App\Services\Interfaces\MailingJobServiceInterface;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MailingJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
    public function handle(
        MailingJobServiceInterface $mailingJobService,
        ChatappApiInterface $chatappApi
    ): void {
        $chatappApi->setToken($this->token);

        try {
            $response = $chatappApi->messageWhatsApp($this->message, $this->phone);
            $status = $response['success'];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error($e->getResponse()->getBody());
            $status = false;
        }
        
        $mailingJobService->setPhoneMailingStatus($this->status, $status);
        $mailingJobService->eventMailing($this->status->mailing_id);
    }
}
