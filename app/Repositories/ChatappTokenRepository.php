<?php

namespace App\Repositories;

use App\Models\ChatappToken;

class ChatappTokenRepository extends AbstractRepository
{
    public function __construct(protected ChatappToken $model)
    {
    }

    public function firsCreate(
        $appId,
        $accessToken,
        $accessTokenEndTime,
        $refreshToken,
        $refreshTokenEndTime,
    ) {
        return $this->model->firstOrCreate(['app_id' => $appId], [
            'access_token' => $accessToken,
            'access_token_end_time' => $accessTokenEndTime,
            'refresh_token' => $refreshToken,
            'refresh_token_end_time' => $refreshTokenEndTime,
        ]);
    }

    public function getAccessTokenFromId($id)
    {
        return $this->model->findOrFail($id)->access_token;
    }

    public function deleteFromId($id)
    {
        return $this->model->whereId($id)->delete();
    }
}