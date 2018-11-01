<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;
use Snowdog\DevTest\Model\PageManager;

use Snowdog\DevTest\Controller\AbstractController\ForbiddenAbstract;
use Snowdog\DevTest\Constant\SessionValue;

class IndexAction extends ForbiddenAbstract
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
     * @var User
     */
    private $user;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {

        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;

        $this->user = $userManager->getByLogin($_SESSION[SessionValue::LOGIN]);

    }

    protected function getWebsites()
    {
        if($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        }
        return [];
    }

    public function execute()
    {
        if (!isset($_SESSION[SessionValue::LOGIN])) {
            $this->forbidden();
        }

        require __DIR__ . '/../view/index.phtml';
    }

    public function getTotalPagesUser()
    {
        return $this->pageManager->totalPagesByUser($this->user);
    }

    public function getLeastPageVisitedByUser()
    {
        $pageUrl = $this->pageManager->leastRecentlyVisitedByUser($this->user);
        return $pageUrl ? $pageUrl : '';
    }

    public function getMostPageVisitedByUser()
    {
        $pageUrl = $this->pageManager->mostRecentlyVisitedByUser($this->user);
        return $pageUrl ? $pageUrl : '';
    }

}
