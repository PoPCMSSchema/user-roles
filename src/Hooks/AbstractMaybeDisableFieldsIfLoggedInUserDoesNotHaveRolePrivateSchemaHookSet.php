<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;
use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInPrivateSchemaHookSet;

abstract class AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRolePrivateSchemaHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInPrivateSchemaHookSet
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
     * Decide if to remove the fieldNames
     *
     * @param TypeResolverInterface $typeResolver
     * @param FieldResolverInterface $fieldResolver
     * @param string $fieldName
     * @return boolean
     */
    protected function removeFieldName(TypeResolverInterface $typeResolver, FieldResolverInterface $fieldResolver, string $fieldName): bool
    {
        $isUserLoggedIn = $this->isUserLoggedIn();

        $roleNames = $this->getRoleNames();

        // Check if the user does not have any of the required roles
        return !$isUserLoggedIn || !UserRoleHelper::doesCurrentUserHaveAnyRole($roleNames);
    }

    /**
     * Get the role to validate
     *
     * @return string
     */
    abstract protected function getRoleNames(): array;
}
