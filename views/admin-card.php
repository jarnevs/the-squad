<div class="col-4">
    <div class="card">
        <div class="card__image">
            <img src="../assets/images/<?= $squad['image'] ?>" alt="">
        </div>
        <div class="card__title">
            <h3><?= $squad['name'] ?></h3>
        </div>
        <div class="card__synopsis">
            <p><?= $squad['synopsis'] ?></p>
        </div>
        <form action="actions/delete_squad.php" method="POST">
          <input type="hidden" name="squad_id" value="<?= $squad['squad_id'] ?>">
          <input class="form-field__button form-field__button--background button-delete--left button-delete--grey" type="submit" name="delete" id="delete" value="Delete">
        </form>
        <a href="posts.php?squad_id=<?= $squad['squad_id'] ?>" class="button-join button-join--background button-join--big">Enter squad</a>
    </div>
</div>