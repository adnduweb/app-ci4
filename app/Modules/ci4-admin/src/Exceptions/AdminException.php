<?php

namespace Adnduweb\Ci4Admin\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;
use RuntimeException;

class AdminException extends RuntimeException implements ExceptionInterface
{
    public static function forNoWorkflowAvailable()
    {
        return new static(lang('Core.noWorkflowAvailable'), 404);
    }

    public static function forWorkflowNotFound()
    {
        return new static(lang('Core.workflowNotFound'), 404);
    }

    public static function forWorkflowNotPermitted()
    {
        return new static(lang('Core.workflowNotPermitted'), 403);
    }

    public static function forUserNotFound()
    {
        return new static(lang('Core.userNotFound'), 404);
    }

    public static function forActionNotFound()
    {
        return new static(lang('Core.actionNotFound'), 404);
    }

    public static function forJobNotFound()
    {
        return new static(lang('Core.jobNotFound'), 404);
    }

    public static function forStageNotFound()
    {
        return new static(lang('Core.stageNotFound'));
    }

    public static function forMissingStages()
    {
        return new static(lang('Core.workflowNoStages'));
    }

    public static function forSkipRequiredStage($name)
    {
        return new static(lang('Core.skipRequiredStage', [$name]));
    }

    public static function forMissingJobId($route = '')
    {
        return new static(lang('Core.routeMissingJobId', [$route]));
    }

    public static function forUnsupportedActionMethod($action, $method)
    {
        return new static(lang('Core.actionMissingMethod', [$action, $method]));
    }
}
