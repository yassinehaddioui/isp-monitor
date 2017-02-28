<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/26/17
 * Time: 7:06 PM
 */

namespace IspMonitor\Repositories;


use IspMonitor\Models\Role;
use IspMonitor\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * @param $entities
     * @return User[]
     */
    protected function normalize($entities)
    {
        $result = [];
        foreach ($entities as $entity) {
            $roles = [];
            foreach($entity['roles'] as $singleRole){
                $roles[] = new Role($singleRole['name'], $singleRole['domain']);
            }
            $result[] = new User(
                $entity['_id'],
                $entity['email'],
                $entity['name'],
                $entity['password'],
                $roles,
                $entity['status'],
                $entity['dateCreated'],
                $entity['lastUpdate']
            );
        }
        return $result;
    }
}