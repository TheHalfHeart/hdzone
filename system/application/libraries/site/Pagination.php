<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
// BƯỚC 1: Lấy tổng số record, trang hiện tại và link phân trang
$total_record = 1000;
$current_page = 1;
$link = $this->config->base_url('san-pham/{page}'); // {page} sẽ được replace thành số trang

// BƯỚC 2: Khai báo và lấy html phân trang
$this->load->library('pagination');
$this->pagination->setCurrentPage($current_page);
$this->pagination->setTotalRecord($total_record);
$this->pagination->setLimit(10);
$this->pagination->setLink($link);
$this->pagination->setup();
$html_pagination  = $this->pagination->html();

// BƯỚC 3: Lấy limit và start
$limit = $this->pagination->getLimit();
$start = $this->pagination->getStart();

// BƯỚC : Lấy danh sách theo limit và start
$sql = "select * from table where ... limit $start, $limit";

*/

class Pagination
{
    private $__current_page = 1;
    private $__total_record = 1;
    private $__limit = 10;
    private $__start = 0;
    private $__link = '';
    private $__total_page = 1;
    private $__link_first = '';
    
    function setCurrentPage($current_page)
    {
        $this->__current_page = (int)$current_page;
        if ($this->__current_page < 1){
            $this->__current_page = 1;
        }
    }
    
    function setTotalRecord($total_record)
    {
        $this->__total_record = (int)$total_record;
    }
    
    function setLimit($limit)
    {
        $this->__limit = (int)$limit;
        if ($this->__limit > 50){
            $this->__limit = 50;
        }
        elseif ($this->__limit < 1)
        {
            $this->__limit = 1;
        }
    }
    
    function getLimit()
    {
        return $this->__limit;
    }
    
    function getStart()
    {
        return $this->__start;
    }
    
    function setLink($link)
    {
        $this->__link = $link;
    }
    function setLinkFirst($link)
    {
        $this->__link_first = $link;
    }
    function getCurrentPage(){
        return $this->__current_page;
    }
    
    function getTotalPage(){
        return $this->__total_page;
    }
    
    function getCurrentLink(){
        return $this->__link($this->__current_page);
    }
    
    function getNextLink(){
        if ($this->__current_page >= $this->__total_page){
            return '';
        }
        else{
            return $this->__link(($this->__current_page+1));
        }
    }
    
    function getPrevLink(){
        if ($this->__current_page <= 1){
            return '';
        }
        else{
            return $this->__link(($this->__current_page-1));
        }
    }
    
    function setup()
    {
        $this->__total_page = ceil($this->__total_record / $this->__limit);
        
        if (!$this->__total_page){
            $this->__total_page = 1;
        }
        
        if ($this->__current_page > $this->__total_page){
            $this->__current_page = $this->__total_page;
        }
        
        $this->__start = ($this->__current_page - 1) * $this->__limit;
    }
    
    private function __link($page){
        if ($page <= 1){
            return $this->__link_first;
        }
        return str_replace('{page}', $page, $this->__link);
    }
    
    function html($range = 7)
    {   
        $p = '';
        if ($this->__total_record > $this->__limit)
        {
            $p = '<div style="margin: 10px; overflow: hidden">
            <ul class="pagerblock" style="float:right; margin-top: 0px">';
               
            $middle = ceil($range / 2);

            if ($this->__total_page < $range){
                $min = 1;
                $max = $this->__total_page;
            }
            else{
                $min = $this->__current_page - $middle + 1;
                $max = $this->__current_page + $middle - 1;

                if ($min < 1){
                    $min = 1;
                    $max = $range;
                }
                else if ($max > $this->__total_page) 
                {
                    $max = $this->__total_page;
                    $min = $this->__total_page - $range + 1;
                }
            }

            if ($this->__current_page > 1)
            {
                $p .= '<li><a href="'.$this->__link($this->__current_page-1).'"><span class="btn_prev">Previous</span></a></li>';
            }
            
            for ($i = $min; $i <= $max; $i++)
            {
                if ($this->__current_page == $i){
                    $p .= '<li><a class="current" href="javascript:void(0)">'.$i.'</a></li>';
                }
                else{
                    $p .= '<li><a href="'.$this->__link($i).'" title="'.$i.'">'.$i.'</a></li>';
                }
            }

            if ($this->__current_page < $this->__total_page)
            {
                $p .= '<li><a href="'.$this->__link($this->__current_page + 1).'"><span class="btn_next">Next</span></a></li>';
            }
            $p .= '</ul></div>';
        }
        return $p;
    }
}

?>