<?php

namespace App\Controller;

use App\Model\RenaultManager;

/**
 * Class RenaultController
 *
 */
class RenaultController extends AbstractController
{


    /**
     * Display renault listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $renaultManager = new RenaultManager();
        $renaults = $renaultManager->selectAll();

        return $this->twig->render('Renault/index.html.twig', ['renaults' => $renaults]);
    }


    /**
     * Display renault informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $renaultManager = new RenaultManager();
        $renault = $renaultManager->selectOneById($id);

        

        return $this->twig->render('Renault/show.html.twig', ['renault' => $renault]);
    }


    /**
     * Display renault edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $renaultManager = new RenaultManager();
        $renault = $renaultManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $renault= [
                "brand" => $_POST['brand'],
                "plate" => $_POST['plate'],
                "door" => $_POST['door'],
                "capacity" => $_POST['capacity'],
                "name" => $_POST['name'],
                "image" => $_POST['image'],
                "mileage" => $_POST['mileage'],
                "description" => $_POST['description'],
            ];
            $renaultManager->edit($id, $renault);
        }

        return $this->twig->render('Renault/edit.html.twig', ['renault' => $renault]);
    }


    /**
     * Display renault creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $renaultManager = new RenaultManager();
            $renault= [
                "brand" => $_POST['brand'],
                "plate" => $_POST['plate'],
                "door" => $_POST['door'],
                "capacity" => $_POST['capacity'],
                "name" => $_POST['name'],
                "image" => $_POST['image'],
                "mileage" => $_POST['mileage'],
                "description" => $_POST['description'],
            ];
            $id = $renaultManager->create($renault);
            header('Location:/renault/show/' . $id);
        }

        return $this->twig->render('Renault/add.html.twig');
    }


    /**
     * Handle renault deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $renaultManager = new RenaultManager();
        $renaultManager->delete($id);
        header('Location:/renault/index');
    }
}
