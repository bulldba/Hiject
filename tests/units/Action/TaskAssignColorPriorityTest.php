<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/../Base.php';

use Hiject\Bus\Event\TaskEvent;
use Hiject\Model\CategoryModel;
use Hiject\Model\TaskCreationModel;
use Hiject\Model\TaskFinderModel;
use Hiject\Model\ProjectModel;
use Hiject\Model\TaskModel;
use Hiject\Action\TaskAssignColorPriority;

class TaskAssignColorPriorityTest extends Base
{
    public function testChangeColor()
    {
        $categoryModel = new CategoryModel($this->container);
        $projectModel = new ProjectModel($this->container);
        $taskCreationModel = new TaskCreationModel($this->container);
        $taskFinderModel = new TaskFinderModel($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test1')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));
        $this->assertEquals(1, $categoryModel->create(array('name' => 'c1', 'project_id' => 1)));

        $event = new TaskEvent(array(
            'task_id' => 1,
            'task' => array(
                'project_id' => 1,
                'priority' => 1,
            )
        ));

        $action = new TaskAssignColorPriority($this->container);
        $action->setProjectId(1);
        $action->setParam('color_id', 'red');
        $action->setParam('priority', 1);

        $this->assertTrue($action->execute($event, TaskModel::EVENT_CREATE_UPDATE));

        $task = $taskFinderModel->getById(1);
        $this->assertNotEmpty($task);
        $this->assertEquals('red', $task['color_id']);
    }

    public function testWithWrongPriority()
    {
        $projectModel = new ProjectModel($this->container);
        $taskCreationModel = new TaskCreationModel($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test1')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $event = new TaskEvent(array(
            'task_id' => 1,
            'task' => array(
                'project_id' => 1,
                'priority' => 2,
            )
        ));

        $action = new TaskAssignColorPriority($this->container);
        $action->setProjectId(1);
        $action->setParam('color_id', 'red');
        $action->setParam('priority', 1);

        $this->assertFalse($action->execute($event, TaskModel::EVENT_CREATE_UPDATE));
    }
}
