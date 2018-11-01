<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Controller\AbstractController\ForbiddenAbstract;
use Snowdog\DevTest\Constant\SessionValue;

class RegisterFormAction extends ForbiddenAbstract
{
    public function execute() {
        require __DIR__ . '/../view/register.phtml';
    }
}
