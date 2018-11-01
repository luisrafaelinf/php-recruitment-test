<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;

use Snowdog\DevTest\Controller\AbstractController\ForbiddenAbstract;
use Snowdog\DevTest\Constant\SessionValue;


class CreatePageAction extends ForbiddenAbstract
{

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->userManager = $userManager;
    }

    public function execute()
    {

        if (!isset($_SESSION[SessionValue::LOGIN])) {
            $this->forbidden();
        } else {

            $url = $_POST['url'];
            $websiteId = $_POST['website_id'];

            $user = $this->userManager->getByLogin($_SESSION['login']);
            $website = $this->websiteManager->getById($websiteId);

            if ($website and $website->getUserId() == $user->getUserId()) {
                if (empty($url)) {
                    $_SESSION['flash'] = 'URL cannot be empty!';
                } else {
                    if ($this->pageManager->create($website, $url)) {
                        $_SESSION['flash'] = 'URL ' . $url . ' added!';
                    }
                }
            } else {
                $this->forbidden();
            }
        }

        header('Location: /website/' . $websiteId);
    }
}
