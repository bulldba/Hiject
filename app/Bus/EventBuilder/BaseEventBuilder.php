<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Bus\EventBuilder;

use Hiject\Core\Base;
use Hiject\Bus\Event\GenericEvent;

/**
 * Class BaseEventBuilder
 */
abstract class BaseEventBuilder extends Base
{
    /**
     * Build event data
     *
     * @access public
     * @return GenericEvent|null
     */
    abstract public function buildEvent();

    /**
     * Get event title with author
     *
     * @access public
     * @param  string $author
     * @param  string $eventName
     * @param  array  $eventData
     * @return string
     */
    abstract public function buildTitleWithAuthor($author, $eventName, array $eventData);

    /**
     * Get event title without author
     *
     * @access public
     * @param  string $eventName
     * @param  array  $eventData
     * @return string
     */
    abstract public function buildTitleWithoutAuthor($eventName, array $eventData);
}
