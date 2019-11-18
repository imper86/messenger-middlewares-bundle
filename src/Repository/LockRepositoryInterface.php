<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 18.11.2019
 * Time: 11:20
 */

namespace Imper86\MessengerMiddlewaresBundle\Repository;

use Imper86\MessengerMiddlewaresBundle\Model\UniqueMessageInterface;

/**
 * Interface LockRepositoryInterface
 * @package Imper86\MessengerMiddlewaresBundle\Repository
 */
interface LockRepositoryInterface
{
    /**
     * @param UniqueMessageInterface $message
     * @return bool
     */
    public function exists(UniqueMessageInterface $message): bool;

    /**
     * @param UniqueMessageInterface $message
     */
    public function add(UniqueMessageInterface $message): void;

    /**
     * @param UniqueMessageInterface $message
     */
    public function remove(UniqueMessageInterface $message): void;
}
