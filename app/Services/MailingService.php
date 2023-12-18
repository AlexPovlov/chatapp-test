<?php

namespace App\Services;

use App\Jobs\MailingJob;
use App\Models\Mailing;
use App\Repositories\MailingRepository;
use App\Repositories\PhoneRepository;
use App\Services\Interfaces\MailingServiceInterface;
use Illuminate\Support\Facades\Bus;

class MailingService implements MailingServiceInterface
{
    function __construct(
        protected MailingRepository $mailingRepository,
        protected PhoneRepository $phoneRepository
    ) {
    }

    function createRecord(string $message, array $phones)
    {
        $phones = collect($phones)->unique('phone')->values()->all();
        $this->phoneRepository->upsert($phones);
        $phonesDb = $this->phoneRepository
            ->getFromPhonesArray(array_column($phones, 'phone'));

        $phoneIds = $phonesDb->pluck('id')->toArray();

        $mailing = $this->mailingRepository
            ->createAndAttachPhones($message, $phoneIds);

        return $mailing;
    }

    function handleJob(Mailing $mailing, string $token)
    {
        $batch = [];
        $delay = 0;

        foreach ($mailing->phones as $phone) {
            $batch[] = new MailingJob(
                $mailing->message,
                $phone->phone,
                $phone->pivot,
                $token,
                $delay += rand(5, 50)
            );
        }
        
        Bus::batch($batch)->dispatch();

        return true;
    }
}
