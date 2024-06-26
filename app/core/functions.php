<?php
include __DIR__ . "/connection.php";
include __DIR__ . "/config.php";

if(!function_exists('query')){
    function query(string $query, array $data = []) {

        $string = "mysql:hostname=". DBHOST.";dbname=". DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
    
        $stm = $con->prepare($query);
        $stm->execute($data);
        
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        if(is_array($result) && !empty($result)){
            return $result;
        }
    
        return false;
    }
}

if(!function_exists('create_breadcrumbs')){
    function create_breadcrumbs() {
        $url = $_SERVER["REQUEST_URI"];
        $urlParts = explode('/', trim($url,'/'));

        $breadcrumbs = array();

        $currentPage = array_pop($urlParts);

        // Skip the parts until 'pages'
        while ($urlParts && $urlParts[0] != 'pages') {
            array_shift($urlParts);
        }

        // Remove 'pages' part
        if ($urlParts && $urlParts[0] == 'pages') {
            array_shift($urlParts);
        }

        $url = '';
        foreach ($urlParts as $part) {
            $url .= '/' . $part;
            $breadcrumbs[] = "<a href='$url'>$part</a>";
        }

        // Remove '.php' from the current page
        $currentPage = str_replace('.php', '', $currentPage);
        $breadcrumbs[] = ucfirst($currentPage);
        return implode(' / ', $breadcrumbs);
    }
}

if(!function_exists('queryRow')){
    function queryRow(string $query, array $data = []){
        $string = "mysql:hostname=". DBHOST.";dbname=". DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
    
        $stm = $con->prepare($query);
        $stm->execute($data);
        
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        if(is_array($result) && !empty($result)){
            return $result[0];
        }
    
        return false;
    }
}

if(!function_exists('redirect')){
    function redirect($page){
        header('Location: '.ROOT. '/../pages/' .$page);
        die;
    }
}

if(!function_exists('oldValue')){
    function oldValue($key, $default=''){
        if(!empty($_POST[$key]))
            return $_POST[$key];
    
        return $default;
    }
}

if(!function_exists('authenticate')){
    function authenticate($row){
        $_SESSION['USER'] = $row;
    }
}

if(!function_exists('loggedIn')){
    function loggedIn(){
        if(!empty($_SESSION['USER']))
            return true;
    
        return false;
    }
}

if(!function_exists('esc')){
    function esc($str){
        return htmlspecialchars($str ?? '');
    }
}

if(!function_exists('strToUrl')){
    function strToUrl($url){

        $url = str_replace("'", "", $url);
        $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
        $url = trim($url, "-");
        $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
        $url = strtolower($url);
        $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
        
        return $url;
     }
}

if(!function_exists('get_paginations')){
    function get_paginations(){
        // set pagination variables 
        $page_num = $_GET['page'] ?? 1;
        $page_num = empty($page_num) ? 1 : (int)$page_num;
        $page_num = $page_num < 1 ? 1 : $page_num;
    
        $current = $_GET['url'] ?? 'home';
        $current = ROOT ."/../pages/admin.php/". $current;
        $query_string = "";
    
        foreach($_GET as $key => $value){
            if($key != 'url'){
                $query_string .= "&".$key."=".$value;
            }
        }
    
        if(!strstr($query_string, "page=")){
            $query_string .= "&page=".$page_num;
        }
        $query_string = trim($query_string, "&");
        $current .= "?".$query_string;
    
        // Setting the regular expression to match any string that is encountered 
        // Using .* for more than 1 character 
    
        $current = preg_replace("/page=.*/", "page=".$page_num, $current);
        $first = preg_replace("/page=.*/", "page=1", $current);
        $next = preg_replace("/page=.*/", "page=".($page_num+1), $current);
        $prev_page_num = $page_num < 2 ? 1 : $page_num - 1;
        $prev = preg_replace("/page=.*/", "page=".$prev_page_num, $current);
    
        $result = [
            'current page'	=>$current,
            'next page'		=>$next,
            'prev page'		=>$prev,
            'first page'	=>$first,
            'page number'	=>$page_num
        ];
    
        return $result;
        
    }
}

