<?php

namespace App\Controller;

use App\Model\UserManager;

/**
 * Class UserController
 *
 */
class UserController extends AbstractController
{


    /**
     * Display user listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $this->redirectTo("/user/login");
    }
    /**
     * Display user listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $error = false;
            if (!$_POST['email']) {
                $this->addFlash("color-danger", "une adresse de courriel est obligatoire");
                $error = true;
            }
            if (!$_POST['password']) {
                $this->addFlash("color-danger", "vous devez rentrer un mot de passe");
                $error = true;
            }
            if (!$error) {
                $userManager = new UserManager();
                $criteria = [
                    "email" => $_POST["email"],
                ];
                $userTab = $userManager->findBy($criteria);
                $user = $userTab[0];
                if ($user ?? false) {
                    $passOk = password_verify($_POST['password'], $user["password"]);
                    if ($passOk) {
                        // connexion
                        $_SESSION['user'] = $user;
                        unset($_SESSION['user']['password']);
                        $_SESSION['user']['role'] = json_decode($user['role']);
                        $this->addFlash("color-success", "vous êtes connecté");
                        $this->redirectTo("/");
                    }
                }
                $this->addFlash("color-danger", "erreur de mot de passe ou de courriel");
            }
        }

        return $this->twig->render('User/login.html.twig');
    }

    public function logout()
    {
        unset($_SESSION["user"]);
        $this->addFlash("color-success", "vous êtes correctement déconnecté");
        $this->redirectTo("/");
    }



    /**
     * Display user informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function profile()
    {
        $id = $_SESSION['user']['id'];
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/profile.html.twig', ['user' => $user]);
    }
    


    /**
     * Display user edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $idUser = $_SESSION["user"]["id"];
        if ($this->isGranted("ROLE_ADMIN")) {
            $admin = true;
        } else {
            $admin = false;
        }

        $userManager = new UserManager();
        if ($id) {
            $user = $userManager->selectOneById($id);
        } else {
            $user = $userManager->selectOneById($idUser);
        }

        if ($user["id"] != $idUser) {
            if (!$admin) {
                $this->addFlash("color-danger", "vous n'avez pas acces à cet utilisateur");
                $this->redirectTo("/user/profile");
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $error = false;
            if (!$_POST['firstname']) {
                $this->addFlash("color-danger", "le prénom est obligatoire");
                $error = true;
            }
            if (!$_POST['lastname']) {
                $this->addFlash("color-danger", "le nom est obligatoire");
                $error = true;
            }
            if (!$_POST['email']) {
                $this->addFlash("color-danger", "une adresse de courriel est obligatoire");
                $error = true;
            }
            $criteria = [
                "email" => $_POST['email'],
            ];
            $testEmail = $userManager->findBy($criteria);
            if (!$admin) {
                if ($testEmail[0]['id'] != $idUser) {
                    $this->addFlash("color-danger", "Un compte est déjà enregistré avec cette adresse de courriel");
                    $error = true;
                }
            } elseif ($admin) {
                if ($testEmail[0]['id'] != $_POST["id"]) {
                    $this->addFlash("color-danger", "Un compte est déjà enregistré avec cette adresse de courriel");
                    $error = true;
                }
            }
            $user= [
                "firstname" => $_POST['firstname'],
                "lastname" => $_POST['lastname'],
                "email" => $_POST['email'],
                "adress" => $_POST['adress'],
                "phone" => $_POST['phone'],
                "password" => $_POST['password'],
            ];
            $userManager->edit($id, $user);
        }
        if (!$error) {
            $password = $_POST["password"];
            if ($password) {
                $user['password'] = password_hash($password, PASSWORD_ARGON2ID);
            }
            $userManager->edit($id, $user);
            if ($admin) {
                $this->redirectTo("/user/list");
            }
            $this->redirectTo("/user/profile");
        }
        $roles = ROLE;
    return $this->twig->render('User/edit.html.twig', [
        'user' => $user,
        'roles' => $roles,
    ]);
    }
    
    


    /**
     * Display user creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function subscribe()
    {
        $user= [
            "firstname" => "",
            "lastname" => "",
            "email" => "",
            "adress" => "",
            "phone" =>"",
            "password" => "",
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $error = false;
            if (!$_POST['firstname']) {
                $this->addFlash("color-danger", "le prénom est obligatoire");
                $error = true;
            }
            if (!$_POST['lastname']) {
                $this->addFlash("color-danger", "le nom est obligatoire");
                $error = true;
            }
            if (!$_POST['email']) {
                $this->addFlash("color-danger", "il faut un e-mail obligatoirement");
                $error = true;
            }
            if (!$_POST['adress']) {
                $this->addFlash("color-danger", "une adresse est obligatoire");
                $error = true;
            }
            if (!$_POST['phone']) {
                $this->addFlash("color-danger", "le numéro de téléphone est obligatoire");
                $error = true;
            }
            if (!$_POST['password']) {
                $this->addFlash("color-danger", "le mot de passe est obligatoire");
                $error = true;
            }
            $criteria = [
                "email" => $_POST['email'],
            ];
            $testEmail = $userManager->findBy($criteria);
            if ($testEmail) {
                $this->addFlash("color-danger", "Un compte est déjà enregistré avec cette adresse de courriel");
                $error = true;
            }
            $user= [
                "firstname" => $_POST['firstname'],
                "lastname" => $_POST['lastname'],
                "email" => $_POST['email'],
                "adress" => $_POST['adress'],
                "phone" => $_POST['phone'],
                "password" => $_POST['password'],
                "role" => json_encode(["ROLE_USER"]),
            ];
            
            if (!$error) {
                $user['password'] = password_hash($_POST['password'], PASSWORD_ARGON2ID);
                $userManager->create($user);
                $this->addFlash("color-success", "votre compte a été créé");
                $this->redirectTo("/user/login");
            }
            
        }
        return $this->twig->render('User/subscribe.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * Handle user deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $userManager = new UserManager();
        $userManager->delete($id);
        header('Location:/user/index');
    }
    public function list()
    {
        $this->isGranted("ROLE_ADMIN", "/");
        $userManager = new UserManager();
        $users = $userManager->selectAllOrdered();
        return $this->twig->render('User/list.html.twig', [
            'users' => $users,
        ]);
    }

    public function add()
    {
        $user = [
            "firstname" => "",
            "lastname" => "",
            "email" => "",
            "adress" => "",
            "phone" =>"",
            "password" => "",
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $error = false;
            if (!$_POST['firstname']) {
                $this->addFlash("color-danger", "le prénom est obligatoire");
                $error = true;
            }
            if (!$_POST['lastname']) {
                $this->addFlash("color-danger", "le nom est obligatoire");
                $error = true;
            }
            if (!$_POST['email']) {
                $this->addFlash("color-danger", "une adresse de courriel est obligatoire");
                $error = true;
            }
            if (!$_POST['password']) {
                $this->addFlash("color-danger", "vous devez rentrer un mot de passe");
                $error = true;
            }
            $criteria = [
                "email" => $_POST['email'],
            ];
            $testEmail = $userManager->findBy($criteria);
            if ($testEmail) {
                $this->addFlash("color-danger", "Un compte est déjà enregistré avec cette adresse de courriel");
                $error = true;
            }
            $user = [
                "firstname" => $_POST['firstname'],
                "lastname" => $_POST['lastname'],
                "email" => $_POST['email'],
                "adress" => $_POST['adress'],
                "phone" => $_POST['phone'],
                "password" => $_POST['password'],
                "role" => json_encode(["ROLE_USER"]),
            ];

            if (!$error) {
                // TO DO hash password
                $user['password'] = password_hash($_POST['password'], PASSWORD_ARGON2ID);
                $userManager->create($user);
                $this->addFlash("color-success", "le compte a été créé");
                $this->redirectTo("/user/list");
            }
        }

        return $this->twig->render('User/add.html.twig', [
            'user' => $user,
        ]);
    }
}
