<script type="application/javascript">
    confirmDelete = () => {
        if (confirm('Möchten Sie wirklich den Post löschen?')) {
            window.location.href = "/post/delete/?id=<?= $post->id ?>";
        } else return
    }
</script>

<article class="mb-5">
    <div class="row">
        <div class="col-12 col-sm-8">
            <h1 class="h5"><?= $post->title ?></h1>
            <hr>
            <p><?= $post->text ?></p>
            <p><a href="/post/user_posts/?user_id=<?= $user->id?>"><strong><?= $user->first_name . " " . $user->last_name ?></strong></a><br>
                <?php
                // Zeitformat umwandeln
                $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $post->created_at);
                $created_at = date_format($created_at, 'd.m.Y H:i');
                ?>
                <i><?= $created_at ?></i></p>
            <?php if ($is_post_owner): ?>
                <div class="btn-group">
                    <a href="/post/edit/?id=<?= $post->id ?>"><button class="btn btn-warning">Editieren</button></a>
                    <button class="btn btn-danger" onclick="confirmDelete()">Löschen</button>
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
            <?php
            foreach ($comments as $comment):?>
                <?php
                // Zeitformat umwandeln
                $created_at = DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at);
                $created_at = date_format($created_at, 'd.m.Y H:i');

                // Name von Author des Kommentars evaluieren
                $comment_user_id = $comment->user_id;
                $userRepository = new \App\Repository\UserRepository();
                $user_name = $userRepository->readById($comment_user_id)->username;

                ?>
                <p><?=$comment->text ?></p>
                <p><?=$user_name.'<i>'.$created_at.'</i>'?> </p>
                <?php

                $replyRepository = new \App\Repository\ReplyRepository();
                $replies = $replyRepository->getAllRepliesForCommentID($comment->id);
                ?>
                <?php if (count($replies) == 0): ?>
                <hr class="noReply">
                <?php endif; ?>
                <div>



                    <?php foreach ($replies as $reply):?>
                        <?php
                        // Zeitformat umwandeln
                        $reply_created_at = DateTime::createFromFormat('Y-m-d H:i:s', $reply->created_at);
                        $reply_created_at = date_format($reply_created_at, 'd.m.Y H:i');

                        // Name von Author des Kommentars evaluieren
                        $reply_user_id = $reply->user_id;
                        $reply_user_name = $userRepository->readById($reply_user_id)->username;

                        ?>
                        <div class="pl-5 bl-1">
                            <p><?= $reply->text ?></p>
                            <p><?php echo "$reply_user_name <i>$reply_created_at</i>"?></p>
                            <hr style="border: 1px dashed rgba(0,0,0,.1)">
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endforeach; ?>

        </div>
    </div>
</article>


