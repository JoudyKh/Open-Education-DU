<?php

namespace App\Services\General\Notification;

use App\Constants\Constants;
use App\Constants\Notifications;
use App\Http\Resources\NotificationRecourse;
use App\Models\User;  
use App\Models\Student;  
use Illuminate\Support\Facades\DB;

class NotificationService
{
    protected User|Student|null $user;

    public function __construct()
    {
        $authUser = auth('sanctum')->user();  

        if ($authUser instanceof User) {  
            $this->user = $authUser;  
        } elseif ($authUser instanceof Student) {  
            $this->user = $authUser; 
        } else {  
            $this->user = null; 
        }  
    }



    public function getAllNotifications($hasRead = null, $countOnly = null, $read = '0')
    {
        $notifications = $this->user->notifications();
        if ($hasRead !== null) {
            $notifications->where('has_read', $hasRead);
        }
        if ($countOnly) {
            return $notifications->count();
        }
        $notifications = $notifications->orderBy('id', 'DESC')->paginate(config('app.pagination_limit'));
        return NotificationRecourse::collection($notifications);
    }
    public function getNotificationTypeStatistics($hasRead = null)
    {
        $stats = $this->user->notifications();
        if ($hasRead !== null) {
            $stats->where('has_read', $hasRead);
        }
        return $stats->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type');
    }


    public function readAllNotifications()
    {
        return  $this->user->notifications()->update(['has_read' => 1]);
    }



    public function pushAdminsNotifications($notification, $user, $title = null, $description = null)
    {
        app()->setLocale('ar');  
        switch ($notification['STATE']) {
            case Notifications::NEW_REGISTRATION['STATE']:
                $description = __('notifications.new_registration_description', []);
                $title = __('notifications.new_registration_title', []);
                break;
            default:
                return;
        }
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', Constants::SUPER_ADMIN_ROLE);
        })->get();

        foreach ($admins as $admin) {
            pushNotification(
                $title,
                $description,
                $notification['TYPE'],
                $notification['STATE'],
                $admin,
                class_basename($user),
                $user->id
            );
        }
    }
  

    public function pushNotification($title, $description, $type, $state, $user, $modelType, $modelId, $checkDuplicated = false)
    {
        $data = [
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'state' => $state,
            'model_id' => $modelId,
            'model_type' => $modelType,
        ];

        if ($checkDuplicated) {
            $filteredData = array_diff_key($data, array_flip(['title', 'description']));
            $user->notifications()->firstOrCreate($filteredData, $data);
        } else
            $user->notifications()->create($data);
    }
}
