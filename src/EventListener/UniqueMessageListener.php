<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 18.11.2019
 * Time: 12:23
 */

namespace Imper86\MessengerMiddlewaresBundle\EventListener;

use Imper86\MessengerMiddlewaresBundle\Model\UniqueMessageInterface;
use Imper86\MessengerMiddlewaresBundle\Repository\LockRepositoryInterface;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;

class UniqueMessageListener
{
    /**
     * @var LockRepositoryInterface
     */
    private $lockRepository;

    public function __construct(LockRepositoryInterface $lockRepository)
    {
        $this->lockRepository = $lockRepository;
    }

    public function onMessageHandle(WorkerMessageHandledEvent $event)
    {
        $message = $event->getEnvelope()->getMessage();

        if ($message instanceof UniqueMessageInterface) {
            $this->lockRepository->remove($message);
        }
    }
}
