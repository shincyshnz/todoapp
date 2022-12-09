<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TaskModel;
use CodeIgniter\HTTP\IncomingRequest;

// use CodeIgniter\Validation\Validation;
// use Config\Services;

class Home extends BaseController
{
    public $request;
    protected $helpers = ['url', 'form'];

    public function index()
    {
        $request = \Config\Services::request();
        $taskModel = new TaskModel();

        $data = [];
        $rules = [
            'task-name' => 'required|min_length[3]',
            'task-description' => 'required'
        ];

        if ($request->getMethod() == 'post') {
            if ($this->validate($rules)) {
                $formData = [
                    'name' => $this->request->getVar('task-name'),
                    'description' => $this->request->getVar('task-description')
                ];
                //save task data to the database
                try {
                    $taskModel->insert($formData);
                } catch (\Exception $e) {
                    exit($e->getMessage());
                }
            }
        } else {
            $data['textarea'] = $this->request->getVar('task-description');
            $data['validation'] = $this->validator;
        }

        //retrieve Data from database
        $data['taskData'] = $taskModel->findAll();

        return view('templates/header')
            . view('pages/todo', $data) . view('templates/footer');
    }

    public function fetchTaskData()
    {
        $taskModel = new TaskModel();
        $id =  $this->request->getGet('taskId');
        $data['taskInfo'] = $taskModel->find($id);
        return $this->response->setJSON($data);
    }

    public function updateTaskData()
    {
        $taskModel = new TaskModel();
        $id =  $this->request->getVar("taskId");
        $data = [
            'name' => $this->request->getVar("name"),
            'description' => $this->request->getVar("description")
        ];
        $taskModel->update($id, $data);
        $output = array('status' => 'Task Updated Successfully', 'data' => $data);
        return $this->response->setJSON($output);
    }

    public function deleteTaskData()
    {
        $taskModel = new TaskModel();
        $id =  $this->request->getVar("taskId");

        $taskModel->delete($id);
        $output = array('status' => 'Task Deleted Successfully');
        return $this->response->setJSON($output);
    }
}
