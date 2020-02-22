<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\UserState\Hooks\AbstractMaybeDisableDirectivesIfUserNotLoggedInHookSet;

abstract class AbstractMaybeDisableDirectivesIfLoggedInUserDoesNotHaveRoleHookSet extends AbstractMaybeDisableDirectivesIfUserNotLoggedInHookSet
{
    protected function disableDirectivesInPrivateSchemaMode(): bool
    {
        $roleName = $this->getRoleName();
        /**
         * Only if there is a required role to access the directive
         */
        if (!$roleName) {
            return false;
        }
        // If the user is not logged-in, then already disable
        if (parent::disableDirectivesInPrivateSchemaMode()) {
            return true;
        }

        // Check if the user does not have the required role
        return !UserRoleHelper::doesCurrentUserHaveRole($roleName);
    }

    /**
     * Get the role to validate
     *
     * @return string
     */
    abstract protected function getRoleName(): ?string;
}
