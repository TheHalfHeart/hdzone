<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Table
{
    //-----------------------------
    // Thông Tin Table
    protected $_db_conf     = 'default';
    protected $_db_name     = null;
    protected $_tb_name     = null;
    protected $_tb_alias    = null;
    protected $_tb_key      = null;
    protected $_tb_relation = array();
    protected $_tb_rules    = array();
    
    //-----------------------------
    // Thông Tin Truy Vấn Sql
    private $__select   = null;
    private $__having   = null;
    private $__from     = null;
    private $__where    = null;
    private $__logic    = null;
    private $__group_by = null;
    private $__order_by = null;
    private $__limit    = null;
    
    //-----------------------------
    // Thông Tin Lưu Kết Quả
    private $__result   = array();
    private $__row_count= 0;
    private $__error    = array();
    
    //-----------------------------
    // Object Database
    public $db          = null;
    
    //-------------------------------------------------------------------------
    // Hàm Khởi Tạo
    function __construct() 
    {
        $CI = & get_instance();
        if (empty($CI->{$this->_db_conf})){
            $CI->{$this->_db_conf} = $CI->load->database($this->_db_conf, true);
        }
        
        $this->db       = & $CI->{$this->_db_conf};
        $this->_db_name = $this->db->database;
        $this->_tb_name = $this->db->dbprefix.$this->_tb_name;
        $this->__from   = $this->_db_name.'.'.$this->_tb_name.' AS '.$this->_tb_alias;
    }
    
    //-------------------------------------------------------------------------
    // Get các thuộc tính
    public function get_tbalias(){
        return $this->_tb_alias;
    }
    
    public function get_tbkey(){
        return $this->_tb_key;
    }
    
    public function get_tbname(){
        return $this->_tb_name;
    }
    
    public function get_dbname(){
        return $this->_db_name;
    }
    
    //-------------------------------------------------------------------------
    // Đếm Số Lượng Result
    public function get_numrows() {
        return $this->__row_count;
    }
    
    //-------------------------------------------------------------------------
    // Lấy Kết Quả
    public function get_result($index = false) {
        if ($index !== false){
            return isset($this->__result[$index]) ? $this->__result[$index] : false;
        }
        return $this->__result;
    }
    
    //-------------------------------------------------------------------------
    // So Sánh AND
    public function where_and() {
        $this->__where .= ' AND ';
        $this->__logic = '';
        return $this;
    }

    //-------------------------------------------------------------------------
    // So Sánh OR
    public function where_or() {
        $this->__where .= ' OR ';
        $this->__logic = '';
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Mở Ngoặc
    public function begin() 
    {
        $this->__where .= ' '. $this->__logic.' (';
        $this->__logic = '';
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Đóng Ngoặc
    public function end() 
    {
        $this->__where .= ')';
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Tạo Điều Kiện
    private function __set_where($where) 
    {
        $this->__where .= ($this->__where == '' || $this->__where == '(') ? $where : $this->__logic.$where;
        $this->__logic = ' AND ';
    }
    
    //-------------------------------------------------------------------------
    // Chuyển Mảng In Sang Chuỗi In
    private function __get_in($in_val)
    {
        $escaped = null;
        foreach ($in_val as $val){
            $escaped .= ','.$this->db->escape($val);
        }
        return ltrim($escaped, ',');
    }
    
    //-------------------------------------------------------------------------
    // Thiết Lập Select
    public function select($select, $reselect = true) 
    {
        if ($reselect){
            $this->__select = '';
        }
        $select_array = explode(',', $select);
        foreach ($select_array as $selected){
            $this->__select .= empty($this->__select) ? ($this->_tb_alias.'.'.trim($selected)) : (', '.$this->_tb_alias.'.'.trim($selected));
        }
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Thiết Lập Select Cho Object Muốn Join
    public function select_join($relation, $select)
    {
        $select_array = explode(',', $select);
        foreach ($select_array as $selected){
            $this->__select .= (empty($this->__select)) ? ($this->_tb_relation[$relation]['alias'].'.'.trim($selected)) : (', '.$this->_tb_relation[$relation]['alias'].'.'.trim($selected));
        }
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Thiết Lập Where
    public function where($field = '', $value = null, $compare = '=') 
    {
        $this->__set_where(($value === null) ? ($field) : ($this->_tb_alias.'.'.$field.' '.$compare.' '.$this->db->escape($value)));
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Thiết Lập Where Cho Object Join
    public function where_join($relation, $field = '', $value = null, $compare = '=') {
        $this->__set_where((($value === null)) ? $field : $this->_tb_relation[$relation]['alias'].'.'.$field.' '.$compare.' '.$this->db->escape($value));
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Where In
    // $value là một array
    public function where_in($field, $value) {
        $this->__set_where($this->_tb_alias.'.'.$field.' IN ('.$this->__get_in($value).')');
        return $this;
    }

    //-------------------------------------------------------------------------
    // Where In
    // $value là một array
    public function where_in_join($relation, $field, $value) {
        $this->__set_where($this->_tb_relation[$relation]['alias'].'.'.$field.' IN ('.$this->__get_in($value).')');
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Where Not In
    // $value là một array
    public function where_not_in($relation, $field, $in_val) {
        $this->__set_where($this->_tb_alias.'.'.$field.' NOT IN ('.$this->__get_in($in_val).')');
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Where Not In
    // $value là một array
    public function where_not_in_join($relation, $field, $in_val) {
        $this->__set_where($this->_tb_relation[$relation]['alias'].'.'.$this->_tb_alias.'.'.$field.' NOT IN ('.$this->__get_in($in_val).')');
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Like
    public function where_like($field, $value) {
        $this->__set_where($this->_tb_alias.'.'.$field.' LIKE \'%'.$this->db->escape_like_str($value).'%\'');
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Like Join
    public function where_like_join($relation, $field, $value) {
        $this->__set_where($this->_tb_relation[$relation]['alias'].'.'.$field.' LIKE \'%'.$this->db->escape_like_str($value).'%\'');
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Not Like
    public function where_not_like($field, $value) {
        $this->__set_where($this->_tb_alias.'.'.$field.' NOT LIKE \'%'.$this->db->escape_like_str($value).'%\'');
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Not Like Join
    public function where_not_like_join($relation, $field, $value) {
        $this->__set_where($this->_tb_relation[$relation]['alias'].'.'.$field.' NOT LIKE \'%'.$this->db->escape_like_str($value).'%\'');
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Order by
    public function order_by($field, $type) {
        $this->__order_by = $this->_tb_alias.'.'.$field . ' ' . $type;
        return $this;
    }

    //-------------------------------------------------------------------------
    // Order by Join
    public function order_by_join($relation, $field, $type) {
        $this->__order_by = $this->_tb_relation[$relation]['alias'].'.'.$field . ' ' . $type;
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Limit
    public function limit($start, $limit) {
        $this->__limit = $start.','.$limit;
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Join Query
    function join($object, $relation, $type = 'INNER', $condition = '') 
    {
        $this->__join .= $type.' JOIN (';
        $this->__join .= $object->get_sql();
        $this->__join .= ') AS '.$this->_tb_relation[$relation]['alias'];
        $this->__join .= ' ON ';
        if (!empty($condition)){
            $this->__join .= $condition;
        }
        else{
            $this->__join .= $this->_tb_alias.'.'.$this->_tb_relation[$relation]['field'].' = '.$this->_tb_relation[$relation]['alias'].'.'.$object->get_tbkey();
        }
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Execute Query
    public function query($sql, $type = 'array') 
    {
        if (strpos(trim($sql), 'SELECT') === 0)
        {
            $query = $this->db->query($sql);
            $this->__row_count = $query->num_rows();
            if ($type == 'array'){
                $this->__result = $query->result_array();
            }
            else{
                $this->__result = $query->result();
            }
            $query->free_result();
        } 
        else {
            $this->db->simple_query($sql);
        }
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Execute Query
    public function execute($type = 'array') 
    {
        $this->query($this->get_sql(), $type);
        return $this;
    }
    
    //-------------------------------------------------------------------------
    // Get Sql Query
    public function get_sql()
    {
        $sql = 'SELECT '.((empty($this->__select)) ? '*' : $this->__select);
        $sql .= ' FROM '.$this->__from;
        if (!empty($this->__join)){
            $sql .= ' '.$this->__join;
        }
        if (!empty($this->__where)){
            $sql .= ' WHERE '.$this->__where;
        }
        if (!empty($this->__group_by)){
            $sql .= ' GROUP BY '.$this->__group_by;
        }
        if (!empty($this->__having)){
            $sql .= ' HAVING '.$this->__having;
        }
        if (!empty($this->__order_by)){
            $sql .= ' ORDER BY '.$this->__order_by;
        }
        if (!empty($this->__limit)){
            $sql .= ' LIMIT '.$this->__limit;
        }
        return $sql;
    }
    
    //-------------------------------------------------------------------------
    // Count Result
    public function count() 
    {
        $this->__select = 'COUNT('.$this->_tb_key.') as numrows';    
        $query = $this->db->query($this->get_sql());
        $row = $query->row_array();
        return (empty($row['numrows'])) ? 0 : $row['numrows'];
    }
    
    //-------------------------------------------------------------------------
    // Get Last Query
    public function last_query() {
        return $this->db->last_query();
    }
    
    //-------------------------------------------------------------------------
    // Insert Data
    public function insert($data = array()) {
        if ($this->db->insert($this->_db_name.'.'.$this->_tb_name, $data)){
                return $this->db->insert_id();
        }
        return false;
    }
    
    //-------------------------------------------------------------------------
    // Delete
    public function delete($where, $get_info = false) 
    {
        if ($get_info) {
            $this->where($where);
            $this->execute();
        }
        
        $this->db->where($where);
        return $this->db->delete($this->_db_name.'.'.$this->_tb_name);
    }
    
    //-------------------------------------------------------------------------
    // Update
    public function update($data = array()) {
        $this->db->where($this->__where);
        return $this->db->update($this->_tb_name.' AS '.$this->_tb_alias , $data);
    }
    
    //-------------------------------------------------------------------------
    // Validate
    public function validate(&$data, $type = 'insert') 
    {
        $CI = & get_instance();
        $CI->load->helper('validate');
        $flag = true;
        foreach ($data as $field => & $value)
        {
            $value = $value;
            if (isset($this->_tb_rules[$field]))
            {
                foreach ($this->_tb_rules[$field] as $rule => $vars)
                {
                    if (!isset($vars['input'])){
                        $vars['input'] = array();
                    }
                    $vars['input'][] = $value;
                    if ($rule == 'is_required'){
                        if ($value === ''){
                            $this->add_error($field, $vars['error']);
                            $flag = false; break;
                        }
                    }
                    else if ($value !== '' && $rule == 'is_unique')
                    {
                        $unique = new $this;
                        if ($type == 'insert') {
                            if ($unique->where($field, $value)->count() > 0) {
                                $this->add_error($field, $vars['error']);
                                $flag = false; break;
                            }
                        }
                        else 
                        {
                            $unique->where($this->__where)->select($this->_tb_key)->execute();
                            if ($unique->get_numrows() > 0)
                            {
                                $result = $unique->get_result(0);
                                if ($unique->clear()->where($field, $value)->where($this->_tb_key, $result[$this->_tb_key], ' <> ')->count() > 0){
                                    $this->add_error($field, $vars['error']);
                                    $flag = false; break;
                                }
                            }
                        }
                    }
                    else if($value !== '' && !call_user_func_array ($rule, $vars['input'])) {
                         $this->add_error($field, $vars['error']);
                         $flag = false; break;
                    } 
                }
            }
        }
        return $flag;
    }
    
    //-------------------------------------------------------------------------
    // Clear Ìnfo
    public function clear() {
        $this->__select = '';
        $this->__where = '';
        $this->__order_by = '';
        $this->__group_by = '';
        $this->__limit = '';
        $this->__row_count = 0;
        $this->__error = array();
        $this->__having = '';
        $this->__result = array();
        return $this;
    }
    
    public function clear_select(){
        $this->__select = '';
        return $this;
    }
    
    
    //-------------------------------------------------------------------------
    // Add Error
    public function add_error($field, $value) {
        $this->__error[$field] = $value;
    }
    
    //-------------------------------------------------------------------------
    // Get Error
    public function get_error() {
        return $this->__error;
    }
}
?>
