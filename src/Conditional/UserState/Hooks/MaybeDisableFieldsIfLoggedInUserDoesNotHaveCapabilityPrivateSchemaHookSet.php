<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\UserRolesAccessControl\Hooks\AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveCapabilityPrivateSchemaHookSet;

class MaybeDisableFieldsIfLoggedInUserDoesNotHaveCapabilityPrivateSchemaHookSet extends AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveCapabilityPrivateSchemaHookSet
{
    use MaybeDisableFieldsIfConditionPrivateSchemaHookSetTrait;

    protected function getCapabilities(): array
    {
        if ($capability = Environment::capabilityLoggedInUserMustHaveToAccessRolesFields()) {
            return [$capability];
        }
        return [];
    }
}
