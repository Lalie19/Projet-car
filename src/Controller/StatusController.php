<?php

namespace App\Controller;

use App\Model\StatusManager;

/**
 * Class StatusController
 *
 */
class StatusController extends AbstractController
{


    /**
     * Display status listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $statusManager = new StatusManager();
        $statuss = $statusManager->selectAll();

        return $this->twig->render('Status/index.html.twig', ['statuss' => $statuss]);
    }


    /**
     * Display status informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $statusManager = new StatusManager();
        $status = $statusManager->selectOneById($id);

        return $this->twig->render('Status/show.html.twig', ['status' => $status]);
    }


    /**
     * Display status edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $statusManager = new StatusManager();
        $status = $statusManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status= [
                "category_flue" => $_POST['category_flue'],
            ];
            $statusManager->edit($id, $status);
        }

        return $this->twig->render('Status/edit.html.twig', ['status' => $status]);
    }


    /**
     * Display status creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $statusManager = new StatusManager();
            $status= [
                "available" => $_POST['available'],
                "lieu" => $_POST['lieu'],
            ];
            $id = $statusManager->create($status);
            header('Location:/status/show/' . $id);
        }

        return $this->twig->render('Status/add.html.twig');
    }


    /**
     * Handle status deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $statusManager = new StatusManager();
        $statusManager->delete($id);
        header('Location:/status/index');
    }
}
