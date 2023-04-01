<?php
require_once 'config.php';

$sth = $pdo->prepare("SELECT * FROM `comments` ORDER BY id DESC");
$sth->execute();

echo '<div class="comments">';
while($row  = $sth->fetch()){

    echo '<hr /><div class="comment">';

    // First block for photo
    echo '<div class="photo">';
    if ($row['photo']) {
        echo '<img src="img/' . $row['photo'] . '" alt="user photo">';
    }
    echo '</div>';

    // Second block for name, rating and comment
    echo '<div class="info">';
    echo '<div class="date">' . $row['date_created'] . '</div>';
    echo '<div class="name">Заказчик: ' . $row['name'] . '</div>';
    echo '<div class="rating">Моя оценка: ' . $row['rating'] .'</div>';
    echo '<div class="comment-text">Отзыв о Команде Патриот Строй: ' . $row['comment'] .'</div>';
    echo '</div>';

    echo '</div>';

    $counter++;
    if ($counter % 3 == 0) {
        echo '<br><br>';
    }
}
echo '</div>';
?>
<style>
    <style>
    .comments {
        font-family: OpenSansRegular;
        line-height: 1.5;
        display: flex;
        flex-wrap: wrap;
    }

    .comment {
        display: flex;
        flex-wrap: wrap;
        margin: 20px 0;
        width: 100%;
    }

    .photo {
        flex-basis: 300px;
        margin-right: 20px;
        max-width: 100%;
    }

    .photo img {
        max-width: 100%;
        height: auto;
    }

    .info {
        flex-basis: calc(100% - 320px);
        max-width: 100%;
    }

    .date, .name, .rating, .comment-text {
        margin-bottom: 10px;
        width: 100%;
    }

    .date::before {
        content: "";
        font-weight: bold;
    }

    .name::before {
        content: "Заказчик: ";
        font-weight: bold;
    }

    .rating::before {
        content: "Моя оценка: ";
        font-weight: bold;
    }

    .comment-text::before {
        content: "Отзыв о Команде Патриот Строй: ";
        font-weight: bold;
    }

    @media only screen and (max-width: 991px) {
        .photo {
            margin-right: 0;
            margin-bottom: 10px;
            flex-basis: 100%;
        }

        .info {
            flex-basis: 100%;
        }
    }

    @media only screen and (max-width: 767px) {
        .comment {
            flex-direction: column;
        }

        .photo {
            order: 1;
            margin-right: 0;
            margin-bottom: 10px;
            max-width: 100%;
        }

        .info {
            order: 2;
            flex-basis: 100%;
        }
    }
</style>

</style>
<div id="comments-container">
    <?php
        $comments = get_comments(0, 5); // Получаем первые 5 комментариев
        foreach ($comments as $comment) {
            echo '<div class="comment">';
            echo '<p><strong>' . $comment['name'] . '</strong></p>';
            echo '<p>' . $comment['message'] . '</p>';
            echo '</div>';
        }
    ?>
</div>
<button id="load-more-comments">Больше комментариев</button>
