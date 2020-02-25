<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\UserRoles\Hooks\AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet;

class MaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet extends AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet
{
    use MaybeDisableFieldsIfConditionHookSetTrait;

    protected function getRoleName(): ?string
    {
        return Environment::roleLoggedInUserMustHaveToAccessRolesFields();
    }
}
