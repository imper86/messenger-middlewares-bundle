<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 18.11.2019
 * Time: 12:18
 */

namespace Imper86\MessengerMiddlewaresBundle\Middleware;

use Imper86\MessengerMiddlewaresBundle\Model\UniqueMessageInterface;
use Imper86\MessengerMiddlewaresBundle\Repository\LockRepositoryInterface;
use Imper86\MessengerMiddlewaresBundle\Stamp\UniqueStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class UniqueMiddleware implements MiddlewareInterface
{
    /**
     * @var LockRepositoryInterface
     */
    private $lockRepository;

    public function __construct(LockRepositoryInterface $lockRepository)
    {
        $this->lockRepository = $lockRepository;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if (!$message instanceof UniqueMessageInterface) {
            return $stack->next()->handle($envelope, $stack);
        }

        if (null !== $envelope->last(UniqueStamp::class)) {
            return $stack->next()->handle($envelope, $stack);
        }

        if ($this->lockRepository->exists($message)) {
            return $envelope;
        }

        $this->lockRepository->add($message);

        return $stack->next()->handle($envelope->with(new UniqueStamp()), $stack);
    }
}
