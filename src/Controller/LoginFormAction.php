<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Controller\AbstractController\ForbiddenAbstract;
use Snowdog\DevTest\Constant\SessionValue;

class LoginFormAction extends ForbiddenAbstract
{

    public function execute()
    {
        if (isset($_SESSION[SessionValue::LOGIN])) {
            $this->forbidden();
        } else {
            require __DIR__ . '/../view/login.phtml';
        }
    }
}
