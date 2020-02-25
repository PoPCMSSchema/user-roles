<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\UserState\Hooks\AbstractMaybeDisableDirectivesIfUserNotLoggedInPrivateSchemaHookSet;

abstract class AbstractMaybeDisableDirectivesIfLoggedInUserDoesNotHaveRolePrivateSchemaHookSet extends AbstractMaybeDisableDirectivesIfUserNotLoggedInPrivateSchemaHookSet
{
    protected function enabled(): bool
    {
        // If the user is not logged-in, then already disable
        if (!parent::enabled()) {
            return false;
        }

        return !is_null($this->getRoleName());
    }

    /**
     * Decide if to remove the directiveNames
     *
     * @param TypeResolverInterface $typeResolver
     * @param string $directiveName
     * @return boolean
     */
    protected function removeDirectiveName(TypeResolverInterface $typeResolver, string $directiveName): bool
    {
        $roleName = $this->getRoleName();

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
