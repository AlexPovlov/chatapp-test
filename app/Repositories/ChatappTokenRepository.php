<?php

namespace App\Repositories;

use App\Models\ChatappToken;

class ChatappTokenRepository extends AbstractRepository
{
    function __construct(protected ChatappToken $model)
    {
    }

    function firsCreate(
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

    function getAccessTokenFromId($id)
    {
        return $this->model->findOrFail($id)->access_token;
    }

    function deleteFromId($id)
    {
        return $this->model->whereId($id)->delete();
    }
}