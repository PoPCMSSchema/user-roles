<?php
namespace PoP\UserRoles\Conditional\UserState\TypeResolverDecorators;

use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\API\TypeResolvers\RootTypeResolver;
use PoP\API\TypeResolvers\SiteTypeResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\UserRoles\Facades\UserRoleTypeDataResolverFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\TypeResolverDecorators\AbstractTypeResolverDecorator;
use PoP\UserRoles\Conditional\UserState\DirectiveResolvers\ValidateDoesLoggedInUserHaveRoleDirectiveResolver;

class RolesTypeResolverDecorator extends AbstractTypeResolverDecorator
{
    public const HOOK_ROLES_FIELD_REQUIRED_ROLE_NAME = __CLASS__.':roles_field:required_role_name';
    public static $rolesFieldRequiredRoleName = false;

    public static function getClassesToAttachTo(): array
    {
        return array(
            RootTypeResolver::class,
            SiteTypeResolver::class,
            UserTypeResolver::class,
        );
    }

    public static function getRolesFieldRequiredRoleName(): ?string
    {
        // Check if to initialize it
        if (self::$rolesFieldRequiredRoleName === false) {
            $hooksAPI = HooksAPIFacade::getInstance();
            $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
            $rolesFieldRequiredRoleName = $hooksAPI->applyFilters(
                self::HOOK_ROLES_FIELD_REQUIRED_ROLE_NAME,
                $userRoleTypeDataResolver->getAdminRoleName()
            );
            // If it was set to false, then set it as null, so the hook is not triggered again
            self::$rolesFieldRequiredRoleName = ($rolesFieldRequiredRoleName === false) ? null : $rolesFieldRequiredRoleName;
        }
        return self::$rolesFieldRequiredRoleName;
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
        if ($requiredRoleName = self::getRolesFieldRequiredRoleName()) {
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
}
