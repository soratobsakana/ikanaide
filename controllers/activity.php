<?php // Submits replies, likes a post and shows an activity page at /activity/{post_id}

namespace App;

// Si el usuario ha escrito una respuesta a un post, se añade a la base de datos mediante el siguiente bloque:
if (isset($_POST['submit-reply']) && User::validateSession()) {
    // Comprobación de que los campos del formulario no han sido alterados por el usuario.
    $fields = ['post-reply', 'submit-reply'];
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $fields)) {
            header('Location: /404');
            die();
        }
    }

        $submitPost['content'] = $_POST['post-reply'];
        $submitPost['user_id'] = $_COOKIE['user_id'];
        $relation = Activity::getRelation($postId);
        if (!empty($_POST['post-reply']) && Activity::post($submitPost)) {
            // Consigo el ID del último post introducido
            $postReplyId = DB::insertedId();
            if (isset($relation)) {
                Activity::setPostRelation($relation['medium'], $postReplyId, $_COOKIE['user_id'], $relation['medium_id']);
            }
            Activity::postReply($postId, $postReplyId);
            header('Location: '. $page); // $page is declared at /routes/web.php.
            die();
        }
}

if (isset($_POST['like-post']) && User::validateSession()) {
    // Comprobación de que los campos del formulario no han sido alterados por el usuario.
    $fields = ['like-replay'];
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $fields)) {
            header('Location: /404');
            die();
        }
    }

    $likePost['post_id'] = $postId;
    $likePost['user_id'] = $_COOKIE['user_id'];
    if (Activity::like($likePost)) {
        header('Location: '. $page); // $page is declared at /routes/web.php.
        die();
    }
}

if (Activity::exists($postId) && User::validateSession()) {
    // $post contendrá la información de los posts a mostrar.
    $repliedPost = Activity::getRepliedPost($postId);
    $post = Activity::getPost($postId);
    $replies = Activity::getPostReplies($postId);

    // $loggedUser contendrá la información del usuario logeado, que se utilizará en caso de que interactue con los posts mostrados.
    $loggedUser = User::getInfoLess($_COOKIE['user_id']);

    require view('activity/activity.view.php');
}