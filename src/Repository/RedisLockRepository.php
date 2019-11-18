<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 18.11.2019
 * Time: 11:26
 */

namespace Imper86\MessengerMiddlewaresBundle\Repository;

use Imper86\MessengerMiddlewaresBundle\Model\UniqueMessageInterface;
use Redis;

class RedisLockRepository implements LockRepositoryInterface
{
    private const SET_KEY = 'i86.unique_message_locks';
    /**
     * @var Redis
     */
    private $redis;

    public function __construct(?Redis $redis = null)
    {
        if (!$redis) {
            $redis = new Redis();
            $redis->connect('localhost');
        }

        $this->redis = $redis;
    }

    public function exists(UniqueMessageInterface $message): bool
    {
        return $this->redis->sIsMember(self::SET_KEY, $this->generateId($message));
    }

    public function add(UniqueMessageInterface $message): void
    {
        $this->redis->sAdd(self::SET_KEY, $this->generateId($message));
    }

    public function remove(UniqueMessageInterface $message): void
    {
        $this->redis->sRem(self::SET_KEY, $this->generateId($message));
    }

    private function generateId(UniqueMessageInterface $message): string
    {
        return get_class($message) . ' ' . $message->getUniqueId();
    }
}
