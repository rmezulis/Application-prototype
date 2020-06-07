<?php

namespace App\Controllers;

use App\Core\Mail;

class ApplicationController
{
    public function index()
    {
        include_once 'app/Views/form.php';
    }

    public function create()
    {
        $application = 'INSERT INTO applications (email, sum) VALUES (:email, :sum)';
        database()->prepare($application)->execute([
            'email' => $_POST['email'],
            'sum' => $_POST['sum']
        ]);
        $this->deal(database()->lastInsertId());
        header('Location: /');
    }

    private function deal(int $id)
    {
        $recipient = $_POST['sum'] < 5000 ? 'B' : 'A';
        $deal = 'INSERT INTO deals (application_id, recipient) VALUES (:id, :recipient)';
        database()->prepare($deal)->execute([
            'id' => $id,
            'recipient' => $recipient
        ]);
        Mail::send($recipient);
    }
}