<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 01.12.16
 * Time: 13:04
 */

namespace Ainias\CalDav\NoDb\Essentials;


use Zend\Authentication\Adapter\Http\ResolverInterface;

class DummyBasicResolver implements ResolverInterface
{
    /**
     * Resolve username/realm to password/hash/etc.
     *
     * @param  string $username Username
     * @param  string $realm    Authentication Realm
     * @param  string $password Password (optional)
     * @return string|array|false User's shared secret as string if found in realm, or User's identity as array
     *         if resolved, false otherwise.
     */
    public function resolve($username, $realm, $password = null)
    {
        return $password;
    }
}