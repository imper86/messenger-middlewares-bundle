<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 18.11.2019
 * Time: 11:22
 */

namespace Imper86\MessengerMiddlewaresBundle\Model;
/**
 * Interface UniqueMessageInterface
 * @package Imper86\MessengerMiddlewaresBundle\Model
 */
interface UniqueMessageInterface
{
    /**
     * @return string
     */
    public function getUniqueId(): string;
}
