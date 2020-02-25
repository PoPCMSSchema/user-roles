<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInPrivateSchemaHookSet;
use PoP\UserRoles\Conditional\UserState\Environment;

class MaybeDisableFieldsIfUserNotLoggedInPrivateSchemaHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInPrivateSchemaHookSet
{
    use MaybeDisableFieldsIfConditionHookSetTrait;

    protected function enabled(): bool
    {
        if (!parent::enabled()) {
            return false;
        }

        return Environment::userMustBeLoggedInToAccessRolesFields();
    }
}
