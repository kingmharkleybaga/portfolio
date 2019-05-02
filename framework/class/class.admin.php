<?php

class Admin {
    
    public static function manage_account() {
        
        global $mysql;
        
    }
    
    
    public static function get_colleges() {
        global $mysql;
        
        $table = 'college';
        if( $mysql->select( $table ) ) {
            
            $result = $mysql->arrayedResult;
            
            $rows = $mysql->records;
            
            if($rows > 1) {
                foreach( $result as $res ){
                
                    echo '<option value="'.$res['college_id'].'">'.$res['college_name'].'</option>';
                    
                } 
            } else {
                echo '<option value="'.$result['college_id'].'">'.$result['college_name'].'</option>';
            }
        }
    }
    
    public static function get_departments() {
        global $mysql;
        
        $table = 'department';
        if( $mysql->select( $table ) ) {
            
            $result = $mysql->arrayedResult;
            
            $rows = $mysql->records;
            
            if( $rows > 1 ){
                foreach( $result as $res ){
                
                    echo '<option value="'.$res['department_id'].'">'.$res['department_name'].'</option>';
                    
                } 
            } else {
                echo '<option value="'.$result['department_id'].'">'.$result['department_name'].'</option>';
            }
            
                       
        }
    }
    
    public static function get_courses() {
        global $mysql;
        
        $table = 'courses';
        if( $mysql->select( $table ) ) {
            
            $result = $mysql->arrayedResult;
            
            $rows = $mysql->records;
            
            if( $rows > 1 ){
            
                foreach( $result as $res ){
                    
                    echo '<option value="'.$res['course_id'].'">'.$res['course_name'].'</option>';
                    
                }
            } else {
                echo '<option value="'.$result['course_id'].'">'.$result['course_name'].'</option>';
            }
        }
    }
    
}