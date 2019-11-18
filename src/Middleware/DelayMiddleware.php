<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 18.11.2019
 * Time: 12:40
 */

namespace Imper86\MessengerMiddlewaresBundle\Middleware;

use Imper86\MessengerMiddlewaresBundle\Model\DelayedMessageInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

class DelayMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if (!$message instanceof DelayedMessageInterface) {
            return $stack->next()->handle($envelope, $stack);
        }

        if (null === $envelope->last(DelayStamp::class)) {
            $envelope = $envelope->with(new DelayStamp($message->getDelay()));
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
