<?php

namespace App\Controller;

use App\Model\PeugeotManager;

/**
 * Class PeugeotController
 *
 */
class PeugeotController extends AbstractController
{


    /**
     * Display peugeot listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $peugeotManager = new PeugeotManager();
        $peugeots = $peugeotManager->selectAll();

        return $this->twig->render('Peugeot/index.html.twig', ['peugeots' => $peugeots]);
    }


    /**
     * Display peugeot informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $peugeotManager = new PeugeotManager();
        $peugeot = $peugeotManager->selectOneById($id);

        

        return $this->twig->render('Peugeot/show.html.twig', ['peugeot' => $peugeot]);
    }


    /**
     * Display peugeot edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $peugeotManager = new PeugeotManager();
        $peugeot = $peugeotManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $peugeot= [
                "brand" => $_POST['brand'],
                "plate" => $_POST['plate'],
                "door" => $_POST['door'],
                "capacity" => $_POST['capacity'],
                "name" => $_POST['name'],
                "image" => $_POST['image'],
                "mileage" => $_POST['mileage'],
                "description" => $_POST['description'],
            ];
            $peugeotManager->edit($id, $peugeot);
        }

        return $this->twig->render('Peugeot/edit.html.twig', ['peugeot' => $peugeot]);
    }


    /**
     * Display peugeot creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $peugeotManager = new PeugeotManager();
            $peugeot= [
                "brand" => $_POST['brand'],
                "plate" => $_POST['plate'],
                "door" => $_POST['door'],
                "capacity" => $_POST['capacity'],
                "name" => $_POST['name'],
                "image" => $_POST['image'],
                "mileage" => $_POST['mileage'],
                "description" => $_POST['description'],
            ];
            $id = $peugeotManager->create($peugeot);
            header('Location:/peugeot/show/' . $id);
        }

        return $this->twig->render('Peugeot/add.html.twig');
    }


    /**
     * Handle peugeot deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $peugeotManager = new PeugeotManager();
        $peugeotManager->delete($id);
        header('Location:/peugeot/index');
    }
}
