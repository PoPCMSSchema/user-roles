<?php
namespace PoP\UserRoles\FieldResolvers;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\UserRoles\Facades\UserRoleTypeDataResolverFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;

trait RolesFieldResolverTrait
{
    public static function getFieldNamesToResolve(): array
    {
        return [
            'roles',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'roles' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'roles' => $translationAPI->__('All user roles', 'user-roles'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        switch ($fieldName) {
            case 'roles':
                return $userRoleTypeDataResolver->getRoleNames();
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
