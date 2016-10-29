<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Bus\Job;

use Hiject\Bus\Event\TaskEvent;
use Hiject\Bus\EventBuilder\TaskEventBuilder;
use Hiject\Model\TaskModel;

/**
 * Class TaskEventJob
 */
class TaskEventJob extends BaseJob
{
    /**
     * Set job params
     *
     * @param  int    $taskId
     * @param  array  $eventNames
     * @param  array  $changes
     * @param  array  $values
     * @param  array  $task
     * @return $this
     */
    public function withParams($taskId, array $eventNames, array $changes = array(), array $values = array(), array $task = array())
    {
        $this->jobParams = array($taskId, $eventNames, $changes, $values, $task);
        return $this;
    }

    /**
     * Execute job
     *
     * @param  int    $taskId
     * @param  array  $eventNames
     * @param  array  $changes
     * @param  array  $values
     * @param  array  $task
     * @return $this
     */
    public function execute($taskId, array $eventNames, array $changes = array(), array $values = array(), array $task = array())
    {
        $event = TaskEventBuilder::getInstance($this->container)
            ->withTaskId($taskId)
            ->withChanges($changes)
            ->withValues($values)
            ->withTask($task)
            ->buildEvent();

        if ($event !== null) {
            foreach ($eventNames as $eventName) {
                $this->fireEvent($eventName, $event);
            }
        }
    }

    /**
     * Trigger event
     *
     * @access protected
     * @param  string    $eventName
     * @param  TaskEvent $event
     */
    protected function fireEvent($eventName, TaskEvent $event)
    {
        $this->logger->debug(__METHOD__.' Event fired: '.$eventName);
        $this->dispatcher->dispatch($eventName, $event);

        if ($eventName === TaskModel::EVENT_CREATE) {
            $this->userMentionModel->fireEvents($event['task']['description'], TaskModel::EVENT_USER_MENTION, $event);
        }
    }
}
