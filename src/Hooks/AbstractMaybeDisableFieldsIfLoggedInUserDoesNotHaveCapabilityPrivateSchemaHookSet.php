<?php
namespace PoP\UserRoles\Hooks;

use PoP\UserRoles\Helpers\UserRoleHelper;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;
use PoP\UserState\Hooks\AbstractMaybeDisableFieldsIfUserNotLoggedInPrivateSchemaHookSet;

abstract class AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveCapabilityPrivateSchemaHookSet extends AbstractMaybeDisableFieldsIfUserNotLoggedInPrivateSchemaHookSet
{
    protected function enabled(): bool
    {
        // If the user is not logged-in, then do not enable
        if (!parent::enabled()) {
            return false;
        }

        return !is_null($this->getCapability());
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

        $capability = $this->getCapability();

        // Check if the user does not have the required capability
        return !$isUserLoggedIn || !UserRoleHelper::doesCurrentUserHaveCapability($capability);
    }

    /**
     * Get the role to validate
     *
     * @return string
     */
    abstract protected function getCapability(): ?string;
}
