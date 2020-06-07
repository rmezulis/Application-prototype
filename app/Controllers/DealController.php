<?php


namespace App\Controllers;


use App\Core\Mail;

class DealController
{
    public function index()
    {
        $statement = 'SELECT * FROM applications JOIN deals on application_id=applications.id WHERE status=:status';
        $deals = database()->prepare($statement);
        $deals->execute(['status' => 'ask']);
        $deals = $deals->fetchAll();
        include_once 'app/Views/deals.php';
    }

    public function offer(array $parameters)
    {
        $deal = 'UPDATE deals SET status=:status WHERE id=:id';
        database()->prepare($deal)->execute([
            'status' => 'offer',
            'id' => $parameters['id']
        ]);
        Mail::send($_POST['email']);
        header('Location: /deals');
    }
}