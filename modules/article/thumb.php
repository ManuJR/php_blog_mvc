<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="<?= BASE_FOLDER.$article->getImage() ?>" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title"><?= $article->title ?></h5>
    <p class="card-text"><?= $article->short_text ?></p>
    <a href="<?= BASE_FOLDER ?>/article/<?=$article->id ?>" class="btn btn-primary">Leer más</a>
  </div>
</div>