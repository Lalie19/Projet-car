<?php

namespace App\Controller;

use App\Model\ReservationManager;

/**
 * Class ReservationController
 *
 */
class ReservationController extends AbstractController
{


    /**
     * Display reservation listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $reservationManager = new ReservationManager();
        $reservations = $reservationManager->selectAll();

        return $this->twig->render('Reservation/index.html.twig', ['reservations' => $reservations]);
    }


    /**
     * Display reservation informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $reservationManager = new ReservationManager();
        $reservation = $reservationManager->selectOneById($id);

        return $this->twig->render('Reservation/show.html.twig', ['reservation' => $reservation]);
    }


    /**
     * Display reservation edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $reservationManager = new ReservationManager();
        $reservation = $reservationManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservation= [
                "start_end" => $_POST['start_end'],
                "end-date" => $_POST['end-date'],
            ];
            $reservationManager->edit($id, $reservation);
        }

        return $this->twig->render('Reservation/edit.html.twig', ['reservation' => $reservation]);
    }


    /**
     * Display reservation creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservationManager = new ReservationManager();
            $reservation= [
                "start_end" => $_POST['start_end'],
                "end-date" => $_POST['end-date'],
            ];
            $id = $reservationManager->create($reservation);
            header('Location:/reservation/show/' . $id);
        }

        return $this->twig->render('Reservation/add.html.twig');
    }


    /**
     * Handle reservation deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $reservationManager = new ReservationManager();
        $reservationManager->delete($id);
        header('Location:/reservation/index');
    }
}
