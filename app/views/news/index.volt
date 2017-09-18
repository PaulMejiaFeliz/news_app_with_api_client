<div class='row'>
    <div class='col-md-offset-1'>
        <h1>News</h1>
    </div>
    <div class='row'>
        <div class='col-md-10 col-md-offset-1'>
            <form action='/' method='get' class='form-inline'>
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
                <a class='btn btn-default' href='/'>Clear</a>
            </form>
        </div>
    </div>
    </br>
    <div class='row'>
        <div class='col-md-10 col-md-offset-1'>
            {% if page.items is defined and page.items|length > 0 %}
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
                        </tr>
                    </thead>
                    <tbody>
                        {% for news in page.items %}
                        <tr class='clickable-row' data-href='/news/postDetails/{{ news.id }}'>
                            <td>{{ news.title }}</td>
                            <td>{{ news.users.name }} {{ news.users.lastName }}</td>
                            <td>{{ news.created_at }}</td>
                            <td>{{ news.views }}</td>
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
                <div class='col-md-offset-1'>
                    <h3>No news to show you rigth now.</h3>
                </div>
            {% endif %}
        </div>
    </div>
</div>

