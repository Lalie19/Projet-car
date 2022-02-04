<?php

namespace App\Controller;

use App\Model\TypeManager;

/**
 * Class TypeController
 *
 */
class TypeController extends AbstractController
{


    /**
     * Display type listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $typeManager = new TypeManager();
        $types = $typeManager->selectAll();

        return $this->twig->render('Type/index.html.twig', ['types' => $types]);
    }


    /**
     * Display type informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $typeManager = new TypeManager();
        $type = $typeManager->selectOneById($id);

        return $this->twig->render('Type/show.html.twig', ['type' => $type]);
    }


    /**
     * Display type edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $typeManager = new TypeManager();
        $type = $typeManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type= [
                "category" => $_POST['category'],
            ];
            $typeManager->edit($id, $type);
        }

        return $this->twig->render('Type/edit.html.twig', ['type' => $type]);
    }


    /**
     * Display type creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $typeManager = new TypeManager();
            $type= [
                "category" => $_POST['category'],
            ];
            $id = $typeManager->create($type);
            header('Location:/type/show/' . $id);
        }

        return $this->twig->render('Type/add.html.twig');
    }


    /**
     * Handle type deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $typeManager = new TypeManager();
        $typeManager->delete($id);
        header('Location:/type/index');
    }
}
