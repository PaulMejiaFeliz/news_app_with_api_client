<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{ getTitle() }}
    {{ stylesheetLink('/bootstrap/css/bootstrap.css') }}
    {{ stylesheetLink('/css/site.css') }}
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">News App</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                {% if (session.has('user')) %}
                <ul class="nav navbar-nav">
                    <li> {{ linkTo('/news/add', 'New Post') }} </li>
                    <li> {{ linkTo('/myNews', 'My Posts') }} </li>
                
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    {% set user = session.get('user') %}
                    <li class='navbar-text'>{{user['name']}} {{user['lastName']}}</li>
                    <li> {{ linkTo('/logout', 'Logout') }} </li>
                </ul>
                {% else %}
                <ul class="nav navbar-nav navbar-right">                
                    <li> {{ linkTo('/register', 'Register') }} </li>
                    <li> {{ linkTo('/login', 'Login') }} </li>
                </ul>
                {% endif %}
            </div>
        </div>
    </nav>
    <div class="container">
        {{ content() }}
    </div>
    {{ javascriptInclude('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', false) }}
    {{ javascriptInclude('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', false) }}
    {{ javascriptInclude('/js/site.js') }}
    {{ javascriptInclude('/js/modals.js') }}
</body>
</html>