<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractRepository
{
    public function getAll(
        array $with = [],
        $order = ['column' => 'id', 'order' => 'desc']
    ): Collection {
        if (!isset($this->model)) {
            throw new Exception('$model field required');
        }

        $query = $this->model;

        if (!empty($with)) {
            $query = $query->with($with);
        }

        return $query->orderBy($order['column'], $order['order'])->get();
    }
}
