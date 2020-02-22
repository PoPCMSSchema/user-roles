<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserRoles\FieldResolvers\SiteFieldResolver;
use PoP\UserRoles\FieldResolvers\UserFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;
use PoP\UserRoles\Conditional\UserState\TypeResolverDecorators\GlobalTypeResolverDecorator;
use PoP\UserState\Hooks\AbstractMaybeDisableUserStateFieldsIfUserNotLoggedInFieldResolverHooks;

class FieldResolverHooks extends AbstractMaybeDisableUserStateFieldsIfUserNotLoggedInFieldResolverHooks
{
    protected function disableUserStateFields(): bool
    {
        /**
         * Only if there is a required role to access the field
         */
        if (!GlobalTypeResolverDecorator::getRolesFieldRequiredRoleName()) {
            return false;
        }
        return parent::disableUserStateFields();
    }

    /**
     * Remove fieldName "roles" if the user is not logged in
     *
     * @param boolean $include
     * @param TypeResolverInterface $typeResolver
     * @param FieldResolverInterface $fieldResolver
     * @param string $fieldName
     * @return boolean
     */
    protected function removeFieldNames(TypeResolverInterface $typeResolver, FieldResolverInterface $fieldResolver, string $fieldName): bool
    {
        return
            ($fieldResolver instanceof SiteFieldResolver || $fieldResolver instanceof UserFieldResolver) &&
            ($fieldName == 'roles');
    }
}
