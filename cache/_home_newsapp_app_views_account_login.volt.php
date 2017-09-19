<div class="row">
    <div class="text-center">
        <h3>Login</h3>
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
        <?= $this->tag->form('/login') ?>
            <div class="form-group input-group">
                <label class="input-group-addon" for="email">E-mail</label>
                <input class="form-control" type="email" name="email" maxlength="30" required value="<?= $email ?>">
            </div>
            <div class="form-group input-group">
                <label class="input-group-addon" for="password">Password</label>
                <input class="form-control" type="password" name="password" required>
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        <?= $this->tag->endForm() ?>
    </div>
</div>
