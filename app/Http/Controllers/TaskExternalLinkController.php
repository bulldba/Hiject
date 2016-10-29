<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Controller;

use Hiject\Core\Controller\PageNotFoundException;
use Hiject\Core\ExternalLink\ExternalLinkProviderNotFound;

/**
 * Task External Link Controller
 */
class TaskExternalLinkController extends BaseController
{
    /**
     * First creation form
     *
     * @access public
     * @param array $values
     * @param array $errors
     * @throws PageNotFoundException
     * @throws \Hiject\Core\Controller\AccessForbiddenException
     */
    public function find(array $values = array(), array $errors = array())
    {
        $task = $this->getTask();

        $this->response->html($this->template->render('task_external_link/find', array(
            'values' => $values,
            'errors' => $errors,
            'task' => $task,
            'types' => $this->externalLinkManager->getTypes(),
        )));
    }

    /**
     * Second creation form
     *
     * @access public
     */
    public function create()
    {
        $task = $this->getTask();
        $values = $this->request->getValues();

        try {
            $provider = $this->externalLinkManager->setUserInput($values)->find();
            $link = $provider->getLink();

            $this->response->html($this->template->render('task_external_link/create', array(
                'values' => array(
                    'title' => $link->getTitle(),
                    'url' => $link->getUrl(),
                    'link_type' => $provider->getType(),
                ),
                'dependencies' => $provider->getDependencies(),
                'errors' => array(),
                'task' => $task,
            )));
        } catch (ExternalLinkProviderNotFound $e) {
            $errors = array('text' => array(t('Unable to fetch link information.')));
            $this->find($values, $errors);
        }
    }

    /**
     * Save link
     *
     * @access public
     */
    public function save()
    {
        $task = $this->getTask();
        $values = $this->request->getValues();
        list($valid, $errors) = $this->externalLinkValidator->validateCreation($values);

        if ($valid && $this->taskExternalLinkModel->create($values) !== false) {
            $this->flash->success(t('Link added successfully.'));
            return $this->response->redirect($this->helper->url->to('TaskViewController', 'show', array('task_id' => $task['id'], 'project_id' => $task['project_id'])), true);
        }

        return $this->edit($values, $errors);
    }

    /**
     * Edit form
     *
     * @access public
     * @param  array $values
     * @param  array $errors
     * @throws ExternalLinkProviderNotFound
     * @throws PageNotFoundException
     * @throws \Hiject\Core\Controller\AccessForbiddenException
     */
    public function edit(array $values = array(), array $errors = array())
    {
        $task = $this->getTask();
        $link_id = $this->request->getIntegerParam('link_id');

        if ($link_id > 0) {
            $values = $this->taskExternalLinkModel->getById($link_id);
        }

        if (empty($values)) {
            throw new PageNotFoundException();
        }

        $provider = $this->externalLinkManager->getProvider($values['link_type']);

        $this->response->html($this->template->render('task_external_link/edit', array(
            'values' => $values,
            'errors' => $errors,
            'task' => $task,
            'dependencies' => $provider->getDependencies(),
        )));
    }

    /**
     * Update link
     *
     * @access public
     */
    public function update()
    {
        $task = $this->getTask();
        $values = $this->request->getValues();
        list($valid, $errors) = $this->externalLinkValidator->validateModification($values);

        if ($valid && $this->taskExternalLinkModel->update($values)) {
            $this->flash->success(t('Link updated successfully.'));
            return $this->response->redirect($this->helper->url->to('TaskViewController', 'show', array('task_id' => $task['id'], 'project_id' => $task['project_id'])), true);
        }

        return $this->edit($values, $errors);
    }

    /**
     * Confirmation dialog before removing a link
     *
     * @access public
     */
    public function confirm()
    {
        $task = $this->getTask();
        $link_id = $this->request->getIntegerParam('link_id');
        $link = $this->taskExternalLinkModel->getById($link_id);

        if (empty($link)) {
            throw new PageNotFoundException();
        }

        $this->response->html($this->template->render('task_external_link/remove', array(
            'link' => $link,
            'task' => $task,
        )));
    }

    /**
     * Remove a link
     *
     * @access public
     */
    public function remove()
    {
        $this->checkCSRFParam();
        $task = $this->getTask();

        if ($this->taskExternalLinkModel->remove($this->request->getIntegerParam('link_id'))) {
            $this->flash->success(t('Link removed successfully.'));
        } else {
            $this->flash->failure(t('Unable to remove this link.'));
        }

        $this->response->redirect($this->helper->url->to('TaskViewController', 'show', array('task_id' => $task['id'], 'project_id' => $task['project_id'])));
    }
}
