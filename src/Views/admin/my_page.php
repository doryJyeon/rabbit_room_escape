<div class="container">
  <strong class="fs-5 text-primary mb-4 row col-12">비밀번호 변경</strong>
  <?php if ($checkPw === true) : ?>
    <form action="/admin/my_page" method="POST" class="row g-3">
      <input type="hidden" name="_method" value="PATCH" />
      <div class="col-12">
        <label class="mb-1">현재 비밀번호</label>
        <input type="password" name="password" class="form-control mw-300 mb-2" placeholder="Password" required />
        <label class="mb-1">신규 비밀번호</label>
        <input type="password" name="newPw" class="form-control mw-300 mb-2" placeholder="Password" required />
        <label class="mb-1">신규 비밀번호 확인</label>
        <input type="password" name="newPw2" class="form-control mw-300 mb-2" placeholder="Password" required />
        <button type="submit" class="btn btn-primary w-auto mt-4">확인</button>
      </div>
    </form>
  <?php else : ?>
    <form action="/admin/my_page" method="POST" class="row g-3">
      <input type="hidden" name="_method" value="GET" />
      <div class="col-12">
        <label class="mb-1">비밀번호</label>
        <input type="password" name="password" class="form-control mw-300" placeholder="Password" required />
        <button type="submit" class="btn btn-primary w-auto mt-4">확인</button>
      </div>
    </form>
  <?php endif; ?>
</div>