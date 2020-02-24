<?php
namespace PoP\UserRoles\Conditional\UserState;

use PoP\API\Environment as APIEnvironment;
use PoP\ComponentModel\Container\ContainerBuilderUtils;
use PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups;
use PoP\UserRoles\Conditional\UserState\Hooks\MaybeDisableFieldsIfUserNotLoggedInHookSet;
use PoP\UserRoles\Conditional\UserState\TypeResolverDecorators\RolesValidateIsUserLoggedInForFieldsTypeResolverDecorator;

/**
 * Initialize component
 */
class ComponentBoot
{
    /**
     * Boot component
     *
     * @return void
     */
    public static function boot()
    {
        // Initialize classes
        ContainerBuilderUtils::instantiateNamespaceServices(__NAMESPACE__.'\\Hooks');
        ContainerBuilderUtils::attachTypeResolverDecoratorsFromNamespace(__NAMESPACE__.'\\TypeResolverDecorators');
        ContainerBuilderUtils::attachDirectiveResolversFromNamespace(__NAMESPACE__.'\\DirectiveResolvers');
        self::validateFieldsAndDirectives();
    }

    /**
     * Attach directive resolvers based on environment variables
     *
     * @return void
     */
    protected static function validateFieldsAndDirectives()
    {
        if (Environment::userMustBeLoggedInToAccessRolesFields()) {
            if (APIEnvironment::usePrivateSchemaMode()) {
                ContainerBuilderUtils::instantiateService(MaybeDisableFieldsIfUserNotLoggedInHookSet::class);
            } else {
                RolesValidateIsUserLoggedInForFieldsTypeResolverDecorator::attach(AttachableExtensionGroups::TYPERESOLVERDECORATORS);
            }
        }
    }
}
