<script type="application/javascript">
    confirmDelete = () => {
        if (confirm('Möchten Sie wirklich den Post löschen?')) {
            window.location.href = "/post/delete/?id=<?= $post->id ?>";
        } else return
    }
    confirmCommentDelete = (comment_id) => {
        if (confirm('Möchten Sie wirklich den Kommentar löschen?')) {
            window.location.href = `/post/delete_comment/?id=${comment_id}`;
        } else return
    }
</script>

<article class="mb-5">
    <div class="row">
        <div class="col-12 col-sm-8">
            <h1 class="h5"><?= $post->title ?></h1>
            <hr>
            <p><?= $post->text ?></p>
            <p>
                <a href="/post/user_posts/?user_id=<?= $user->id ?>"><strong><?= $user->first_name . " " . $user->last_name ?></strong></a><br>
                <?php
                // Zeitformat umwandeln
                $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $post->created_at);
                $created_at = date_format($created_at, 'd.m.Y H:i');
                ?>
                <i><?= $created_at ?></i></p>
            <?php if ($is_post_owner): ?>
                <div class="btn-group">
                    <a class="btn btn-sm btn-outline-warning" href="/post/edit/?id=<?= $post->id ?>">Editieren </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete()">Löschen</button>
                </div>
                <hr>
            <?php endif; ?>
        </div>
        <div class="col-4 d-none d-sm-block">
            <div class="card w-100 bg-light">
                <div class="card-header">
                    Ähnliche Posts
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    foreach ($similar_posts as $similar_post): ?>
                        <!-- Temporär wird statische posts verwendet
                             TODO: Get posts by similar tags (!not implemented yet)-->
                        <li class="list-group-item"><a
                                    href="/post/details/?id=<?= $similar_post->id ?>"><?= $similar_post->title; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-8">
            <h2 class="h4">Kommentare</h2>
            <hr>
            <?php if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['userid'])): ?>
                <form class="w-100 mb-3" action="/post/doCreateComment" method="post">
                    <textarea id="kommentar-text" name="text" rows="3" class="form-control" required></textarea>
                    <input type="hidden" name="post_id" value="<?= $post->id ?>">
                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary">Kommentieren</button>
                    </div>
                </form>
            <?php endif; ?>
            <?php
            foreach ($comments as $comment):?>
                <?php
                // Zeitformat umwandeln
                $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at);
                $created_at = date_format($created_at, 'd.m.Y H:i');

                // Name von Author des Kommentars evaluieren
                $comment_user_id = $comment->user_id;
                $userRepository = new \App\Repository\UserRepository();
                $full_name = $userRepository->readById($comment_user_id)->first_name . " " . $userRepository->readById($comment_user_id)->last_name;
                ?>
                <p><?= $comment->text ?></p>
                <div class="d-flex align-items-center justify-content-between">
                    <p class="m-0"><?= "<strong>$full_name</strong> <i>$created_at</i>" ?></p>


                    <?php

                    // Prüfe ob den Benutzer der Kommentarautor ist.
                    $is_comment_owner = false;
                    if (isset($_SESSION['isLoggedIn']) && !empty($_SESSION['isLoggedIn'])) {
                        if ($_SESSION['userid'] == $comment->user_id) {
                            $is_comment_owner = true;
                        }
                    }
                    ?>
                    <div class="btn-group">
                    <?php
                    if ($is_comment_owner): ?>
                        <a class="btn btn-sm btn-outline-warning" href="/post/editComment/?comment_id=<?= $comment->id ?>&post_id=<?= $post->id ?>">Editieren </a>
                        <!--<button class="btn btn-sm btn-outline-warning">Editieren</button>-->
                        <button class="btn btn-sm btn-outline-danger" onclick="confirmCommentDelete(<?= $comment->id ?>)">Löschen</button>
                    <?php endif; ?>
                        <button class="btn btn-sm btn-outline-secondary">Antworten</button>
                    </div>

                </div>
                <?php
                $replyRepository = new \App\Repository\ReplyRepository();
                $replies = $replyRepository->getAllRepliesForCommentID($comment->id);
                ?>
                <?php if (count($replies) == 0): ?>
                    <hr>

                <?php endif; ?>
                <div>

                    <?php foreach ($replies as $reply): ?>
                        <?php
                        // Zeitformat umwandeln
                        $reply_created_at = DateTime::createFromFormat('Y-m-d H:i:s', $reply->created_at);
                        $reply_created_at = date_format($reply_created_at, 'd.m.Y H:i');

                        // Name von Author des Kommentars evaluieren
                        $reply_user_id = $reply->user_id;
                        $reply_user_name = $userRepository->readById($reply_user_id)->first_name . " " . $userRepository->readById($reply_user_id)->last_name;
                        ?>
                        <div class="reply pl-2 ml-5">
                            <p><?= $reply->text ?></p>
                            <p><?= "<strong>$reply_user_name</strong> <i>$reply_created_at</i>" ?></p>
                            <hr style="border: 1px dashed rgba(0,0,0,0.5)">
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endforeach; ?>

        </div>
    </div>
</article>


