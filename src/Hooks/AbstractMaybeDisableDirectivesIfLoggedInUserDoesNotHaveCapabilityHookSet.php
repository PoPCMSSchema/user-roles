<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\UserState\Hooks\AbstractMaybeDisableDirectivesIfUserNotLoggedInPrivateSchemaHookSet;

abstract class AbstractMaybeDisableDirectivesIfLoggedInUserDoesNotHaveCapabilityHookSet extends AbstractMaybeDisableDirectivesIfUserNotLoggedInPrivateSchemaHookSet
{
    protected function enabled(): bool
    {
        // If the user is not logged-in, then already disable
        if (!parent::enabled()) {
            return false;
        }

        return !is_null($this->getCapability());
    }

    /**
     * Decide if to remove the directiveNames
     *
     * @param TypeResolverInterface $typeResolver
     * @param string $directiveName
     * @return boolean
     */
    protected function removeDirectiveNames(TypeResolverInterface $typeResolver, ?string $directiveName = null): bool
    {
        $capability = $this->getCapability();

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
