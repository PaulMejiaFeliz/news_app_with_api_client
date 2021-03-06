<div class='row'>
    <div class='text-center'>
        <h3>Register</h3>
    </div>
</div>
<div class='row'>
    <div class='col col-md-4 col-md-offset-4'>
        <div class='row'>
            <ul>
                <?php if (!empty($errors)) { ?>
                    <?php foreach ($errors as $error) { ?>
                        <li class='text-danger'><?= $error->message ?></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
        <?= $this->tag->form('/account/register') ?>
            <div class='form-group input-group'>
                <span class='input-group-addon'>Name</span>
                <input class='form-control' type='text' name='name' maxlength='100' required value='<?= $name ?>'>
            </div>
            <div class='form-group input-group'>
                <span class='input-group-addon'>Last Name</span>
                <input class='form-control' type='text' name='lastName' maxlength='100' required value='<?= $lastName ?>'>
            </div>
            <div class='form-group input-group'>
                <span class='input-group-addon'>E-mail</span>
                <input class='form-control' type='email' name='email' required  maxlength='30' value='<?= $email ?>'>
            </div>
            <div class='form-group input-group'>
                <span class='input-group-addon'>Password</span>
                <input class='form-control' type='password' name='password' minlength='5' required>
            </div>
            <div class='form-group input-group'>
                <span class='input-group-addon'>Confirm Password</span>
                <input class='form-control' type='password' name='confirmPassword' required>
            </div>
            <div class='text-center'>
                <input type='submit' class='btn btn-primary' value='Register'>
            </div>
        <?= $this->tag->endForm() ?>
    </div>
</div>