<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\UserRoles\Facades\UserRoleTypeDataResolverFacade;
use PoP\ComponentModel\TypeResolvers\AbstractTypeResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\TypeResolverDecorators\AbstractTypeResolverDecorator;
use PoP\UserState\DirectiveResolvers\ValidateIsUserLoggedInDirectiveResolver;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveRoleDirectiveResolver;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveCapabilityDirectiveResolver;

class GlobalTypeResolverDecorator extends AbstractTypeResolverDecorator
{
    public const HOOK_ROLES_FIELD_REQUIRED_ROLE_NAME = __CLASS__.':roles_field:required_role_name';

    public static function getClassesToAttachTo(): array
    {
        return array(
            AbstractTypeResolver::class,
        );
    }

    /**
     * By default, only the admin can see the roles from the users
     *
     * @param TypeResolverInterface $typeResolver
     * @return array
     */
    public function getMandatoryDirectivesForFields(TypeResolverInterface $typeResolver): array
    {
        $mandatoryDirectivesForFields = [];
        $hooksAPI = HooksAPIFacade::getInstance();
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        if ($requiredRoleName = $hooksAPI->applyFilters(
            self::HOOK_ROLES_FIELD_REQUIRED_ROLE_NAME,
            $userRoleTypeDataResolver->getAdminRoleName()
        )) {
            $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
            $mandatoryDirectivesForFields['roles'] = [
                $fieldQueryInterpreter->getDirective(
                    ValidateDoesLoggedInUserHaveRoleDirectiveResolver::getDirectiveName(),
                    [
                        'role' => $requiredRoleName,
                    ]
                )
            ];
        }
        return $mandatoryDirectivesForFields;
    }

    /**
     * Verify that the user is logged in before checking the roles/capabilities
     *
     * @param TypeResolverInterface $typeResolver
     * @return array
     */
    public function getMandatoryDirectivesForDirectives(TypeResolverInterface $typeResolver): array
    {
        $mandatoryDirectivesForDirectives = [];
        $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
        // This is the required "validateIsUserLoggedIn" directive
        $validateIsUserLoggedInDirective = $fieldQueryInterpreter->getDirective(
            ValidateIsUserLoggedInDirectiveResolver::getDirectiveName()
        );
        // These are all the directives that need the "validateIsUserLoggedIn" directive
        $needValidateIsUserLoggedInDirectives = [
            ValidateDoesLoggedInUserHaveRoleDirectiveResolver::class,
            ValidateDoesLoggedInUserHaveCapabilityDirectiveResolver::class,
        ];
        // Add the mapping
        foreach ($needValidateIsUserLoggedInDirectives as $needValidateIsUserLoggedInDirective) {
            $mandatoryDirectivesForDirectives[$needValidateIsUserLoggedInDirective::getDirectiveName()] = [
                $validateIsUserLoggedInDirective,
            ];
        }
        return $mandatoryDirectivesForDirectives;
    }
}
