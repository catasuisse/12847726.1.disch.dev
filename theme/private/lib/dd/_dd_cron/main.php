<?php

class dd_cron
{
    public static function deleteUnusedFavorites()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/deleteUnusedFavorites.php');
    }

    public static function deleteUnusedDirectories()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/deleteUnusedDirectories.php');
    }

    public static function notifyClientsAboutMeetings()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/notifyClientsAboutMeetings.php');
    }

    public static function pullAbsencesFromCalendar()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullAbsencesFromCalendar.php');
    }

    public static function pullAvailabilityFromCalendly()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullAvailabilityFromCalendly.php');
    }

    public static function pullClientsFromHarvest()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullClientsFromHarvest.php');
    }

    public static function pullDataFromNomadList()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullDataFromNomadList.php');
    }

    public static function pullDataFromSlack($preventNotification = false)
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullDataFromSlack.php');
    }

    public static function pullDataFromTimeZone()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullDataFromTimeZone.php');
    }

    public static function pullExceptionFromCalendar()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullExceptionFromCalendar.php');
    }

    public static function pullInvoicesFromHarvest()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullInvoicesFromHarvest.php');
    }

    public static function pullMeetingsAndTargetsFromCalendar()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullMeetingsAndTargetsFromCalendar.php');
    }

    public static function pullNextPostFromJournal()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pullNextPostFromJournal.php');
    }

    public static function pushFilesToDropbox()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/pushFilesToDropbox.php');
    }

    public static function resetException()
    {
        require_once(dd::documentRoot() . '/theme/private/lib/dd/_dd_cron/functions/resetException.php');
    }
}
