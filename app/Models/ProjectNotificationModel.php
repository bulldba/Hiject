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
 * Project Notification
 */
class ProjectNotificationModel extends Base
{
    /**
     * Send notifications
     *
     * @access public
     * @param  integer  $project_id
     * @param  string   $event_name
     * @param  array    $event_data
     */
    public function sendNotifications($project_id, $event_name, array $event_data)
    {
        $project = $this->projectModel->getById($project_id);

        $types = array_merge(
            $this->projectNotificationTypeModel->getHiddenTypes(),
            $this->projectNotificationTypeModel->getSelectedTypes($project_id)
        );

        foreach ($types as $type) {
            $this->projectNotificationTypeModel->getType($type)->notifyProject($project, $event_name, $event_data);
        }
    }

    /**
     * Save settings for the given project
     *
     * @access public
     * @param  integer   $project_id
     * @param  array     $values
     */
    public function saveSettings($project_id, array $values)
    {
        $this->db->startTransaction();

        $types = empty($values['notification_types']) ? array() : array_keys($values['notification_types']);
        $this->projectNotificationTypeModel->saveSelectedTypes($project_id, $types);

        $this->db->closeTransaction();
    }

    /**
     * Read user settings to display the form
     *
     * @access public
     * @param  integer   $project_id
     * @return array
     */
    public function readSettings($project_id)
    {
        return array(
            'notification_types' => $this->projectNotificationTypeModel->getSelectedTypes($project_id),
        );
    }
}
