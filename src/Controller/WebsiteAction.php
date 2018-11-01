<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\Website;
use Snowdog\DevTest\Model\WebsiteManager;

use Snowdog\DevTest\Controller\AbstractController\ForbiddenAbstract;
use Snowdog\DevTest\Constant\SessionValue;

class WebsiteAction extends ForbiddenAbstract
{

    /**
     * @var WebsiteManager
     */
    private $websiteManager;
    /**
     * @var PageManager
     */
    private $pageManager;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var Website
     */
    private $website;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->userManager = $userManager;
    }

    public function execute($id)
    {
        if (!isset($_SESSION[SessionValue::LOGIN])) {
            $this->forbidden();
        } else {

            $user = $this->userManager->getByLogin($_SESSION['login']);

            $website = $this->websiteManager->getById($id);

            if ($website and $website->getUserId() == $user->getUserId()) {
                $this->website = $website;
                require __DIR__ . '/../view/website.phtml';
            } else {
                $this->forbidden();
            }

        }


    }

    protected function getPages()
    {
        if($this->website) {
            return $this->pageManager->getAllByWebsite($this->website);
        }
        return [];
    }
}
