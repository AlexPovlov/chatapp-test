<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatappTokenRequest;
use App\Repositories\ChatappTokenRepository;
use App\Services\Interfaces\ChatappApiInterface;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ChatappController extends Controller
{
    public function __construct(
        protected ChatappTokenRepository $chatappTokenRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokens = $this->chatappTokenRepository->getAll();

        return Inertia::render('Token', compact('tokens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ChatappTokenRequest $request,
        ChatappApiInterface $chatappApi
    ) {
        $validated = $request->validated();
        $response = $chatappApi->tokens(
            $validated['app_id'],
            $validated['email'],
            $validated['password']
        );

        if (!$response['success']) {
            return Redirect::back()->withErrors('Ошибка: не верные данные');
        }

        $data = $response['data'];
        $this->chatappTokenRepository->firsCreate(
            $validated['app_id'],
            $data['accessToken'],
            $data['accessTokenEndTime'],
            $data['refreshToken'],
            $data['refreshTokenEndTime'],
        );

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->chatappTokenRepository->deleteFromId($id);

        return Redirect::back();
    }
}
