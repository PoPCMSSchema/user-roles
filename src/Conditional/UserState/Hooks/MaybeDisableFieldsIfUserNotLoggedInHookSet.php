<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet;

class MaybeDisableFieldsIfUserNotLoggedInHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet
{
    /**
     * Disable fields "roles" and "capabilities"
     *
     * @return array
     */
    protected function getFieldNames(): array
    {
        return [
            'roles',
            'capabilities',
        ];
    }
}
