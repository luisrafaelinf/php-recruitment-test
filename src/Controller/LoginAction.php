<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Model\UserManager;

use Snowdog\DevTest\Controller\AbstractController\ForbiddenAbstract;
use Snowdog\DevTest\Constant\SessionValue;

class LoginAction extends ForbiddenAbstract
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

        $login = $_POST['login'];
        $password = $_POST['password'];

        /** @var User $user */
        $user = $this->userManager->getByLogin($login);
        if($user) {
            if($this->userManager->verifyPassword($user, $password)) {
                $_SESSION['login'] = $login;
                $_SESSION['flash'] = 'Hello ' . $user->getDisplayName() . '!';
                header('Location: /');
                return;
            }
        }

        $_SESSION['flash'] = 'Incorrect login or password';
        header('Location: /');
    }
}
