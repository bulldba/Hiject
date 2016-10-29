<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Core\Controller;

use Exception;

/**
 * Class AccessForbiddenException
 */
class BaseException extends Exception
{
    protected $withoutLayout = false;

    /**
     * Get object instance
     *
     * @static
     * @access public
     * @param  string $message
     * @return static
     */
    public static function getInstance($message = '')
    {
        return new static($message);
    }

    /**
     * There is no layout
     *
     * @access public
     * @return BaseException
     */
    public function withoutLayout()
    {
        $this->withoutLayout = true;
        return $this;
    }

    /**
     * Return true if no layout
     *
     * @access public
     * @return boolean
     */
    public function hasLayout()
    {
        return $this->withoutLayout;
    }
}
