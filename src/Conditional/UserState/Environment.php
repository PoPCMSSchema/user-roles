<?php
namespace PoP\UserRoles\Conditional\UserState;

class Environment
{
    public static function userMustBeLoggedInToAccessRolesFields(): bool
    {
        return isset($_ENV['USER_MUST_BE_LOGGED_IN_TO_ACCESS_ROLES_FIELDS']) ? strtolower($_ENV['USER_MUST_BE_LOGGED_IN_TO_ACCESS_ROLES_FIELDS']) == "true" : false;
    }

    public static function roleLoggedInUserMustHaveToAccessRolesFields(): ?string
    {
        return isset($_ENV['ROLE_LOGGED_IN_USER_MUST_HAVE_TO_ACCESS_ROLES_FIELDS']) && $_ENV['ROLE_LOGGED_IN_USER_MUST_HAVE_TO_ACCESS_ROLES_FIELDS'] ? strtolower($_ENV['ROLE_LOGGED_IN_USER_MUST_HAVE_TO_ACCESS_ROLES_FIELDS']) : null;
    }
}

