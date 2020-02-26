<?php
namespace PoP\UserRoles\Conditional\UserState\DirectiveResolvers;

use PoP\ComponentModel\Engine_Vars;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\UserRoles\Facades\UserRoleTypeDataResolverFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\DirectiveResolvers\AbstractValidateConditionDirectiveResolver;

class ValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver extends AbstractValidateConditionDirectiveResolver
{
    const DIRECTIVE_NAME = 'validateDoesLoggedInUserHaveAnyRole';
    public static function getDirectiveName(): string {
        return self::DIRECTIVE_NAME;
    }

    protected function validateCondition(TypeResolverInterface $typeResolver): bool
    {
        $vars = Engine_Vars::getVars();
        // If the user is not logged-in, then do nothing: directive `@validateIsUserLoggedIn` will already fail
        if (!$vars['global-userstate']['is-user-logged-in']) {
            return true;
        }

        $roles = $this->directiveArgsForSchema['roles'];
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $userID = $vars['global-userstate']['current-user-id'];
        $userRoles = $userRoleTypeDataResolver->getUserRoles($userID);
        return !empty(array_intersect($roles, $userRoles));
    }

    protected function getValidationFailedMessage(TypeResolverInterface $typeResolver, array $failedDataFields): string
    {
        $roles = $this->directiveArgsForSchema['roles'];
        $translationAPI = TranslationAPIFacade::getInstance();
        $message = count($roles) == 1 ?
            $translationAPI->__('You must have role \'%s\' to access field(s) \'%s\'', 'user-roles') :
            $translationAPI->__('You must have any role from among \'%s\' to access field(s) \'%s\'', 'user-roles');
        return sprintf(
            $message,
            implode(
                $translationAPI->__('\', \''),
                $roles
            ),
            implode(
                $translationAPI->__('\', \''),
                $failedDataFields
            )
        );
    }

    public function getSchemaDirectiveDescription(TypeResolverInterface $typeResolver): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return $translationAPI->__('It validates if the user has any of the roles provided through directive argument \'roles\'', 'component-model');
    }
    public function getSchemaDirectiveArgs(TypeResolverInterface $typeResolver): array
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return [
            [
                SchemaDefinition::ARGNAME_NAME => 'roles',
                SchemaDefinition::ARGNAME_TYPE => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_STRING),
                SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('Roles to validate if the logged-in user has (any of them)', 'component-model'),
                SchemaDefinition::ARGNAME_MANDATORY => true,
            ],
        ];
    }
}
