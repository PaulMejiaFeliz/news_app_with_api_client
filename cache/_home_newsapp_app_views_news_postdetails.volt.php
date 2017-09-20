<div class='row'>
        <div class='col-md-offset-2 col-md-8'>
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <div class='row'>
                        <div class='col-md-7'>
                            <div class='col-md-12'>
                                <h1><?= $post->title ?></h1>
                                <h5> Views Count: <?= $post->views ?></h5>
                                <?php foreach ($post->photos as $photo) { ?>
                                    <img src ="<?= $imgUrl . $photo->url ?>" class="img-responsive img-thumbnail">
                                <?php } ?>
                            </div>
                        </div>
                        <div class='col-md-5 text-right'>
                            <p>
                                Posted at <?= $post->created_at ?> by
                                <?= $post->users->name . ' ' . $post->users->lastName ?>
                            </p>
                            <p>
                                <?php if ((isset($post->updated_at))) { ?>
                                    Last update at <?= $post->updated_at ?>
                                <?php } ?>
                            </p>
                            <?php if (($this->session->has('user') && $this->session->get('user')['id'] === $post->user_id)) { ?>
                                <a class='btn btn-xs btn-warning' href='/news/edit/<?= $post->id ?>'>Edit Post</a>
                                <button onClick='fillFormDeletePost(<?= $post->id ?>);' type='button' class='btn btn-xs btn-danger' data-toggle='modal' data-target='#deletePostModal'>
                                    Delete Post
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class='panel-body'>
                    <p><?= nl2br($post->content) ?></p>
                </div>
                <div class='panel-footer'>
                    <h3>Comments</h3>
                    <?php if (($this->session->has('user'))) { ?>
                    <form action='/comments/add/<?= $post->id ?>' method='post' class='form-inline'>
                        <input type='hidden' name='postId' value='<?= $post->id ?>'>
                        <div class='input-group'>
                            <span class='input-group-addon'>New Comment</span>
                            <textarea cols='60' rows='3' class='form-control' type='text' name='content' required></textarea>
                        </div>
                        <input type='submit' class='btn btn-primary' value='Publish'>
                    </form>
                    <br/>
                    <?php } ?>
                    <div class='row'>
                        <?php if (isset($page->items) && $this->length($page->items) > 0) { ?>
                            <?php foreach ($page->items as $comment) { ?>
                            <div class='col-md-offset-1 col-md-10'>
                                <div class='panel panel-default'>
                                    <div class='panel-heading'>
                                        <div class='row'>
                                            <div class='col-md-7'>
                                                <h5>
                                                    <?= $comment->users->name . ' ' . $comment->users->lastName ?>
                                                    -
                                                    <?= (isset($comment->updated_at) ? $comment->updated_at : $comment->created_at) ?>
                                                </h5>
                                            </div>
                                            <?php if (($this->session->has('user') && $comment->user_id == $this->session->get('user')['id'])) { ?>
                                            <div class='col-md-5 text-right'>
                                                <div class='col-md-8'>
                                                    <button onClick='fillFormEditComment(<?= $comment->id ?>);' type='button' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#editCommentModal'>Edit</button>
                                                </div>
                                                <div class='col-md-4'>
                                                    <button onClick='fillFormDeleteComment(<?= $comment->id ?>);' type='button' class='btn btn-sm btn-danger' data-toggle='modal' data-target='#deleteCommentModal'>Delete</button>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class='panel-body'>
                                        <div class='col-md-12'>
                                            <p id='commentContent<?= $comment->id ?>'>
                                                <?= nl2br($comment->content) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class='row'>
                                <div class='col-md-10 col-md-offset-1 text-center'>
                                    <?= $this->customTags->pagination($page->last, $page->current) ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <h4 class='text-center'>No Comments</h4>                            
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Comment Modal -->
<div class='modal fade' id='editCommentModal' role='dialog'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title'>Edit Comment</h4>
            </div>
            <form action='/comments/edit' method='post'>
                <div class='modal-body'>
                    <div class='row'>
                        <div class='col col-md-10 col-md-offset-1'>
                            <input type='hidden' name='_method' value='patch'>
                            <input id='editCommentFormCommentId' type='hidden' name='commentId'/>
                            <div class='form-group input-group'>
                                <textarea id='editCommentFormCommentContent' cols='60' rows='4' class='form-control' type='text' name='content' required>
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <div class='col col-md-5'>
                        <input type='submit' class='btn btn-primary' value='Edit'>
                    </div>
                    <div class='col col-md-5 text-right'>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Comment Modal -->
<div class='modal fade' id='deleteCommentModal' role='dialog'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title'>Delete Comment</h4>
            </div>
            <div class='modal-body'>
                <div class='row'>
                    <div class='col col-md-10 col-md-offset-1'>
                        <h3>Do you really want to delete the comment?</h3>
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <div class='row'>
                    <form action='/comments/delete' method='post'>
                        <input name='_method' type='hidden' value='delete'>
                        <input id='deleteCommentFormCommentId' name='commentId' type='hidden'/>
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
