<?php
namespace PoP\UserRoles\Conditional\UserState\DirectiveResolvers;

use PoP\ComponentModel\Engine_Vars;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\UserRoles\Facades\UserRoleTypeDataResolverFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\DirectiveResolvers\AbstractValidateConditionDirectiveResolver;

class ValidateDoesLoggedInUserHaveCapabilityDirectiveResolver extends AbstractValidateConditionDirectiveResolver
{
    const DIRECTIVE_NAME = 'validateDoesLoggedInUserHaveCapability';
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

        $capabilities = $this->directiveArgsForSchema['capabilities'];
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $userID = $vars['global-userstate']['current-user-id'];
        $userCapabilities = $userRoleTypeDataResolver->getUserCapabilities($userID);
        return !empty(array_intersect($capabilities, $userCapabilities));
    }

    protected function getValidationFailedMessage(TypeResolverInterface $typeResolver, array $failedDataFields): string
    {
        $capabilities = $this->directiveArgsForSchema['capabilities'];
        $translationAPI = TranslationAPIFacade::getInstance();
        return sprintf(
            $translationAPI->__('You must have any capability from among \'%s\' to access field(s) \'%s\'', 'user-state'),
            implode(
                $translationAPI->__('\', \''),
                $capabilities
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
        return $translationAPI->__('It validates if the user has any capability provided through directive argument \'capabilities\'', 'component-model');
    }
    public function getSchemaDirectiveArgs(TypeResolverInterface $typeResolver): array
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return [
            [
                SchemaDefinition::ARGNAME_NAME => 'capabilities',
                SchemaDefinition::ARGNAME_TYPE => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_STRING),
                SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('Capabilities to validate if the logged-in user has (any of them)', 'component-model'),
                SchemaDefinition::ARGNAME_MANDATORY => true,
            ],
        ];
    }
}
