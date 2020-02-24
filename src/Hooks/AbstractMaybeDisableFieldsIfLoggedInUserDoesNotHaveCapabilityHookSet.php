<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet;

abstract class AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveCapabilityHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet
{
    protected function enabled(): bool
    {
        return $this->getCapability() != null;
    }

    protected function disableFieldsInPrivateSchemaMode(): bool
    {
        // If the user is not logged-in, then already disable
        // Check if the user does not have the required role
        return parent::disableFieldsInPrivateSchemaMode() || !UserRoleHelper::doesCurrentUserHaveCapability($this->getCapability());
    }

    /**
     * Get the role to validate
     *
     * @return string
     */
    abstract protected function getCapability(): ?string;
}
