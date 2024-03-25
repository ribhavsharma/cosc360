<?php 
include __DIR__ . "/../../core/functions.php";

$url = $_GET['url'] ?? 'home';
$url = strtolower($url);
$url = explode('/', $url);

$id = $_GET['id'] ?? 0;

?>


<div class="col-md-6">
    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary-emphasis"><?=esc($row['category'] ?? 'Unknown')?></strong>
            <h3 class="mb-0"><?=$row['title']?></h3>
            <div class="mb-1 text-body-secondary"><?=date("jS M, Y", strtotime($row['date']))?></div>
            <p class="card-text mb-auto"><?=esc(substr($row['content'],0,200))?></p>
            <a href="../pages/post.php?id=<?=$row['id']?>" class="icon-link gap-1 icon-link-hover stretched-link">
                Continue reading ...
                <svg class="bi"><use xlink:href="#chevron-right"/></svg>
            </a>
        </div>
        <div class="col-auto d-none d-lg-block">
            <img class="bd-placeholder-img-100" width="200" height="250" style="object-fit:cover;" src="<?=get_image($row['image'])?>">
        </div>
    </div>
</div> 