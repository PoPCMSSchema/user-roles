<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet;
use PoP\UserRoles\Conditional\UserState\Environment;

class MaybeDisableFieldsIfUserNotLoggedInHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet
{
    use MaybeDisableFieldsIfLoggedInUserDoesNotHaveItemHookSetTrait;

    protected function enabled(): bool
    {
        if (!parent::enabled()) {
            return false;
        }

        return Environment::userMustBeLoggedInToAccessRolesFields();
    }
}
