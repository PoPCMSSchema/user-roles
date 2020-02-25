<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\UserRoles\Hooks\AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveCapabilityHookSet;

class MaybeDisableFieldsIfLoggedInUserDoesNotHaveCapabilityHookSet extends AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveCapabilityHookSet
{
    use MaybeDisableFieldsIfLoggedInUserDoesNotHaveItemHookSetTrait;

    protected function getCapability(): ?string
    {
        return Environment::capabilityLoggedInUserMustHaveToAccessRolesFields();
    }
}
