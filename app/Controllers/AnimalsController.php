<?php
namespace App\Controllers;

use App\Models\Animal;

class AnimalsController
{
    public function index()
    {
        $animals = Animal::all();
        echo json_encode($animals);
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID']);
            return;
        }
        $animal = Animal::find((int)$id);
        echo json_encode($animal);
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $animal = Animal::create($data);
        echo json_encode($animal);
    }
}
