<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet;

abstract class AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInHookSet
{
    protected function enabled(): bool
    {
        return $this->getRoleName() != null;
    }

    protected function disableFieldsInPrivateSchemaMode(): bool
    {
        // If the user is not logged-in, then already disable
        // Check if the user does not have the required role
        return parent::disableFieldsInPrivateSchemaMode() || !UserRoleHelper::doesCurrentUserHaveRole($this->getRoleName());
    }

    /**
     * Get the role to validate
     *
     * @return string
     */
    abstract protected function getRoleName(): ?string;
}
