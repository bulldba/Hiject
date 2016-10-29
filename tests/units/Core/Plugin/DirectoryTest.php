<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Hiject\Core\Plugin\Directory;

require_once __DIR__.'/../../Base.php';

class DirectoryTest extends Base
{
    public function testIsCompatible()
    {
        $pluginDirectory = new Directory($this->container);
        $this->assertFalse($pluginDirectory->isCompatible(array('compatible_version' => '1.0.29'), '1.0.28'));
        $this->assertTrue($pluginDirectory->isCompatible(array('compatible_version' => '1.0.28'), '1.0.28'));
        $this->assertTrue($pluginDirectory->isCompatible(array('compatible_version' => '1.0.28'), 'master.1234'));
        $this->assertTrue($pluginDirectory->isCompatible(array('compatible_version' => '>=1.0.32'), 'master'));
        $this->assertTrue($pluginDirectory->isCompatible(array('compatible_version' => '>=1.0.32'), '1.0.32'));
        $this->assertTrue($pluginDirectory->isCompatible(array('compatible_version' => '>=1.0.32'), '1.0.33'));
        $this->assertTrue($pluginDirectory->isCompatible(array('compatible_version' => '>1.0.32'), '1.0.33'));
        $this->assertFalse($pluginDirectory->isCompatible(array('compatible_version' => '>1.0.32'), '1.0.32'));
    }
}
