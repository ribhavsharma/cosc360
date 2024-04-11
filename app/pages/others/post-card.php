<?php 
include __DIR__ . "/../../core/init.php";

$url = $_GET['url'] ?? 'home';
$url = strtolower($url);
$url = explode('/', $url);

$id = $_GET['id'] ?? 0;

?>

<link rel="stylesheet" href="../../public/assets/css/styles.css"/>

<div class="col-md-6 flex-grow-1 mb-4 p-3 post-card" data-id="<?=$row['id']?>">
    <div class="row g-0 border rounded flex-md-row mb-4 shadow-sm position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary-emphasis"><?=esc($row['category'] ?? 'Unknown')?></strong>
            <h3 class="mb-0"><?=$row['title']?></h3>
            <div class="mb-1 text-body-secondary"><?=date("jS M, Y", strtotime($row['date']))?></div>
            <p class="card-text mb-auto"><?=esc(substr($row['content'],0,200))?></p>
            <div id="post-content-<?=$row['id']?>" class="collapse hide">
                <?=esc(substr($row['content'],200))?>
                <div class="p-3">
                    <a href="../pages/post.php?id=<?=$row['id']?>" class="icon-link gap-1 icon-link-hover">
                        Continue reading ...
                        <svg class="bi"><use xlink:href="#chevron-right"/></svg>
                    </a>
                </div>
            </div>
            <button class="read-more" data-target="#post-content-<?=$row['id']?>">Read More</button>
        </div>
        <div class="col-auto d-none d-lg-block">
            <img class="bd-placeholder-img-100" width="200" height="250" style="object-fit:cover;" src="<?=ROOT?>/../pages/<?=$row['image']?>">
        </div>
    </div>
</div>