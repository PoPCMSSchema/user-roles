<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\UserState\Hooks\AbstractMaybeDisableDirectivesIfUserNotLoggedInHookSet;

abstract class AbstractMaybeDisableDirectivesIfLoggedInUserDoesNotHaveCapabilityHookSet extends AbstractMaybeDisableDirectivesIfUserNotLoggedInHookSet
{
    protected function disableDirectivesInPrivateSchemaMode(): bool
    {
        $capability = $this->getCapability();
        /**
         * Only if there is a required role to access the directive
         */
        if (!$capability) {
            return false;
        }
        // If the user is not logged-in, then already disable
        if (parent::disableDirectivesInPrivateSchemaMode()) {
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
