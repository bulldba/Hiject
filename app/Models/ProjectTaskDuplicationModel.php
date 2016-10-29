<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Model;

use Hiject\Core\Base;

/**
 * Project Task Duplication Model
 */
class ProjectTaskDuplicationModel extends Base
{
    /**
     * Duplicate all tasks to another project
     *
     * @access public
     * @param  integer $src_project_id
     * @param  integer $dst_project_id
     * @return boolean
     */
    public function duplicate($src_project_id, $dst_project_id)
    {
        $task_ids = $this->taskFinderModel->getAllIds($src_project_id, array(TaskModel::STATUS_OPEN, TaskModel::STATUS_CLOSED));

        foreach ($task_ids as $task_id) {
            if (! $this->taskProjectDuplicationModel->duplicateToProject($task_id, $dst_project_id)) {
                return false;
            }
        }

        return true;
    }
}
