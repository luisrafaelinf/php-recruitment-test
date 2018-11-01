<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;

use Snowdog\DevTest\Controller\AbstractController\ForbiddenAbstract;
use Snowdog\DevTest\Constant\SessionValue;

class RegisterAction extends ForbiddenAbstract
{

    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function execute()
    {

        if (!isset($_SESSION[SessionValue::LOGIN])) {
            $this->forbidden();
        }

        $password = $_POST['password'];
        $confirm = $_POST['confirm'];
        $name = $_POST['name'];
        $login = $_POST['login'];

        if($password != $confirm) {
            $_SESSION['flash'] = 'Given passwords do not match';
        } else if (empty($password)) {
            $_SESSION['flash'] = 'Password cannot be empty!';
        } else if (empty($login) || empty($name)) {
            $_SESSION['flash'] = 'Name or login cannot be empty!';
        } else {
            if($this->userManager->create($login, $password, $name)) {
                $_SESSION['flash'] = 'Hello ' . $name . '!';
                $_SESSION['login'] = $login;
                header('Location: /');
                return;
            }
        }

        header('Location: /register');
    }
}
