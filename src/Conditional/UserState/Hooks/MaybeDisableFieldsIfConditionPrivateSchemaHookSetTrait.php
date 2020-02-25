<?php
namespace PoP\UserRoles\Conditional\UserState\Hooks;

use PoP\API\TypeResolvers\RootTypeResolver;
use PoP\API\TypeResolvers\SiteTypeResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;

trait MaybeDisableFieldsIfConditionPrivateSchemaHookSetTrait
{
    /**
     * Field names to remove
     *
     * @return array
     */
    protected function getFieldNames(): array
    {
        return [
            'roles',
            'capabilities',
        ];
    }

    /**
     * Remove fields for the User type
     *
     * @param boolean $include
     * @param TypeResolverInterface $typeResolver
     * @param FieldResolverInterface $fieldResolver
     * @param string $fieldName
     * @return boolean
     */
    protected function removeFieldName(TypeResolverInterface $typeResolver, FieldResolverInterface $fieldResolver, string $fieldName): bool
    {
        return
            $typeResolver instanceof UserTypeResolver ||
            ($fieldName == 'roles' &&
                (
                    $typeResolver instanceof RootTypeResolver ||
                    $typeResolver instanceof SiteTypeResolver
                )
            );
    }
}
