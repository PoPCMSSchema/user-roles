<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\TypeResolverDecorators\AbstractTypeResolverDecorator;
use PoP\UserState\DirectiveResolvers\ValidateIsUserLoggedInDirectiveResolver;

class UserTypeResolverDecorator extends AbstractTypeResolverDecorator
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            UserTypeResolver::class,
        );
    }

    /**
     * Only the admin can see the roles of the users
     *
     * @param TypeResolverInterface $typeResolver
     * @return array
     */
    public function getMandatoryDirectivesForFields(TypeResolverInterface $typeResolver): array
    {
        $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
        return [
            'roles' => [
                $fieldQueryInterpreter->composeDirective(
                    ValidateIsUserLoggedInDirectiveResolver::getDirectiveName()
                )
            ]
        ];
    }
}
