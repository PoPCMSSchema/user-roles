<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet;

abstract class AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveCapabilityHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet
{
    protected function disableFieldsInPrivateSchemaMode(): bool
    {
        $capability = $this->getCapability();
        /**
         * Only if there is a required role to access the field
         */
        if (!$capability) {
            return false;
        }
        // If the user is not logged-in, then already disable
        if (parent::disableFieldsInPrivateSchemaMode()) {
            return true;
        }

        // Check if the user does not have the required role
        return !UserRoleHelper::doesCurrentUserHaveCapability($capability);
    }

    /**
     * Get the role to validate
     *
     * @return string
     */
    abstract protected function getCapability(): ?string;
}
