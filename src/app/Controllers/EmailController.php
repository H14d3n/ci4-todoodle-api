<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TodoModel;

class EmailController extends BaseController
{
    public function index()
    {
        // Fetch open todos (assuming status '0' means open)
        $todoModel = new TodoModel();
        $openTodos = $todoModel->where('status', 0)->findAll();

        if (empty($openTodos)) {
            return $this->response->setJSON(['status' => 'info', 'message' => 'No open todos found.']);
        }

        // Build the message
        $message = "Offene Todos:\n\n";
        foreach ($openTodos as $todo) {
            $message .= "- " . $todo['title'];
            if (!empty($todo['due_date'])) {
                $message .= " (Fällig: " . $todo['due_date'] . ")";
            }
            $message .= "\n";
        }

        $notificationsTo = config('Email')->notificationsTo;

        $email = \Config\Services::email();
        $email->setFrom('mailer@berufsbildung-test.ch', 'Meine Test API');
        $email->setTo($notificationsTo); // Use the configured email address
        $email->setSubject('Offene Todos');
        $email->setMessage($message);

        if ($email->send()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Email sent successfully.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => $email->printDebugger(['headers'])]);
        }
    }
}
