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

use Hiject\Api\Authorization\CommentAuthorization;
use Hiject\Api\Authorization\TaskAuthorization;

/**
 * Comment API controller
 */
class CommentProcedure extends BaseProcedure
{
    public function getComment($comment_id)
    {
        CommentAuthorization::getInstance($this->container)->check($this->getClassName(), 'getComment', $comment_id);
        return $this->commentModel->getById($comment_id);
    }

    public function getAllComments($task_id)
    {
        TaskAuthorization::getInstance($this->container)->check($this->getClassName(), 'getAllComments', $task_id);
        return $this->commentModel->getAll($task_id);
    }

    public function removeComment($comment_id)
    {
        CommentAuthorization::getInstance($this->container)->check($this->getClassName(), 'removeComment', $comment_id);
        return $this->commentModel->remove($comment_id);
    }

    public function createComment($task_id, $user_id, $content, $reference = '')
    {
        TaskAuthorization::getInstance($this->container)->check($this->getClassName(), 'createComment', $task_id);
        
        $values = array(
            'task_id' => $task_id,
            'user_id' => $user_id,
            'comment' => $content,
            'reference' => $reference,
        );

        list($valid, ) = $this->commentValidator->validateCreation($values);

        return $valid ? $this->commentModel->create($values) : false;
    }

    public function updateComment($id, $content)
    {
        CommentAuthorization::getInstance($this->container)->check($this->getClassName(), 'updateComment', $id);
        
        $values = array(
            'id' => $id,
            'comment' => $content,
        );

        list($valid, ) = $this->commentValidator->validateModification($values);
        return $valid && $this->commentModel->update($values);
    }
}
