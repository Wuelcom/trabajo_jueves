// Animación de entrada
window.addEventListener("load", () => {
  document.querySelector(".login-box").classList.add("show");
});

// Efecto de foco en inputs
const inputs = document.querySelectorAll("input");
inputs.forEach(input => {
  input.addEventListener("focus", () => {
    input.style.borderColor = "#5a2ca0";
    input.style.boxShadow = "0 0 8px #5a2ca0";
  });
  input.addEventListener("blur", () => {
    input.style.borderColor = "#ccc";
    input.style.boxShadow = "none";
  });
});
