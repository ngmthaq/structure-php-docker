function showAlert(message, type) {
  const alertContainer = document.getElementById("alert-container");
  const wrapper = document.createElement("div");
  wrapper.className = `alert alert-${type} alert-dismissible`;
  wrapper.setAttribute("role", "alert");
  wrapper.innerHTML = [
    `<div>${message}</div>`,
    `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`,
  ].join("");
  alertContainer.append(wrapper);
  setTimeout(() => {
    if (alertContainer.contains(wrapper)) {
      wrapper.remove();
    }
  }, 6000);
}
