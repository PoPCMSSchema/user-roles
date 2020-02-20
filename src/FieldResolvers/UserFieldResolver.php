<?php
namespace PoP\UserRoles\FieldResolvers;

use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Locations\TypeResolvers\LocationTypeResolver;
use PoP\UserRolesWP\TypeResolvers\UserRoleTypeResolver;
use PoP\UserRoles\Facades\UserRoleTypeDataResolverFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;

class UserFieldResolver extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            UserTypeResolver::class,
        );
    }

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
			'roles' => $translationAPI->__('User roles', 'user-roles'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $user = $resultItem;
        switch ($fieldName) {
            case 'roles':
                return $userRoleTypeDataResolver->getUserRoles($user);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
