<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\UserRoles\Hooks\AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRolePrivateSchemaHookSet;

class MaybeDisableFieldsIfLoggedInUserDoesNotHaveRolePrivateSchemaHookSet extends AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRolePrivateSchemaHookSet
{
    use MaybeDisableFieldsIfConditionPrivateSchemaHookSetTrait;

    protected function getRoleNames(): array
    {
        if ($roleName = Environment::roleLoggedInUserMustHaveToAccessRolesFields()) {
            return [$roleName];
        }
        return [];
    }
}
