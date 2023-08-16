(function () {
  // Toggle show/hide password
  const passwordInputs = document.querySelectorAll("input[data-toggle-password='on'][type='password']");
  passwordInputs.forEach((input) => {
    const container = document.createElement("div");
    container.style.position = "relative";
    input.style.paddingRight = "40px";
    input.parentElement.append(container);
    const clonedInput = input.cloneNode(true);
    container.appendChild(clonedInput);
    input.remove();
    const button = document.createElement("div");
    button.style.position = "absolute";
    button.style.top = 0;
    button.style.right = 0;
    button.style.height = "100%";
    button.style.width = "40px";
    button.style.display = "flex";
    button.style.alignItems = "center";
    button.style.justifyContent = "center";
    button.style.backgroundColor = "transparent";
    button.style.cursor = "pointer";
    button.style.userSelect = "none";
    container.append(button);
    const eye = `<i class="bi bi-eye"></i>`;
    const eyeSlash = `<i class="bi bi-eye-slash"></i>`;
    button.innerHTML = eye;
    button.setAttribute("data-show", "0");
    button.addEventListener("click", function () {
      if (this.getAttribute("data-show") === "0") {
        button.setAttribute("data-show", "1");
        button.innerHTML = eyeSlash;
        clonedInput.setAttribute("type", "text");
      } else {
        button.setAttribute("data-show", "0");
        button.innerHTML = eye;
        clonedInput.setAttribute("type", "password");
      }
    });
  });
})();
