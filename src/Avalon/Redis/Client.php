<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 7/28/15
 * Time: 11:07 AM
 */

namespace Avalon\Redis;

use Avalon\Entities\User;
use Predis\Client as Redis;

/**
 * Class Client
 * @package Avalon\Redis
 */
class Client
{
    /**
     * @var Redis
     */
    private $redis;

    /**
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param $username
     * @return User
     * @throws \Exception
     */
    public function fetchUserByUsername($username)
    {
        $data = $this->redis->get("users:$username");
        if(! $data) {
            throw new \Exception("User [$username] not found");
        }

        return User::make(json_decode($data, true));
    }

    /**
     * @param array $user
     * @return mixed
     */
    public function upsertUser(array $user)
    {
        $data = json_encode($user);
        return $this->redis->set("users:{$user['username']}", $data);
    }

    /**
     * @param $position
     * @return array|mixed
     */
    public function range($position)
    {
        $data = $this->redis->lrange('mapped', $position, $position);
        if(! $data) {
            return [];
        }

        $data = array_pop($data);
        return json_decode($data, true);
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function getTagById($id)
    {
        $data = $this->redis->get("tags:$id");
        if(! $data) {
            return [];
        }

        return json_decode($data, true);
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function getDatapointById($id)
    {
        $data = $this->redis->get("datapoints:$id");
        if(! $data) {
            return [];
        }

        return json_decode($data, true);
    }
}