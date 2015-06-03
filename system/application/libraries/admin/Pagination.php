<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagination
{
    var $current_page = 1;
    var $total_record = 1;
    var $limit      = 10;
    var $start      = 0;
    var $link       = '';
    var $query_string = '';
    var $filter     = array();
    
    private $__total_page = 1;
    
    var $order_by   = '';
    var $order_type = 'desc';
    var $order_string = '';
    
    function getSortLink($display, $field)
    {
        if ($field == $this->order_by)
        {
            if ($this->order_type == 'asc'){
                $href   = '&order_type=desc';
                $class  = 'asc';
            }
            else{
                $href   = '&order_type=asc';
                $class  = 'desc';
            }
        }
        else{
            $href = '&order_type=desc';
            $class = '';
        }
        $href .= '&order_by='.$field.$this->order_string;
        return '<a href="admin.php#'.$this->link.'?page='.$this->current_page . $href.'" class="'.$class.' sort-click" >'.$display.'</a>';
    }
    
    function setCurrentPage($current_page){
        $this->current_page = (int)$current_page;
    }
    
    function setTotalRecord($total_record){
        $this->total_record = (int)$total_record;
    }
    
    function setLimit($limit)
    {
        $this->limit = (int)$limit;
        if ($this->limit > 200){
            $this->limit = 200;
        }
        elseif ($this->limit < 10)
        {
            $this->limit = 10;
        }
    }
    
    function getLimit()
    {
        return $this->limit;
    }
    
    function getStart()
    {
        return $this->start;
    }
    
    function setLink($link)
    {
        $this->link = $link;
    }
    
    function setQuery($filter = array())
    {
        $this->filter = $filter;
    }
    
    function setup()
    {
        $this->__total_page = ceil($this->total_record / $this->limit);
        
        if (!$this->__total_page)
        {
            $this->__total_page = 1;
        }
        
        if ($this->current_page < 1)
        {
            $this->current_page = 1;
        }
        else if ($this->current_page > $this->__total_page)
        {
            $this->current_page = $this->__total_page;
        }
        
        $this->start = ($this->current_page - 1) * $this->limit;
        
        // sort
        if (isset($this->filter['order_by']))
        {
            $this->order_by = $this->filter['order_by'];
        }
        
        if (isset($this->filter['order_type']))
        {
            $this->order_type = $this->filter['order_type'];
        }

        foreach ($this->filter as $key => $val)
        {
            $val = urlencode($val);
            if ($val != '')
            {
                $this->query_string .= '&' . $key . '=' . $val;
            }
            
            if ($key != 'order_by' && $key != 'order_type' && $val)
            {
                $this->order_string .= '&' . $key . '=' . $val;
            }
        }
    }
    
    function __get_link($page)
    {
        return 'admin.php#'.$this->link.'?page='.$page.$this->query_string;
    }
    
    function create($range = 15)
    {   
        $p = '';
        if ($this->total_record > 10)
        {
            $p = '<div class="widget-bottom"><div class="dataTables_paginate paging_full_numbers">';
            
            if ($this->total_record > 10)
            {
                $p .= '<select id="limit">';
                for ($i = 10; $i <= 200; $i+= 10){
                        $p .= '<option value="'.$i.'" '. (($this->limit == $i) ? ' selected="selected" ' : '').' >'.$i.' r/p</option>';
                }
                $p .= '</select> ';
            }
            
            if ($this->__total_page > 1)
            {   
                $middle = ceil($range / 2);

                if ($this->__total_page < $range)
                {
                    $min = 1;
                    $max = $this->__total_page;
                }
                else
                {

                    $min = $this->current_page - $middle + 1;
                    $max = $this->current_page + $middle - 1;

                    if ($min < 1)
                    {
                        $min = 1;
                        $max = $range;
                    }
                    elseif ($max > $this->__total_page) 
                    {
                        $max = $this->__total_page;
                        $min = $this->__total_page - $range + 1;
                    }
                }

                if ($this->current_page > 1)
                {
                    $p .=  '<a class="pagination-click paginate_button" href="'.$this->__get_link('1').'" title="1">First</a>';
                    $p .=  '<a class="pagination-click paginate_button" href="'.$this->__get_link($this->current_page - 1).'" title="'.($this->current_page - 1).'">Previous</a>';
                }
                else
                {
                    $p .=  '<a class="paginate_active" title="1">First</a>';
                    $p .=  '<a class="paginate_active" title="1">Previous</a>';
                }

                $p .= '<span>';

                for ($i = $min; $i <= $max; $i++)
                {
                    if ($this->current_page == $i)
                    {
                        $p .= '<a class="paginate_active" title="'.$i.'">'.$i.'</a>';
                    }
                    else
                    {
                        $p .=  '<a class="pagination-click paginate_button" href="'.$this->__get_link($i).'" title="'.$i.'">'.$i.'</a>';    
                    }
                }

                if ($this->current_page < $this->__total_page)
                {
                    $p .=  '<a class="pagination-click next paginate_button" href="'.$this->__get_link(($this->current_page + 1)).'" title="'.($this->current_page + 1).'">Next</a>';
                    $p .=  '<a class="pagination-click last paginate_button" href="'.$this->__get_link($this->__total_page).'" title="'.$this->__total_page.'">Last</a>';
                }
                else
                {
                    $p .= '<a class="paginate_active" title="'.$this->__total_page.'">Next</a>';
                    $p .= '<a class="paginate_active" title="'.$this->__total_page.'">Last</a>';
                }

                $p .= '</span>';
            }
            $p .= '</div><div class="clear"></div></div>';
        }
        return $p;
    }
}

?>