<?php

namespace Kanboard\Controller;

use Kanboard\Core\Controller\AccessForbiddenException;

/**
 * Class TaskBulkSuppressionController
 *
 * @package Kanboard\Controller
 * @author  Frederic Guillot
 */
class TaskBulkSuppressionController extends BaseController
{
    /**
     * Confirmation dialog box
     */
    public function show()
    {
        $project = $this->getProject();
        $taskIDs = explode(',', $this->request->getStringParam('task_ids'));
        $validTaskIDs = [];

        foreach ($taskIDs as $taskID) {
            $task = $this->taskFinderModel->getById($taskID);
            if ($task && $this->helper->projectRole->canRemoveTask($task)) {
                $validTaskIDs[] = $taskID;
            }
        }

        if (empty($validTaskIDs)) {
            throw new AccessForbiddenException();
        }

        $this->response->html($this->template->render('task_bulk_suppression/remove', [
            'project' => $project,
            'task_ids' => implode(',', $validTaskIDs),
        ]));
    }

    /**
     * Remove multiple tasks
     */
    public function remove()
    {
        $project = $this->getProject();
        $this->checkCSRFParam();
        $taskIDs = explode(',', $this->request->getStringParam('task_ids'));

        foreach ($taskIDs as $taskID) {
            $task = $this->taskFinderModel->getById($taskID);
            if ($task && $this->helper->projectRole->canRemoveTask($task)) {
                $this->taskModel->remove($taskID);
            }
        }

        $this->response->redirect($this->helper->url->to('TaskListController', 'show', ['project_id' => $project['id']]), true);
    }
}
