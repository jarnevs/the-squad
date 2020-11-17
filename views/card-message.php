<a href="post-detail.php?squad_id=<?= $post['squad_id'] ?>&post_id=<?= $post['post_id'] ?>" class="card-message">
    <div class="card-message__head">
        <h3><?= $post['title'] ?></h3>
        <p class="card-message__publish-info"><?= $post['user']->username ?? '[USER DELETED]' ?> - <?= $post['created_on'] ?></p>
    </div>
    <?php if ($post['message'] !== null): ?>
    <div class="card-message__content">
        <p><?= $post['message'] ?></p>
    </div>
    <?php endif ?>
    <?php if($post['image'] !== null): ?>
    <div class="card-message__image">
        <img src="assets/images/<?= $post['image'] ?>" alt="">
    </div>
    <?php endif ?>
    <div class="card-message__tags">
    <?php foreach($post['tags'] as $tag): ?>
      <span class="card-message__tag" href="#"><?= $tag['name'] ?></span>
    <?php endforeach ?>                              
    </div>
    <div class="card-message__rating">
        <div class="card-message__likes">
            <i class="fas fa-heart"></i>
            <span><?= $post['likes'] ?></span>
        </div>
        <div class="card-message__comment">
            <i class="fas fa-comment"></i>
            <span><?= $post['comment_count'] ?></span>
        </div>
    </div>
</a>