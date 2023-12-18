<?php

namespace App\Console\Commands;

use App\Models\ChatappToken;
use App\Services\Interfaces\ChatappApiInterface;
use Illuminate\Console\Command;

class RefreshChatappAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-chatapp-access-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление токенов доступа к сервису chatapp';

    /**
     * Execute the console command.
     */
    public function handle(ChatappApiInterface $chatappApi)
    {
        $tokens = ChatappToken::all();

        foreach ($tokens as $token) {
            $response = $chatappApi->refresh($token->refresh);
            $data = $response['data'];
            $token->update([
                'access_token' => $data['accessToken'],
                'access_token_end_time' => $data['accessTokenEndTime'],
                'refresh_token' => $data['refreshToken'],
                'refresh_token_end_time' => $data['refreshTokenEndTime'],
            ]);
        }
    }
}
