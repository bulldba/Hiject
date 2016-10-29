<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Api\Procedure;

/**
 * Group API controller
 */
class GroupProcedure extends BaseProcedure
{
    public function createGroup($name, $external_id = '')
    {
        return $this->groupModel->create($name, $external_id);
    }

    public function updateGroup($group_id, $name = null, $external_id = null)
    {
        $values = array(
            'id' => $group_id,
            'name' => $name,
            'external_id' => $external_id,
        );

        foreach ($values as $key => $value) {
            if (is_null($value)) {
                unset($values[$key]);
            }
        }

        return $this->groupModel->update($values);
    }

    public function removeGroup($group_id)
    {
        return $this->groupModel->remove($group_id);
    }

    public function getGroup($group_id)
    {
        return $this->groupModel->getById($group_id);
    }

    public function getAllGroups()
    {
        return $this->groupModel->getAll();
    }
}
