<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Hiject\Bus\EventBuilder\ProjectFileEventBuilder;
use Hiject\Model\ProjectFileModel;
use Hiject\Model\ProjectModel;

require_once __DIR__.'/../Base.php';

class ProjectFileEventBuilderTest extends Base
{
    public function testWithMissingFile()
    {
        $projectFileEventBuilder = new ProjectFileEventBuilder($this->container);
        $projectFileEventBuilder->withFileId(42);
        $this->assertNull($projectFileEventBuilder->buildEvent());
    }

    public function testBuild()
    {
        $projectModel = new ProjectModel($this->container);
        $projectFileModel = new ProjectFileModel($this->container);
        $projectFileEventBuilder = new ProjectFileEventBuilder($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test1')));
        $this->assertEquals(1, $projectFileModel->create(1, 'Test', '/tmp/test', 123));

        $event = $projectFileEventBuilder->withFileId(1)->buildEvent();

        $this->assertInstanceOf('Hiject\Bus\Event\ProjectFileEvent', $event);
        $this->assertNotEmpty($event['file']);
        $this->assertNotEmpty($event['project']);
    }
}
