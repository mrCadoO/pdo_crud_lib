<?php
    require_once("class.database.php");

class Database_object extends Database {

    protected static $db_name = 'user';
    protected static $db_fields = ['user_name', 'password'];
    protected static $db_fields_values = [];



    public function fill($arr){
        return static::$db_fields_values = $arr;
    }


    public function save(){
        $sql  = "INSERT INTO ". static::$db_name ." (";
        $sql .= join(", ", static::$db_fields);
        $sql .= ")";
        $sql .= " VALUES (:";
        $sql .= join(", :", static::$db_fields);
        $sql .= ")";
        if(Database::GetInstance()->Execute($sql, $this->AddAttributes(static::$db_fields, static::$db_fields_values))){
            return true;
        } else {
            return false;
        }
    }


    public function update($id=0){
        $att_pairs = [];
        if(count(static::$db_fields) == count(static::$db_fields_values)){
            for($i = 0; $i < count(static::$db_fields); $i++){
                $att_pairs[] = static::$db_fields[$i]."=:".static::$db_fields[$i];
            }
            static::$db_fields_values[] = $id;
            static::$db_fields[] = 'id';
        }
        $sql  = "UPDATE ".static::$db_name." SET ";
        $sql .= join(", ", array_values($att_pairs));
        $sql .= " WHERE id=:id LIMIT 1";
        Database::GetInstance()->Execute($sql, $this->AddAttributes(static::$db_fields, static::$db_fields_values));
        array_pop(static::$db_fields);
        array_pop(static::$db_fields_values);
        return (Database::GetInstance()->rowCount() == 1) ? true : false;
    }


    public function delete($id=0){
        $key = 'id';
        $value = $id;
        $sql  = "DELETE FROM ".static::$db_name;
        $sql .= " WHERE id=:id LIMIT 1";
        Database::GetInstance()->Execute($sql, $this->AddAttributes($key,  $value));
        return (Database::GetInstance()->Rows() == 1) ? true : false;
    }


    public function get($select="*", $where="", $where_value="", $limit=""){
        $sql = "";

        if(is_array($select)){
            $sql .= "SELECT ";
            $sql .= join(", ", $select);
            $sql .= " FROM " .static::$db_name;
        } else {
            $sql .= "SELECT {$select} FROM ".static::$db_name;
        }
        if(!empty($where) && !empty($where_value)){
            $sql .= " WHERE {$where}=:{$where}";
        }
        if(!empty($limit)){
            $sql .= " LIMIT {$limit}";
        }
        if(!empty($where) && !empty($where_value)) {
            $result = Database::GetInstance()->FetchAll($sql,  $this->AddAttributes($where,  $where_value));
        } else {
            $result = Database::GetInstance()->FetchAll($sql);
        }
        return $result;
    }




}