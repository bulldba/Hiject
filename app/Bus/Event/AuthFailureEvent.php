<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Bus\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

/**
 * Authentication failure event
 */
class AuthFailureEvent extends BaseEvent
{
    /**
     * Username
     *
     * @access private
     * @var string
     */
    private $username = '';

    /**
     * Constructor
     *
     * @access public
     * @param  string $username
     */
    public function __construct($username = '')
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @access public
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
