  <!-- server toast message -->
  <?php echo \App\Helpers\ToastMsg::getToastMsg(); ?>

  <main class="form-signin w-100 vh-100 m-auto py-3 px-3 d-flex flex-column justify-content-center align-items-center">
    <div class="text-center">
      <img class="mb-4" src="/images/logo.png" alt="logo" width="60" />
      <h4 class="h3 mb-3 text-primary">Sign in</h4>
    </div>

    <form class="mw-400" action="/admin/auth" method="POST">
      <input type="text" class="form-control mb-2" name="login_id" placeholder="ID" required />
      <input type="password" class="form-control" name="password" placeholder="Password" required />

      <div class="form-check text-start my-3">
        <input class="form-check-input" type="checkbox" value="remember" id="checkRemember">
        <label class="form-check-label" for="checkRemember">
          자동 로그인
        </label>
      </div>
      <button class="btn btn-primary w-100 py-2" type="submit" onclick="checkValues()">로그인</button>
    </form>
  </main>

  <script>
    // 값 체크해서 submit
    function checkValues() {
      // 빈 값 체크
      const inputs = document.querySelectorAll('input[required]');
      for (const input of inputs) {
        if (!input.value.trim()) {
          // JS toast message
          toastMsgShow("ID, Password를 모두 입력해주세요.");
          return;
        }
      }

      document.querySelector('form').submit();
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  </body>

  </html>