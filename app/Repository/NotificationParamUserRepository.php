<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class NotificationParamUserRepository
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return DB::table('notification_param_user')->get();
    }
}
