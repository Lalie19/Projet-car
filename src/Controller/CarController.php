<?php

namespace App\Controller;

use App\Model\CarManager;

/**
 * Class CarController
 *
 */
class CarController extends AbstractController
{


    /**
     * Display car listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $carManager = new CarManager();
        $cars = $carManager->selectAll();

        return $this->twig->render('Car/index.html.twig', ['cars' => $cars]);
    }


    /**
     * Display car informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $carManager = new CarManager();
        $car = $carManager->selectOneById($id);

        return $this->twig->render('Car/show.html.twig', ['car' => $car]);
    }


    /**
     * Display car edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $carManager = new CarManager();
        $car = $carManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $car= [
                "brand" => $_POST['brand'],
                "plate" => $_POST['plate'],
                "door" => $_POST['door'],
                "capacity" => $_POST['capacity'],
                "name" => $_POST['name'],
                "image" => $_POST['image'],
                "mileage" => $_POST['mileage'],
                "description" => $_POST['description'],
            ];
            $carManager->edit($id, $car);
        }

        return $this->twig->render('Car/edit.html.twig', ['car' => $car]);
    }


    /**
     * Display car creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $carManager = new CarManager();
            $car= [
                "brand" => $_POST['brand'],
                "plate" => $_POST['plate'],
                "door" => $_POST['door'],
                "capacity" => $_POST['capacity'],
                "name" => $_POST['name'],
                "image" => $_POST['image'],
                "mileage" => $_POST['mileage'],
                "description" => $_POST['description'],
            ];
            $id = $carManager->create($car);
            header('Location:/car/show/' . $id);
        }

        return $this->twig->render('Car/add.html.twig');
    }


    /**
     * Handle car deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $carManager = new CarManager();
        $carManager->delete($id);
        header('Location:/car/index');
    }
    
    public function list()
    {
        $this->isGranted("ROLE_ADMIN", "/");
        $carManager = new CarManager();
        $cars = $carManager->selectAllOrdered();
        return $this->twig->render('Car/list.html.twig', [
            'cars' => $cars,
        ]);
    }
}
