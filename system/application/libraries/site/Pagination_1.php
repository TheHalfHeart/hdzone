<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagination
{
    private $__current_page = 1;
    private $__total_record = 1;
    private $__limit = 10;
    private $__start = 0;
    private $__link = '';
    private $__total_page = 1;
    
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
        return str_replace('{page}', $page, $this->__link);
    }
    
    function html($range = 9)
    {   
        $p = '';
        if ($this->__total_record > $this->__limit)
        {
            $p = '<div class="pagination">';
               
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
                $p .=  '<a title="Start" href="'.$this->__link('1').'"><<</a>';
                $p .=  '<a title="Prev" href="'.$this->__link($this->__current_page - 1).'"><</a>';
            }
            else
            {
                $p .=  '<span><<</span>';
                $p .=  '<span><</span>';
            }
            
            for ($i = $min; $i <= $max; $i++)
            {
                if ($this->__current_page == $i){
                    $p .= '<span>'.$i.'</span>';
                }
                else{
                    $p .= '<a title="" href="'.$this->__link($i).'">'.$i.'</a>';
                }
            }

            if ($this->__current_page < $this->__total_page)
            {
                $p .=  '<a title="Next" href="'.$this->__link($this->__current_page + 1).'">></a>';
                $p .=  '<a title="End" href="'.$this->__link($this->__total_page).'">>></a>';
            }
            else
            {
                $p .=  '<span>></span>';
                $p .=  '<span>>></span>';
            }
            $p .= '</div>';
        }
        return $p;
    }
}

?>