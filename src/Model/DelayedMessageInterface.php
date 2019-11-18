<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 18.11.2019
 * Time: 12:42
 */

namespace Imper86\MessengerMiddlewaresBundle\Model;

interface DelayedMessageInterface
{
    public function getDelay(): int;
}
