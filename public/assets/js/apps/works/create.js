const inputField = document.getElementById("inputAuthor_coauthors");

inputField.addEventListener("input", function() {
  let inputValue = inputField.value;
  const commaCount = (inputValue.match(/,/g) || []).length;

  // Remover caracteres no permitidos
  inputValue = inputValue.replace(/[;:.\-]/g, '');

  // Si hay más de 4 comas, eliminar comas extras
  if (commaCount > 4) {
    inputValue = inputValue.slice(0, inputValue.lastIndexOf(","));
  }

  // Actualizar el valor del campo de entrada
  inputField.value = inputValue;
});


const textarea = document.getElementById("inputDescription");
const charCountSpan = document.getElementById("charCount");

// Función para actualizar el contador de caracteres
function updateCharCount() {
  const maxLength = 5000;
  const currentLength = textarea.value.length;

  // Verificar si la longitud supera el límite y recortar si es necesario
  if (currentLength > maxLength) {
    textarea.value = textarea.value.substring(0, maxLength);
  }

  // Actualizar el contador de caracteres
  charCountSpan.textContent = `${textarea.value.length} / ${maxLength}`;
}

// Agregar un evento de escucha al textarea
textarea.addEventListener("input", updateCharCount);

// Llamar a la función al cargar la página
updateCharCount();

