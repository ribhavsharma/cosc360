<?php 

if($action == 'add'){ // add new user 
    if(!empty($_POST)){ 
        $errors = [];

        if(empty($_POST['category'])){
            $errors['category'] = "A category must be provided";
        }else if(!preg_match("/^[a-zA-Z0-9 \-\_\&\[\]]+$/", $_POST['category'])){
            $errors['category'] = "Category cannot have a special character that you provided";
        }

        $slug = str_to_url($_POST['category']);

        $query = "select id from categories where slug = :slug limit 1";
        $slug_row = query($query, ['slug' => $slug]);

        if($slug_row){
            $slug .= rand(1000,9999);
        }

        if(empty($errors)){
            //save to database
            $data = [];
            $data['category'] = $_POST['category'];
            $data['disabled'] = $_POST['disabled'];
            $data['slug'] = $slug;

            $query = "insert into categories (category,slug,disabled) values (:category,:slug,:disabled)";

            query($query, $data);
            redirect('./admin/categories');
        }
    }
}else if($action == 'edit'){ // editing existing user
    $query = "select * from categories where id = :id limit 1";
    $row = query_row($query, ['id' => $id]);
    if(!empty($_POST)){
        $errors = [];

        if($row){
            if(empty($_POST['category'])){
                $errors['category'] = "A category must be provided";
            }else if(!preg_match("/^[a-zA-Z0-9 \-\_\&\[\]]+$/", $_POST['category'])){
                $errors['category'] = "Category cannot have a special character that you provided";
            }
    
            if(empty($errors)){
                //save to database
                $data = [];
                $data['category'] = $_POST['category'];
                $data['disabled'] = $_POST['disabled'];
                $data['id'] = $id;

                $query = "update categories set category = :category, disabled = :disabled where id = :id limit 1";

                query($query, $data);
                    redirect('./admin/categories');
            }
        }
    }      
}else if($action == 'delete'){ // editing existing user
    $query = "select * from categories where id = :id limit 1";
    $row = query_row($query, ['id' => $id]);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $errors = [];

        if($row){

            if(empty($errors)){
                //delete from database
                $data = [];
                $data['id'] = $id;

                $query = "delete from categories where id = :id limit 1";
                query($query, $data);
                
                redirect('./admin/categories');
            }
        }
    }      
}

?>