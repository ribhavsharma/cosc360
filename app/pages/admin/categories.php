<?php if($action == 'add'):?>
    <div class="col-md-6 mx-auto">
	  <form method="post" enctype="multipart/form-data">

	    <h1 class="h3 mb-3 fw-normal">Create account</h1>

	    <?php if (!empty($errors)):?>
	      <div class="alert alert-danger">Please fix the errors below</div>
	    <?php endif;?>

	    <div class="form-floating">
	      <input value="<?=old_value('category')?>" name="category" type="text" class="form-control mb-2" id="floatingInput" placeholder="Category">
	      <label for="floatingInput">Category</label>
	    </div>
	      <?php if(!empty($errors['category'])):?>
	      <div class="text-danger"><?=$errors['category']?></div>
	      <?php endif;?>

	    <div class="form-floating my-3">
	      <select name="disabled" class="form-select">
	      	<option value="0">Yes</option>
	      	<option value="1">No</option>
	      </select>
	      <label for="floatingInput">Active</label>
	    </div>

	    <a href="<?=ROOT?>/admin/categories">
		    <button class="mt-4 btn btn-lg btn-primary" type="button">Back</button>
		</a>
	    <button class="mt-4 btn btn-lg btn-primary float-end" type="submit">Create</button>
	   
	  </form>
	</div>

<?php elseif($action == 'edit'):?>

    <div class="col-md-6 mx-auto">
	  <form method="post" enctype="multipart/form-data">

	    <h1 class="h3 mb-3 fw-normal">Edit Category</h1>

        <?php if(!empty($row)):?>
            <?php if (!empty($errors)):?>
                <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif;?>

            <div class="form-floating">
                <input value="<?=old_value('category', $row['category'])?>" name="category" type="text" class="form-control mb-2" id="floatingInput" placeholder="Category">
                <label for="floatingInput">Category</label>
            </div>
            <?php if(!empty($errors['category'])):?>
                <div class="text-danger"><?=$errors['category']?></div>
            <?php endif;?>

            <div class="form-floating my-3">
                <select name="disabled" class="form-select">
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>
                <label for="floatingInput">Active</label>
            </div>

            <a href="<?=ROOT?>/admin/categories">
                <button class="mt-4 btn btn-lg btn-primary" type="button">Back</button>
            </a>
            <button class="mt-4 btn btn-lg btn-primary float-end" type="submit">Save</button>
        <?php endif;?>
	  </form>
	</div>
    
<?php elseif($action == 'delete'):?>
    <div class="col-md-6 mx-auto">
	  <form method="post" enctype="multipart/form-data">

	    <h1 class="h3 mb-3 fw-normal">Delete Categories</h1>

        <?php if(!empty($row)):?>
            <?php if (!empty($errors)):?>
                <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif;?>

            <div class="form-floating">
                <div class="form-control mb-2" ><?=old_value('category', $row['category'])?></div>
            </div>
            <?php if(!empty($errors['category'])):?>
                <div class="text-danger"><?=$errors['category']?></div>
            <?php endif;?>

            <div class="form-floating">
                <div class="form-control"><?=old_value('slug', $row['slug'])?></div>
            </div>
            <?php if(!empty($errors['slug'])):?>
                <div class="text-danger"><?=$errors['slug']?></div>
            <?php endif;?>

            <a href="<?=ROOT?>/admin/categories">
                <button class="mt-4 btn btn-lg btn-primary" type="button">Back</button>
            </a>
            <button class="mt-4 btn btn-lg btn-danger float-end" type="submit">Delete</button>
        <?php endif;?>
	  </form>
	</div>
<?php else:?>
    <h3>Categories<a href='<?=ROOT?>/admin/categories/add'><button class="btn btn-primary m-3 ">Add New Category</button></a></h3>
    <div class="table-responsive" >
        <table class="table">

            <tr>
                <th>#</th><th>Category</th><th>Slug</th><th>Disabled</th><th></th>
            </tr>

            <?php
                $limit = 5;
                $offset = ($PAGE['page number'] -1) * $limit;

                $query = "select * from categories order by id desc limit $limit offset $offset";
                $rows = query($query);
            ?>

            <?php if(!empty($rows)):?>
                <?php foreach($rows as $row):?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=esc($row['category'])?></td>
                    <td><?=$row['slug']?></td>
                    <td><?=$row['disabled']?></td>
                    <td>
                        <a href='<?=ROOT?>/admin/categories/edit/<?=$row['id']?>'>
                        <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                        </a>
                        <a href='<?=ROOT?>/admin/categories/delete/<?=$row['id']?>'>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            <?php endif;?>

        </table>

        <div class="col-md-12 mb-4">
            <a href="<?=$PAGE['first page']?>">
                <button class="btn btn-primary mx-3"><i class="bi bi-skip-backward-circle-fill"></i></button>
            </a>
            <a href="<?=$PAGE['prev page']?>">
                <button class="btn btn-primary"><i class="bi bi-box-arrow-left"></i></button>
            </a>
            <a href="<?=$PAGE['next page']?>">
                <button class="btn btn-primary float-end mx-3 "><i class="bi bi-box-arrow-right"></i></button>
            </a>
        </div>
    </div>

<?php endif;?>
