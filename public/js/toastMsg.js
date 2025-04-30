// php session msg용 toast
document.addEventListener("DOMContentLoaded", () => {
  const toastEls = document.querySelectorAll("#headerToast .toast");
  toastEls.forEach(el => new bootstrap.Toast(el).show());
})

// js용 toast (주로 값 체크 시 사용)
function toastMsgShow(msg, type = "warning", toastId = "#bodyToast") {
  const removeToast = document.getElementById(toastId);
  if (removeToast) removeToast.remove();

  const toastHTML = `
    <div class="toast-container top-0 end-0 mt-2 me-2 position-fixed" id="bodyToast">
      <div class="toast" role="alert" aria-atomic="true" data-bs-delay="3000">
        <div class="toast-header">
          <i class="bi bi-bell text-${type} me-2"></i>
          <strong class="me-auto">${type.toUpperCase()}!</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          ${msg}
        </div>
      </div>
    </div>
  `;

  document.body.insertAdjacentHTML('beforeend', toastHTML);
  const toastEl = document.querySelector(`${toastId} .toast`);
  new bootstrap.Toast(toastEl).show();
}