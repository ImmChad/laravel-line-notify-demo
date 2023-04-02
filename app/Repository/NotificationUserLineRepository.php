<?php

namespace App\Repository;

use App\Models\NotificationUserLine;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class NotificationUserLineRepository
{
    /**
     * @param string $id
     *
     * @return NotificationUserLine|null
     */
    public function getDetail(string $id): ?NotificationUserLine
    {
        return DB::table('notification_user_line')->where('user_id', $id)->first();
    }

    /**
     * @param string $id
     *
     * @return Collection
     */
    public function getListUserLine(string $id): Collection
    {
        return DB::table('notification_user_line')->where('user_id', $id)->get();
    }

    /**
     * @return Builder
     */
    public function getAllUserIdUserLine(): Builder
    {
        return DB::table('notification_user_line')->select("user_id");
    }


    /**
     * @param string $userId
     *
     * @return string|null
     */
    public function getLineIdWithUserId(string $userId): ?string
    {
        $dataLine = DB::table("notification_user_line")->where("user_id", $userId)->get("line_id")->first();

        return $dataLine?->line_id;
    }
}
