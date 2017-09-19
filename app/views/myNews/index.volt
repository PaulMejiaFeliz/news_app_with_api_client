<div class='row'>
    <div class='col-md-offset-1'>
        <h1>My News</h1>
    </div>
    <div class='row'>
        <div class='col-md-10 col-md-offset-1'>
            <form action='/myNews' method='get' class='form-inline'>
                <div class='form-group input-group'>
                    <span class='input-group-addon'>Search By</span>
                    <select name='search' class='form-control' required >
                        {% for field in searchFields|keys %}
                            <option value='{{ field }}' {{ searchField == field ? "selected='selected'" : '' }} >{{ searchFields[field] }}</option>
                        {% endfor %}
                    </select>
                </div>
                <div class='form-group input-group'>
                    <span class='input-group-addon'>Value</span>
                    <input class='form-control' type='text' name='value' required value='{{ searchValue }}'>
                </div>
                <input class='btn btn-primary' type='submit' value='Search'/>
                <a class='btn btn-default' href='/myNews'>Clear</a>
            </form>
        </div>
    </div>
    </br>
    <div class='row'>
        <div class='col-md-10 col-md-offset-1'>
            {% if page.items is defined and page.items|length > 0  %}
                <table class='table'>
                    <thead>
                        <tr>
                            <th>
                                {{ customTags.orderByAnchor('Title', 'title') }} 
                            </th>
                            <th>Author</th>
                            <th>
                                {{ customTags.orderByAnchor('Posted Date', 'created_at') }}
                            </th>
                            <th>
                                {{ customTags.orderByAnchor('Views Count', 'views') }}
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for news in page.items %}
                        <tr class='clickable-row' data-href='/news/detail/{{ news.id }}'>
                            <td>{{ news.title }}</td>
                            <td>{{ news.users.name ~ ' ' ~ news.users.lastName }}</td>
                            <td>{{ news.created_at }}</td>
                            <td>{{ news.views }}</td>
                            <td class='action-cell'>
                                <a class='btn btn-xs btn-warning' href='/news/edit/{{ news.id }}'>Edit Post</a>
                                <button onClick='fillFormDeletePost({{ news.id }});' type='button' class='btn btn-xs btn-danger' data-toggle='modal' data-target='#deletePostModal'>Delete Post</button>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                <div class='row'>
                    <div class='col-md-10 col-md-offset-1 text-center'>
                        {{ customTags.pagination(page.last, page.current) }}
                    </div>
                </div>              
            {% else %}
                <h3>No news to show you rigth now.</h3>
            {% endif %}
        </div>
    </div>
</div>

<!-- Delete Post Modal -->
<div class='modal fade' id='deletePostModal' role='dialog'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title'>Delete Post</h4>
            </div>
            <div class='modal-body'>
                <div class='row'>
                    <div class='col col-md-10 col-md-offset-1'>
                        <h3>Do you really want to delete the Post?</h3>
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <div class='row'>
                    <form action='/news/delete' method='post'>
                        <input name='_method' type='hidden' value='delete'>
                        <input id='deletePostFormPostId' name='PostId' type='hidden'/>
                        <div class='col col-md-5'>
                            <input class='btn btn-danger' type='submit' value='Confirm Delete'/>
                        </div>
                    </form>
                    <div class='col col-md-5 text-right'>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>