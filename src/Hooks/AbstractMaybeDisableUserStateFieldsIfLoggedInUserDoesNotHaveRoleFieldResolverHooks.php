<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Facades\UserRoleTypeDataResolverFacade;
use PoP\UserState\Facades\UserStateTypeDataResolverFacade;
use PoP\UserState\Hooks\AbstractMaybeDisableUserStateFieldsIfUserNotLoggedInFieldResolverHooks;

abstract class AbstractMaybeDisableUserStateFieldsIfLoggedInUserDoesNotHaveRoleFieldResolverHooks extends AbstractMaybeDisableUserStateFieldsIfUserNotLoggedInFieldResolverHooks
{
    protected function disableFieldsInPrivateSchemaMode(): bool
    {
        $roleName = $this->getRoleName();
        /**
         * Only if there is a required role to access the field
         */
        if (!$roleName) {
            return false;
        }
        // If the user is not logged-in, then already disable
        if (parent::disableFieldsInPrivateSchemaMode()) {
            return true;
        }

        // Check if the user has the required role
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $userStateTypeDataResolverFacade = UserStateTypeDataResolverFacade::getInstance();
        $userID = $userStateTypeDataResolverFacade->getCurrentUserID();
        $userRoles = $userRoleTypeDataResolver->getUserRoles($userID);
        return !in_array($roleName, $userRoles);
    }

    /**
     * Get the role to validate
     *
     * @return string
     */
    abstract protected function getRoleName(): ?string;
}
