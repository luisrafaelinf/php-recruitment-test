<?php

namespace Snowdog\DevTest\Model;

class Page
{

    public $page_id;
    public $url;
    public $website_id;
    public $date_time_last_view;

    public function __construct()
    {
        $this->website_id = intval($this->website_id);
        $this->page_id = intval($this->page_id);
        $this->date_time_last_view = $this->date_time_last_view ? new \DateTime($this->date_time_last_view) : null;

    }

    /**
     * @return int
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getWebsiteId()
    {
        return $this->website_id;
    }

    /**
    * @return string
    */
    public function getDateTimeLastView()
    {
        return $this->date_time_last_view instanceof \DateTime ?
            $this->date_time_last_view->format('Y-m-d H:i:s') : 'Not Visited' ;
    }


}
