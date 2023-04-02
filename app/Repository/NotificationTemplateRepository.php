<?php

namespace App\Repository;

use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class NotificationTemplateRepository
{
    /**
     * @param string $id
     *
     * @return NotificationTemplate|null
     */
    public function getDetail(string $id): ?NotificationTemplate
    {
        return NotificationTemplate::where(['id' => $id])->first();
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    public function add(Request $request): int
    {
        return NotificationTemplate::insert([
            'id' => Str::uuid()->toString(),
            'template_type' => $request->templateType,
            'template_name' => $request->templateName,
            'template_title' => $request->templateTitle,
            'template_content' => $request->templateContent,
            'created_at' => date('Y/m/d H:i:s'),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    public function update(Request $request): int
    {
        return NotificationTemplate::where('id', $request->id)
            ->update([
                'created_at' => now(),
                'template_name' => $request->templateName,
                'template_title' => $request->templateTitle,
                'template_content' => $request->templateContent,
            ]);
    }

    /**
     * @param string $id
     *
     * @return NotificationTemplate
     */
    public function getTemplateForSendMail(string $id): NotificationTemplate
    {
        return NotificationTemplate::where('id', $id)->first();
    }

    /**
     * @param string $notificationSender
     *
     * @return Collection
     */
    public function getTemplateByTemplateType(string $notificationSender): Collection
    {
        return NotificationTemplate::where(['template_type' => $notificationSender])->get();
    }

    /**
     * @return Collection
     */
    public function getAllTemplate(): Collection
    {
        return DB::table('notification_template')
            ->orderBy('created_at', 'desc')
            ->get(
                array(
                    'id',
                    'template_type',
                    'template_name',
                    'template_title',
                    'template_content',
                    'created_at',
                )
            );
    }
}
