<div class="row">
    <div class="text-center">
        <h3>New Post</h3>
    </div>
</div>
<div class="row">
    <div class="col col-md-4 col-md-offset-4">
        <div class="row">
            <ul>
                <?php if (!empty($errors)) { ?>
                    <?php foreach ($errors as $error) { ?>
                        <li class="text-danger"><?= $error->message ?></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
        <form action="/news/add" method="post" enctype="multipart/form-data">
            <div class="form-group input-group">
                <span class="input-group-addon">Title</span>
                <input class="form-control" type="text" name="title"  minlength="5" maxlength="100" required value="<?= $title ?>">
            </div>
            <div class="form-group input-group">
                <span class="input-group-addon">Content</span>
                <textarea cols="30" rows="10" class="form-control" type="text" name="content" required><?= $content ?></textarea>
            </div>
            <div class="form-group input-group">
                <span class="input-group-addon">Photo</span>
                <input class="form-control" type="file" name="photo" multiple accept="image/jpeg,image/png,image/bmp">
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Post">
            </div>
        </form>
    </div>
</div>
