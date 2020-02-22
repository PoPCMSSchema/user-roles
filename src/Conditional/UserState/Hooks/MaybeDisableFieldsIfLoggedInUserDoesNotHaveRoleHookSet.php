<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\UserRoles\FieldResolvers\UserFieldResolver;
use PoP\UserRoles\FieldResolvers\RootRolesFieldResolver;
use PoP\UserRoles\FieldResolvers\SiteRolesFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;
use PoP\UserRoles\Conditional\UserState\TypeResolverDecorators\GlobalTypeResolverDecorator;
use PoP\UserRoles\Hooks\AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet;

class MaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet extends AbstractMaybeDisableFieldsIfLoggedInUserDoesNotHaveRoleHookSet
{
    protected function getRoleName(): ?string
    {
        return GlobalTypeResolverDecorator::getRolesFieldRequiredRoleName();
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
            (
                $fieldResolver instanceof RootRolesFieldResolver ||
                $fieldResolver instanceof SiteRolesFieldResolver ||
                $fieldResolver instanceof UserFieldResolver
            ) &&
            ($fieldName == 'roles');
    }
}
