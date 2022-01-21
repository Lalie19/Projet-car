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
        $carManager = new cCarManager();
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
            $car['title'] = $_POST['title'];
            $carManager->update($car);
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
            $car = [
                'title' => $_POST['title'],
            ];
            $id = $carManager->insert($car);
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
}
