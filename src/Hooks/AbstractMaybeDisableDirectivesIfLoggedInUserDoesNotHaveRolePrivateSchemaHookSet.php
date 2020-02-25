<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoP\UserState\Hooks\AbstractMaybeDisableDirectivesIfUserNotLoggedInPrivateSchemaHookSet;

abstract class AbstractMaybeDisableDirectivesIfLoggedInUserDoesNotHaveRolePrivateSchemaHookSet extends AbstractMaybeDisableDirectivesIfUserNotLoggedInPrivateSchemaHookSet
{
    protected function enabled(): bool
    {
        // If the user is not logged-in, then already disable
        if (!parent::enabled()) {
            return false;
        }

        return !empty($this->getRoleNames());
    }

    /**
     * Decide if to remove the directiveNames
     *
     * @param TypeResolverInterface $typeResolver
     * @param string $directiveName
     * @return boolean
     */
    protected function removeDirectiveName(TypeResolverInterface $typeResolver, DirectiveResolverInterface $directiveResolver, string $directiveName): bool
    {
        $roleNames = $this->getRoleNames();

        // Check if the user does not have any of the required roles
        return !UserRoleHelper::doesCurrentUserHaveAnyRole($roleNames);
    }

    /**
     * Get the role to validate
     *
     * @return string
     */
    abstract protected function getRoleNames(): array;
}
