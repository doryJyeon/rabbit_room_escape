  <article class="container py-3 my-5">
    <?php foreach ($data as $key => $value) : ?>
      <div class="accordion mb-3" id="accordion<?= $key ?>">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key ?>" aria-controls="collapse<?= $key ?>">
              <?= $value[0] ?>
            </button>
          </h2>
          <div id="collapse<?= $key ?>" class="accordion-collapse collapse">
            <div class="accordion-body">
              <?= nl2br(htmlspecialchars($value[1])) ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </article>