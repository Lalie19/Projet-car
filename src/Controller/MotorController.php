<?php

namespace App\Controller;

use App\Model\MotorManager;

/**
 * Class MotorController
 *
 */
class MotorController extends AbstractController
{


    /**
     * Display motor listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $motorManager = new MotorManager();
        $motors = $motorManager->selectAll();

        return $this->twig->render('Motor/index.html.twig', ['motors' => $motors]);
    }


    /**
     * Display motor informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $motorManager = new MotorManager();
        $motor = $motorManager->selectOneById($id);

        return $this->twig->render('Motor/show.html.twig', ['motor' => $motor]);
    }


    /**
     * Display motor edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $motorManager = new MotorManager();
        $motor = $motorManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $motor= [
                "category_flue" => $_POST['category_flue'],
            ];
            $motorManager->edit($id, $motor);
        }

        return $this->twig->render('Motor/edit.html.twig', ['motor' => $motor]);
    }


    /**
     * Display motor creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $motorManager = new MotorManager();
            $motor= [
                "category_flue" => $_POST['category_flue'],
            ];
            $id = $motorManager->create($motor);
            header('Location:/motor/show/' . $id);
        }

        return $this->twig->render('Motor/add.html.twig');
    }


    /**
     * Handle motor deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $motorManager = new MotorManager();
        $motorManager->delete($id);
        header('Location:/motor/index');
    }
}
