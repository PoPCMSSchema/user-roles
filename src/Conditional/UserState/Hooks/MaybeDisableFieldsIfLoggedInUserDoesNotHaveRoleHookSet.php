<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\UserRoles\Hooks\AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet;

class MaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet extends AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet
{
    use MaybeDisableFieldsIfLoggedInUserDoesNotHaveItemHookSetTrait;

    protected function getRoleName(): ?string
    {
        return Environment::roleLoggedInUserMustHaveToAccessRolesFields();
    }
}
