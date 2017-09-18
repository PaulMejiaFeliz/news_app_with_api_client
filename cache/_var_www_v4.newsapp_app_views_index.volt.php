<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <?= $this->tag->gettitle() ?>
    <?= $this->tag->stylesheetlink('/bootstrap/css/bootstrap.css') ?>
    <?= $this->tag->stylesheetlink('/css/site.css') ?>
</head>
<body>
    <nav class='navbar navbar-default'>
        <div class='container-fluid'>
            <div class='navbar-header'>
                <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1' aria-expanded='false'>
                    <span class='sr-only'>Menu</span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
                <a class='navbar-brand' href='/'>News App</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php if (($this->session->has('user'))) { ?>
                <ul class='nav navbar-nav'>
                    <li> <?= $this->tag->linkto('/myNews/addPost', 'New Post') ?> </li>
                    <li> <?= $this->tag->linkto('/myNews', 'My Posts') ?> </li>
                
                </ul>
                <ul class='nav navbar-nav navbar-right'>
                    <?php $user = $this->session->get('user'); ?>
                    <li class='navbar-text'><?= $user['name'] ?> <?= $user['lastName'] ?></li>
                    <li> <?= $this->tag->linkto('/account/logout', 'Logout') ?> </li>
                </ul>
                <?php } else { ?>
                <ul class='nav navbar-nav navbar-right'>                
                    <li> <?= $this->tag->linkto('/account/register', 'Register') ?> </li>
                    <li> <?= $this->tag->linkto('/account/login', 'Login') ?> </li>
                </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class='container'>
        <?= $this->getContent() ?>
    </div>
    <?= $this->tag->javascriptinclude('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', false) ?>
    <?= $this->tag->javascriptinclude('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', false) ?>
    <?= $this->tag->javascriptinclude('/js/site.js') ?>
    <?= $this->tag->javascriptinclude('/js/modals.js') ?>
</body>
</html>