<?php

namespace Myexp\Bundle\CmsBundle\Helper;

class Paginator {

    /**
     * @var boolean 分页仅有一页情况下隐藏
     */
    protected $autoHide = true;

    /**
     * @var boolean page变量显示在第一页的url上
     */
    protected $firstPageInUrl = false;

    /**
     * @var int 当前页
     */
    protected $currentPage;

    /**
     * @var int 总页数
     */
    protected $totalPages;

    /**
     * @var int 总记录数
     */
    protected $totalItems;

    /**
     * @var int 分页偏移量
     */
    protected $offset;

    /**
     * @var int 分页大小
     */
    protected $limit;

    /**
     * @var array 分页大小可选项
     */
    protected $limitOptions;

    /**
     * @var array 分页后的链接
     */
    protected $links;

    /**
     * @var boolean 是否显示分页大小
     */
    protected $showLimit = true;

    /**
     * 构造函数
     */
    function __construct($totalItems, $options = array(10, 20, 50, 100, 200)) {

        $this->totalItems = $totalItems;
        $this->limitOptions = $options;

        $this->getParamsFromRequest();

        $this->totalPages = (int) ceil($this->totalItems / $this->limit);
        $this->offset = ($this->currentPage - 1) * $this->limit;

        $this->genLinks();
    }

    private function getParamsFromRequest() {

        //If current page number is set in URL
        if (isset($_GET['page'])) {
            $this->currentPage = intval($_GET['page']);
        } else {
            //else set default page to render
            $this->currentPage = 1;
        }

        //If limit is defined in URL
        if (isset($_GET['limit'])) {
            $this->limit = intval($_GET['limit']);
        } else {   //else set default limit to 20
            $this->limit = $this->limitOptions[0];
        }

        //If currentpage is set to null or is set to 0 or less
        //set it to default (1)
        if (($this->currentPage == null) || ($this->currentPage < 1)) {
            $this->currentPage = 1;
        }

        //if limit is set to null set it to default (10)
        if (($this->limit == null)) {
            $this->limit = 20;
            //if limit is any number less than 1 then set it to 0 for displaying 
            //items without limit
        } else if ($this->limit < 1) {
            $this->limit = 0;
        }
    }

    private function genLinks() {

        if ($this->autoHide && $this->totalPages == 1) {
            $this->links = array();
            return;
        }

        /*
          First Previous 1 2 3 ... 22 23 24 25 26 [27] 28 29 30 31 32 ... 48 49 50 Next Last
         */

        // Number of page links in the begin and end of whole range
        $countOut = 3;

        // Number of page links on each side of current page
        $countIn = 3;

        // Beginning group of pages: $n1...$n2
        $n1 = 1;
        $n2 = min($countOut, $this->totalPages);

        // Ending group of pages: $n7...$n8
        $n7 = max(1, $this->totalPages - $countOut + 1);
        $n8 = $this->totalPages;

        // Middle group of pages: $n4...$n5
        $n4 = max($n2 + 1, $this->currentPage - $countIn);
        $n5 = min($n7 - 1, $this->currentPage + $countIn);
        $useMiddle = ($n5 >= $n4);

        // Point $n3 between $n2 and $n4
        $n3 = (int) (($n2 + $n4) / 2);
        $useN3 = ($useMiddle && (($n4 - $n2) > 1));

        // Point $n6 between $n5 and $n7
        $n6 = (int) (($n5 + $n7) / 2);
        $useN6 = ($useMiddle && (($n7 - $n5) > 1));

        // Links to display as array(page => content)
        $links = $numbers = array();

        // Generate links data in accordance with calculated numbers
        for ($i = $n1; $i <= $n2; $i++) {
            $numbers[] = $i;
            $links[] = array('number' => $i, 'content' => $i, 'url' => $this->url($i));
        }
        if ($useN3) {
            $links[] = array('number' => $n3, 'content' => '&hellip;', 'url' => $this->url($i));
        }
        for ($i = $n4; $i <= $n5; $i++) {
            $links[] = array('number' => $i, 'content' => $i, 'url' => $this->url($i));
        }
        if ($useN6) {
            $links[] = array('number' => $n6, 'content' => '&hellip;', 'url' => $this->url($i));
        }
        for ($i = $n7; $i <= $n8; $i++) {
            if (in_array($i, $numbers))
                continue;
            $links[] = array('number' => $i, 'content' => $i, 'url' => $this->url($i));
        }

        $this->links = $links;
    }

    public function limitUrl() {

        $query_array = array();

        if (isset($_SERVER['QUERY_STRING'])) {
            $query_string = $_SERVER['QUERY_STRING'];
            parse_str($query_string, $query_array);
        }

        $path_array = parse_url($_SERVER['REQUEST_URI']);

        $query_array['page'] = 1;
        $query_array['limit'] = 'paginator_limit';

        return $path_array['path'] . '?' . http_build_query($query_array);
    }

    public function url($page) {

        $query_array = array();

        if (isset($_SERVER['QUERY_STRING'])) {
            $query_string = $_SERVER['QUERY_STRING'];
            parse_str($query_string, $query_array);
        }

        $path_array = parse_url($_SERVER['REQUEST_URI']);

        $query_array['page'] = $page;
        $query_array['limit'] = $this->limit;

        return $path_array['path'] . '?' . http_build_query($query_array);
    }

    public function getAutoHide() {
        return $this->autoHide;
    }

    public function getTotalPages() {
        return $this->totalPages;
    }

    public function getShowLimit() {
        return $this->showLimit;
    }

    public function setShowLimit($showLimit) {
        $this->showLimit = $showLimit;
    }

    public function getLimitOptions() {
        return $this->limitOptions;
    }

    public function setLimitOptions($limitOptions) {
        $this->limitOptions = $limitOptions;
    }

    public function getCurrentpage() {
        return $this->currentPage;
    }

    public function getCurrentUrl() {
        return $this->currentUrl;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getOffset() {
        return $this->offset;
    }

    public function getLinks() {
        return $this->links;
    }

}