<?php $filePath = __DIR__ . '/../../../public/policies/privacy_policy.txt'; ?>

<div class="card w-auto h-100 m-2 rounded-0">
  <div class="card-body">
    <h5 class="card-title mb-3">개인정보취급방침</h5>
    <p class="card-text keep-all fs-xs"><?= nl2br(htmlspecialchars(file_get_contents($filePath))); ?></p>
    <button onclick="window.close()" class="btn btn-light rounded-0 border d-block mx-auto mt-5"><i class="bi bi-x-square me-2"></i>닫기</button>
  </div>
</div>
</body>

</html>