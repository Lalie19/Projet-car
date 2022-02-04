<?php

namespace App\Controller;

use App\Model\ServiceManager;

/**
 * Class ServiceController
 *
 */
class ServiceController extends AbstractController
{


    /**
     * Display service listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $serviceManager = new ServiceManager();
        $services = $serviceManager->selectAll();

        return $this->twig->render('Reservation/index.html.twig', ['services' => $services]);
    }


    /**
     * Display service informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $serviceManager = new ServiceManager();
        $service = $serviceManager->selectOneById($id);

        return $this->twig->render('Service/show.html.twig', ['service' => $service]);
    }


    /**
     * Display service edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $serviceManager = new ServiceManager();
        $service = $serviceManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service= [
                "name" => $_POST['name'],
                "price" => $_POST['price'],
                "description" => $_POST['description'],
            ];
            $serviceManager->edit($id, $service);
        }

        return $this->twig->render('Service/edit.html.twig', ['service' => $service]);
    }


    /**
     * Display service creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serviceManager = new ServiceManager();
            $service= [
                "name" => $_POST['name'],
                "price" => $_POST['price'],
                "description" => $_POST['description'],
            ];
            $id = $serviceManager->create($service);
            header('Location:/service/show/' . $id);
        }

        return $this->twig->render('Service/add.html.twig');
    }


    /**
     * Handle service deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $serviceManager = new ServiceManager();
        $serviceManager->delete($id);
        header('Location:/service/index');
    }

    public function ma_reservation()
    {
        $id = $_SESSION['service']['id'];
        $serviceManager = new ServiceManager();
        $service = $servicerManager->selectOneById($id);
    ;
    

        return $this->twig->render('Service/ma_reservation.html.twig', ['service' => $service]);
    }

}
