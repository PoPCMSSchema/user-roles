<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\UserRoles\Conditional\UserState\Environment;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\UserState\TypeResolverDecorators\AbstractValidateIsUserLoggedInForFieldsTypeResolverDecorator;

class RolesValidateIsUserLoggedInForFieldsTypeResolverDecorator extends AbstractValidateIsUserLoggedInForFieldsTypeResolverDecorator
{
    use RolesValidateConditionForFieldsTypeResolverDecoratorTrait;

    public function enabled(TypeResolverInterface $typeResolver): bool
    {
        return parent::enabled($typeResolver) && Environment::userMustBeLoggedInToAccessRolesFields();
    }
}
