<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailingRequest;
use App\Repositories\ChatappTokenRepository;
use App\Repositories\MailingRepository;
use App\Services\Interfaces\MailingServiceInterface;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MailingController extends Controller
{
    public function __construct(
        protected MailingRepository $mailingRepository,
        protected ChatappTokenRepository $chatappTokenRepository
    ) {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mailings = $this->mailingRepository->getAll(['phones']);
        $tokens = $this->chatappTokenRepository->getAll();

        return Inertia::render('Mailing', compact('mailings', 'tokens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MailingRequest $request, MailingServiceInterface $mailingService)
    {
        $validated = $request->validated();
        $token = $this->chatappTokenRepository
            ->getAccessTokenFromId($validated['token_id']);
        $mailing = $mailingService->createRecord(
            $validated['message'],
            $validated['phones']
        );
        $mailingService->handleJob($mailing, $token);

        return Redirect::back();
    }
}
