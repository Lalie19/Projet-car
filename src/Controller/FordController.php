<?php

namespace App\Controller;

use App\Model\FordManager;

/**
 * Class FordController
 *
 */
class FordController extends AbstractController
{


    /**
     * Display ford listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $fordManager = new FordManager();
        $fords = $fordManager->selectAll();

        return $this->twig->render('Ford/index.html.twig', ['fords' => $fords]);
    }


    /**
     * Display ford informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $fordManager = new FordManager();
        $ford = $fordManager->selectOneById($id);

        

        return $this->twig->render('Ford/show.html.twig', ['ford' => $ford]);
    }


    /**
     * Display ford edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $fordManager = new FordManager();
        $ford = $fordManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ford= [
                "brand" => $_POST['brand'],
                "plate" => $_POST['plate'],
                "door" => $_POST['door'],
                "capacity" => $_POST['capacity'],
                "name" => $_POST['name'],
                "image" => $_POST['image'],
                "mileage" => $_POST['mileage'],
                "description" => $_POST['description'],
            ];
            $fordManager->edit($id, $ford);
        }

        return $this->twig->render('Ford/edit.html.twig', ['ford' => $ford]);
    }


    /**
     * Display ford creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fordManager = new FordManager();
            $ford= [
                "brand" => $_POST['brand'],
                "plate" => $_POST['plate'],
                "door" => $_POST['door'],
                "capacity" => $_POST['capacity'],
                "name" => $_POST['name'],
                "image" => $_POST['image'],
                "mileage" => $_POST['mileage'],
                "description" => $_POST['description'],
            ];
            $id = $fordManager->create($ford);
            header('Location:/ford/show/' . $id);
        }

        return $this->twig->render('Ford/add.html.twig');
    }


    /**
     * Handle ford deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $fordManager = new FordManager();
        $fordManager->delete($id);
        header('Location:/ford/index');
    }
}
