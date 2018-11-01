<?php

namespace Snowdog\DevTest\Controller\AbstractController;

use Snowdog\DevTest\Constant\ConstantValue;

abstract class ForbiddenAbstract
{

    public function forbidden()
    {

        return http_response_code(ConstantValue::FORBIDDEN);

    }

}
