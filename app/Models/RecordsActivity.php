<?php

namespace App\Models;

use ReflectionClass;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        foreach (static::getEventNames() as $event) {
            static::$event(function ($subject) {
                if (auth()->guest()) return;

                static::createActivity($subject);
            });
        }
    }

    public static function getEventNames()
    {
        return ['created'];
    }

    public static function createActivity($subject)
    {
        $subject->activities()->create([
            'type' => static::getActivityType($subject, 'created'),
            'user_id' => auth()->id(),
            'created_at' => $subject->created_at,
            'updated_at' => $subject->updated_at
        ]);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    private static function getActivityType($thread, $event)
    {
        $name = strtolower((new ReflectionClass($thread))->getShortName());

        return "{$event}_{$name}";
    }
}
