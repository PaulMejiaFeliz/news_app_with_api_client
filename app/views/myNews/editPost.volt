<div class='row'>
    <div class='row'>
        <div class='text-center'>
            <h3>Edit Post{{ title is not empty ? ' - ' ~ title : '' }}</h3>
        </div>
    </div>
    <div class='row'>
        <div class='col col-md-4 col-md-offset-4'>
            <div class='row'>
                <ul>
                {% if errors is not empty %}
                    {% for error in errors %}
                        <li class='text-danger'>{{ error.message }}</li>
                    {% endfor %}
                {% endif %}
                </ul>
            </div>
            <form action='/myNews/editPost{{ id is not empty ? '?id=' ~ id : '' }}' method='post'>              
                <div class='form-group input-group'>
                    <span class='input-group-addon'>Title</span>
                    <input class='form-control' type='text' name='title' minlength='5' maxlength='100' required value='{{ title }}'>
                </div>
                <div class='form-group input-group'>
                    <span class='input-group-addon'>Content</span>
                    <textarea cols='30' rows='10' class='form-control' type='text' name='content' required>{{ content }}</textarea>
                </div>
                <div class='text-center'>
                    <input type='submit' class='btn btn-primary' value='Edit'>
                </div>
            </form>
        </div>
    </div>
</div>
