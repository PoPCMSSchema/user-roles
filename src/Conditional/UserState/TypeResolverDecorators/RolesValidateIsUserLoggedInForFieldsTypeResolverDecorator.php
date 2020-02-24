<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\API\TypeResolvers\RootTypeResolver;
use PoP\API\TypeResolvers\SiteTypeResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\UserState\TypeResolverDecorators\AbstractValidateIsUserLoggedInForFieldsTypeResolverDecorator;

class RolesValidateIsUserLoggedInForFieldsTypeResolverDecorator extends AbstractValidateIsUserLoggedInForFieldsTypeResolverDecorator
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            RootTypeResolver::class,
            SiteTypeResolver::class,
            UserTypeResolver::class,
        );
    }

    public function enabled(TypeResolverInterface $typeResolver): bool
    {
        return parent::enabled($typeResolver) && Environment::userMustBeLoggedInToAccessRolesFields();
    }

    protected function getFieldNames(): array
    {
        return [
            'roles',
            'capabilities',
        ];
    }
}
