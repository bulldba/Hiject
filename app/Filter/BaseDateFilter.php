<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Filter;

use Hiject\Core\DateParser;

/**
 * Base date filter class
 */
abstract class BaseDateFilter extends BaseFilter
{
    /**
     * DateParser object
     *
     * @access protected
     * @var DateParser
     */
    protected $dateParser;

    /**
     * Set DateParser object
     *
     * @access public
     * @param  DateParser $dateParser
     * @return $this
     */
    public function setDateParser(DateParser $dateParser)
    {
        $this->dateParser = $dateParser;
        return $this;
    }

    /**
     * Parse operator in the input string
     *
     * @access protected
     * @return string
     */
    protected function parseOperator()
    {
        $operators = array(
            '<=' => 'lte',
            '>=' => 'gte',
            '<' => 'lt',
            '>' => 'gt',
        );

        foreach ($operators as $operator => $method) {
            if (strpos($this->value, $operator) === 0) {
                $this->value = substr($this->value, strlen($operator));
                return $method;
            }
        }

        return '';
    }

    /**
     * Apply a date filter
     *
     * @access protected
     * @param  string $field
     */
    protected function applyDateFilter($field)
    {
        $method = $this->parseOperator();
        $timestamp = $this->dateParser->getTimestampFromIsoFormat($this->value);

        if ($method !== '') {
            $this->query->$method($field, $this->getTimestampFromOperator($method, $timestamp));
        } else {
            $this->query->gte($field, $timestamp);
            $this->query->lte($field, $timestamp + 86399);
        }
    }

    /**
     * Get timestamp from the operator
     *
     * @access public
     * @param  string  $method
     * @param  integer $timestamp
     * @return integer
     */
    protected function getTimestampFromOperator($method, $timestamp)
    {
        switch ($method) {
            case 'lte':
                return $timestamp + 86399;
            case 'lt':
                return $timestamp;
            case 'gte':
                return $timestamp;
            case 'gt':
                return $timestamp + 86400;
        }

        return $timestamp;
    }
}
