console.log("hola desde conectado");
// open suggestion
function showSuggestion (){
  const suggestion_container= document.getElementById("suggestion_container"), sus=document.querySelector(".suggestion-container");
  suggestion_container.classList.toggle("show_suggestion");
  sus.classList.toggle("show_s");
  window.Vagon.focusIframe();
}

// opcion de chat
function openChat(){
  const chatContainer= $(".chat");
  chatContainer.toggleClass('view_chat');
  window.Vagon.focusIframe();
}
function viewChat(){
  const contenChat = $("#content");
  const profile= $("#profile");
  contenChat.toggleClass("view_chat");
  profile.toggleClass("ocutlar_profile");
}


// send suggestion
function enviarSugerencia() {
  const $nombre = document.querySelector("#fname"),
      $email = document.querySelector("#email"),
      $suggestion = document.querySelector("#input_suggestion"),
      $response = document.querySelector("#respuesta");

      if ($suggestion.value.trim().length <= 5) {
        $response.textContent="Please enter your suggestion, to continue..."
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
          $suggestion.value='';
         
      } else {
        $suggestion.value='';
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
const seleccionarA = () => {
    const showA = document.getElementById("btnShow");
    const botoneA = document.getElementById("skins_cont");
    showA.style.display = "block";
    botoneA.style.display = "none";
    
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





function showSms (){
  const sms_container= document.getElementById("sms_container");
  sms_container.classList.toggle("show_sms");
}

// Logout
const logOut =()=>{
  window.location.href="logic/logout.php";
}
const mochila =()=>{
  window.location.href="backpack";
}
setTimeout(function(){
  console.log(window.Vagon.isConnected+" -------------- ");
}, 1000);

// function sendMessage() {
//     const textarea = document.getElementById("input_suggestion");
//     const message = textarea.value.trim();
//     if (message !== "") {
//         console.log("Mensaje enviado:", message);

//         // limpieza del mensaje enviado 
//         textarea.value="";
        
//     }
// }