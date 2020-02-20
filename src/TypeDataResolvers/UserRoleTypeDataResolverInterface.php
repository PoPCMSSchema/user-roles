<?php
namespace PoP\UserRoles\TypeDataResolvers;

interface UserRoleTypeDataResolverInterface {
    /**
     * Role names
     *
     * @return array
     */
    public function getRoleNames(): array;
    /**
     * User roles
     *
     * @param [type] $userObjectOrID
     * @return array
     */
    public function getUserRoles($userObjectOrID): array;
}
