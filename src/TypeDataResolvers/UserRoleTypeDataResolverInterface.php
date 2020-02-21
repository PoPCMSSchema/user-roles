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
    /**
     * User capabilities
     *
     * @param [type] $userObjectOrID
     * @return array
     */
    public function getUserCapabilities($userObjectOrID): array;
}
