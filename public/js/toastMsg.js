// php session msg용 toast
document.addEventListener("DOMContentLoaded", () => {
  const toastEls = document.querySelectorAll("#headerToast .toast");
  toastEls.forEach(el => new bootstrap.Toast(el).show());
})

// js용 toast (주로 값 체크 시 사용)
function toastMsgShow(toastId = "#bodyToast") { 
  const toastEls = document.querySelectorAll(`${toastId} .toast`);
  toastEls.forEach(el => new bootstrap.Toast(el).show());
}