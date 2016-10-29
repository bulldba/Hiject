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

use Hiject\Api\Authorization\CategoryAuthorization;
use Hiject\Api\Authorization\ProjectAuthorization;

/**
 * Category API controller
 */
class CategoryProcedure extends BaseProcedure
{
    public function getCategory($category_id)
    {
        CategoryAuthorization::getInstance($this->container)->check($this->getClassName(), 'getCategory', $category_id);
        return $this->categoryModel->getById($category_id);
    }

    public function getAllCategories($project_id)
    {
        ProjectAuthorization::getInstance($this->container)->check($this->getClassName(), 'getAllCategories', $project_id);
        return $this->categoryModel->getAll($project_id);
    }

    public function removeCategory($category_id)
    {
        CategoryAuthorization::getInstance($this->container)->check($this->getClassName(), 'removeCategory', $category_id);
        return $this->categoryModel->remove($category_id);
    }

    public function createCategory($project_id, $name)
    {
        ProjectAuthorization::getInstance($this->container)->check($this->getClassName(), 'createCategory', $project_id);

        $values = array(
            'project_id' => $project_id,
            'name' => $name,
        );

        list($valid, ) = $this->categoryValidator->validateCreation($values);
        return $valid ? $this->categoryModel->create($values) : false;
    }

    public function updateCategory($id, $name)
    {
        CategoryAuthorization::getInstance($this->container)->check($this->getClassName(), 'updateCategory', $id);

        $values = array(
            'id' => $id,
            'name' => $name,
        );

        list($valid, ) = $this->categoryValidator->validateModification($values);
        return $valid && $this->categoryModel->update($values);
    }
}
