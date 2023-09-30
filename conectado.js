
// send suggestion

function enviarSugerencia() {
  const $nombre = document.querySelector("#fname"),
    $email = document.querySelector("#email"),
    $suggestion = document.querySelector("#input_suggestion"),
    $response = document.querySelector("#respuesta");

  if ($suggestion.value.trim().length <= 5) {
    $response.textContent = "Please enter your suggestion, to continue..."
    $response.classList.add("error_send");
    return;
  }
  // texto 
  $response.textContent = "Loading ...";

  // rellenamos los datos
  const datos = {
    nombre: $nombre.value,
    correo: $email.value,
    mensaje: $suggestion.value,
  };

  // codificamos en formato json
  const datosCodificados = JSON.stringify(datos);

  // enviamos
  fetch("sugestion.php", {
    method: 'POST',
    body: datosCodificados,
  })
    .then(respuestaCodificada => respuestaCodificada.json())
    .then(respuestaCodificada => {
      // Manejar la respuesta JSON
      if (respuestaCodificada.success) {
        $response.textContent = respuestaCodificada.message;
        $response.classList.add("success_send");
        $suggestion.value = '';
      } else {
        $suggestion.value = '';
        $response.textContent = respuestaCodificada.message;
        $response.classList.add("error_send");

      }
      // limpiamos todos
      setTimeout(() => {
        $response.textContent = "";
        $response.classList.remove("success_send", "error_send");
      }, 10000); // 10000 milisegundos = 10 segundos
    });
}



const mostrarA = () => {
  const showA = document.getElementById("btnShow");
  const botoneA = document.getElementById("skins_cont");
  showA.style.display = "none";
  botoneA.style.display = "block";


}
const seleccionarA = (genero) => {
  console.log("aca envias a la base de datos Efra....");
  const showA = document.getElementById("btnShow");
  const botoneA = document.getElementById("skins_cont");
  showA.style.display = "block";
  botoneA.style.display = "none";
  const id_user = document.getElementById("value_userid");
  const user_id = id_user.textContent;
  const avatar = genero;
  const datos = {
    avatar: avatar,
    user_id: user_id // Agregar la acción aquí
  };
  const datosCodificados = JSON.stringify(datos);
  fetch("./skins.php", {
    method: 'POST',
    body: datosCodificados,
    headers: {
      'Content-Type': 'application/json' // Agregar encabezado Content-Type
    }
  })
    .then(respuestaCodificada => respuestaCodificada.json())
    .then(respuestaCodificada => {
      console.log(respuestaCodificada);
    })
    .catch(error => {
      console.error('Error:', error);
    });


}



const mostrarC = () => {
  const showC = document.getElementById("btnShow2");
  const botoneC = document.getElementById("skins_cont2");
  showC.style.display = "none";
  botoneC.style.display = "block";

}
const seleccionarC = () => {
  const showC = document.getElementById("btnShow2");
  const botoneC = document.getElementById("skins_cont2");
  showC.style.display = "block";
  botoneC.style.display = "none";
}




const enviarMensaje = (event) => {
  event.preventDefault();
  const inputMensaje = document.getElementById("nombre");
  const mensaje = inputMensaje.value.trim();

  if (mensaje !== "") {
    // console.log("se a enviado el mensaje: " + mensaje);
    inputMensaje.value = ""
  }
};

const handleKeyDown = (event) => {
  if (event.key === "Enter") {
    event.preventDefault();
    // console.log("se a enviado el mensaje: "+ mensaje);
    enviarMensaje();
  }
}


// open suggestion

function showSuggestion() {

  const suggestion_container = document.getElementById("suggestion_container");
  suggestion_container.classList.toggle("show_suggestion");

}


function showSms() {
  const sms_container = document.getElementById("sms_container");
  sms_container.classList.toggle("show_sms");
}

function sendMessage() {
  const textarea = document.getElementById("input_suggestion");
  const message = textarea.value.trim();
  if (message !== "") {
    console.log("Mensaje enviado:", message);

    // limpieza del mensaje enviado 
    textarea.value = "";

  }
}

/*
let element = document.querySelector('input');
element.onkeydown = e => alert(e.key);
changeValButton.onclick = () => element.value += "+";
dispatchButton.onclick = () => {
  console.log("aca estamos");
   element.dispatchEvent(new KeyboardEvent('keydown', {'key': '+'}));
}*/