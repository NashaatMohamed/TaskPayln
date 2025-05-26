<?php

namespace App\Factory;


use App\Enums\Notification\NotificationTypeEnum;

class NotificationTypeFactory
{

    // new code
    public static function getNotificationMethods(?array $methods = []): array
    {
        if (empty($methods)) {
            return config("notification.default_channels");
        }

        $notificationMethods = [];
        foreach ($methods as $item) {
            $notificationMethods[] = EnumFactory::getName(NotificationTypeEnum::class,(int)$item);
        }
        return $notificationMethods;
    }
}