if(!function_exists('resizeImage')){
    function resizeImage($filename, $maxSize = 1000){
        if(file_exists($filename)){
            $fileType = mime_content_type($filename);
            switch($fileType){
                case "image/jpeg":
                    $image = imagecreatefromjpeg($filename);
                    break;
                case "image/png":
                    $image = imagecreatefrompng($filename);
                    break;
                case "image/webp":
                    $image = imagecreatefromwebp($filename);
                    break;
                case "image/gif":
                    $image = imagecreatefromgif($filename);
                    break;   
                default:
                    return;
                    break;
            }
            $srcWidth = imagesx($image);
            $srcHeight = imagesy($image);
    
            if($srcWidth > $srcHeight){
                if($srcWidth < $maxSize){
                    $maxSize = $srcWidth;
                }
    
                $destinationWidth = $maxSize;
                $destinationHeight = ($srcHeight / $srcWidth) * $maxSize;
            }else{
                if($srcHeight < $maxSize){
                    $maxSize = $srcHeight;
                }
    
                $destinationHeight = $maxSize;
                $destinationWidth = ($srcWidth / $srcHeight) * $maxSize;
            }
    
            $destinationWidth = round($destinationWidth);
            $destinationHeight = round($destinationHeight);
    
            $imageNew = imagecreatetruecolor($destinationWidth, $destinationHeight);
            imagecopyresampled($imageNew, $image, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $srcWidth, $srcHeight);
            
            imagejpeg($imageNew, $filename, 100);
    
        }
    }
}

if(!function_exists('removeImagesFromContent')){
    function removeImagesFromContent($content, $folder = 'uploads/'){

        preg_match_all("/<img[^>]+/", $content, $matches);
    
        if(is_array($matches[0]) && count($matches[0]) > 0){
            foreach ($matches[0] as $img) {
                if(!strstr($img, "data:")){
                    continue;
                }
    
                preg_match('/src="[^"]+/', $img, $match);
                $parts = explode("base64,", $match[0]);
    
                preg_match('/data-filename="[^"]+/', $img, $file_match);
    
                $filename = $folder.str_replace('data-filename="', "", $file_match[0]);
    
                file_put_contents($filename, base64_decode($parts[1]));
                $content = str_replace($match[0], 'src="'.$filename, $content);
            }
        }
        return $content;
    }
}


if(!function_exists('addRootToImage')){
    function addRootToImage($content){
        preg_match_all("/<img[^>]+/", $content, $matches);
    
        if(is_array($matches[0]) && count($matches[0]) > 0)
        {
            foreach ($matches[0] as $img) {
    
                preg_match('/src="[^"]+/', $img, $match);
                $new_img = str_replace('src="', 'src="'.ROOT."/", $img);
                $content = str_replace($img, $new_img, $content);
    
            }
        }
        return $content;
    }
}

if(!function_exists('removeRootFromImage')){
    function removeRootFromImage($content){
        $content = str_replace(ROOT, "", $content);
        return $content;
    }
}

if(!function_exists('user')){
    function user($key = ""){
        if(empty($key))
            return $_SESSION['USER'];
    
        if(!empty($_SESSION['USER'][$key]))
            return $_SESSION['USER'][$key];
    
        return '';
    }
}

if(!function_exists('getImage')){
    function getImage($file){
        $file = $file ?? '';
        if(file_exists($file))
        {
            return ROOT.'/'.$file;
        }
    
        return ROOT.'/assets/images/noImage.png';
    }
}

if(!function_exists('create_tables')){
    function create_tables() {
        $string = "mysql:hostname=". DBHOST . ";";
        $con = new PDO($string, DBUSER, DBPASS);

        $query = "use ". DBNAME;
        $stm = $con->prepare($query);
        $stm->execute();

        // users
        $query = "create table if not exists users(
                id int primary key auto_increment,
                username varchar(50) not null,
                email varchar(100) not null,
                password varchar(255) not null,
                image varchar(1024) null,
                date timestamp default current_timestamp,
                role varchar(10) not null,

                key username (username),
                key email (email)
            
            )";
        $stm = $con->prepare($query);
        $stm->execute();

        // categories
        $query = "create table if not exists categories(
            id int primary key auto_increment,
            category varchar(50) not null,
            slug varchar(100) not null,
            disabled tinyint default 0,

            key slug (slug),
            key category (category)
        
        )";
        $stm = $con->prepare($query);
        $stm->execute();

        // posts 
        $query = "create table if not exists posts(
            id int primary key auto_increment,
            user_id int,
            category_id int,
            title varchar(100) not null,
            content text null,
            image varchar(1024) null,
            date timestamp default current_timestamp,
            slug varchar(100) not null,

            key user_id (user_id),
            key category_id (category_id),
            key title (title),
            key slug (slug),
            key date (date)
        
        )";
        $stm = $con->prepare($query);
        $stm->execute();

        $query = "create table if not exists comments (
            id int primary key auto_increment,
            post_id int,
            user_id int,
            content text not null,
            date timestamp default current_timestamp,
        
            key post_id (post_id),
            key user_id (user_id)
        )";
        $stm = $con->prepare($query);
        $stm->execute();

    }
    create_tables();
}


?>