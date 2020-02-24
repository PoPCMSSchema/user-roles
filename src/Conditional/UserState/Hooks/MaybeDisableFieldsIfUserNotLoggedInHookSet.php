<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet;
use PoP\UserRoles\Conditional\UserState\Environment;

class MaybeDisableFieldsIfUserNotLoggedInHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet
{
    protected function enabled(): bool
    {
        return Environment::userMustBeLoggedInToAccessRolesFields();
    }
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
