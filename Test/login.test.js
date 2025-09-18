// Polyfill para TextEncoder/TextDecoder en Jest + Node
const { TextEncoder, TextDecoder } = require("util");
global.TextEncoder = TextEncoder;
global.TextDecoder = TextDecoder;

// No necesitas importar JSDOM manualmente si ya usas jest-environment-jsdom
const { screen } = require("@testing-library/dom");
require("@testing-library/jest-dom");

beforeEach(() => {
  document.body.innerHTML = `
    <form action="login.php" method="POST">
      <label for="usuario">Usuario:</label>
      <input type="text" id="usuario" name="usuario">

      <label for="correo">Correo electrónico:</label>
      <input type="email" id="correo" name="correo">

      <label for="contrasena">Contraseña:</label>
      <input type="password" id="contrasena" name="contrasena">

      <button type="submit" class="btn">Iniciar Sesión</button>
    </form>
  `;
});

test("El formulario tiene los campos requeridos", () => {
  expect(screen.getByLabelText("Usuario:")).toBeInTheDocument();
  expect(screen.getByLabelText("Correo electrónico:")).toBeInTheDocument();
  expect(screen.getByLabelText("Contraseña:")).toBeInTheDocument();
});

test("El botón de login existe y dice 'Iniciar Sesión'", () => {
  const boton = screen.getByRole("button", { name: /iniciar sesión/i });
  expect(boton).toBeInTheDocument();
});
