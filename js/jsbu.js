console.log("hola desde conectado");
// open suggestion
function showSuggestion (){
  console.log("hola");
  const suggestion_container= document.getElementById("suggestion_container"), sus=document.querySelector(".suggestion-container");
  suggestion_container.classList.toggle("show_suggestion");
  sus.classList.toggle("show_s");
}

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
  const id_user = document.getElementById("value_userid");
  const user_id = id_user.textContent;
  const avatar = 1;
  const datos = {
      avatar: avatar,
      user_id: user_id,
      action: 'avatar1', // Agregar la acción aquí
  };
  const datosCodificados = JSON.stringify(datos);
  fetch("skins.php", {
    method: 'POST',
    body: datosCodificados,
    headers: {
        'Content-Type': 'application/json',
    }
})
.then(response => response.text()) // Read the response as text
.then(responseText => {
    try {
        const jsonResponse = JSON.parse(responseText); // Try parsing as JSON
        console.log(jsonResponse);
    } catch (error) {
        console.error('JSON Parse Error:', error);
        console.log('Response Text:', responseText); // Log the response content
    }
})
.catch(error => {
    console.error('Fetch Error:', error);
});

};




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
    const id_user= document.getElementById("value_userid");
    const user_id = id_user.textContent;
    const avatar = 2;
    const datos = {
      avatar: avatar,
      user_id: user_id,
      action: 'avatar2', // Agregar la acción aquí
  };
  const datosCodificados = JSON.stringify(datos);
  fetch("skins.php", {
    method: 'POST',
    body: datosCodificados,
    headers: {
        'Content-Type': 'application/json',
    }
})
.then(response => response.text()) // Read the response as text
.then(responseText => {
    try {
        const jsonResponse = JSON.parse(responseText); // Try parsing as JSON
        console.log(jsonResponse);
    } catch (error) {
        console.error('JSON Parse Error:', error);
        console.log('Response Text:', responseText); // Log the response content
    }
})
.catch(error => {
    console.error('Fetch Error:', error);
});
}

const seleccionarD = () => {
  const showC = document.getElementById("btnShow2");
  const botoneC = document.getElementById("skins_cont2");
  showC.style.display = "block";
  botoneC.style.display = "none";
  const id_user= document.getElementById("value_userid");
  const user_id = id_user.textContent;
  const skin = 1;
  const datos = {
    skin: skin,
    user_id: user_id,
    action: 'skin1', // Agregar la acción aquí
};
const datosCodificados = JSON.stringify(datos);
fetch("skins.php", {
  method: 'POST',
  body: datosCodificados,
  headers: {
      'Content-Type': 'application/json',
  }
})
.then(response => response.text()) // Read the response as text
.then(responseText => {
  try {
      const jsonResponse = JSON.parse(responseText); // Try parsing as JSON
      console.log(jsonResponse);
  } catch (error) {
      console.error('JSON Parse Error:', error);
      console.log('Response Text:', responseText); // Log the response content
  }
})
.catch(error => {
  console.error('Fetch Error:', error);
});
}

const seleccionarE = () => {
  const showC = document.getElementById("btnShow2");
  const botoneC = document.getElementById("skins_cont2");
  showC.style.display = "block";
  botoneC.style.display = "none";
  const id_user= document.getElementById("value_userid");
  const user_id = id_user.textContent;
  const skin = 2;
  const datos = {
    skin: skin,
    user_id: user_id,
    action: 'skin2', // Agregar la acción aquí
};
const datosCodificados = JSON.stringify(datos);
fetch("skins.php", {
  method: 'POST',
  body: datosCodificados,
  headers: {
      'Content-Type': 'application/json',
  }
})
.then(response => response.text()) // Read the response as text
.then(responseText => {
  try {
      const jsonResponse = JSON.parse(responseText); // Try parsing as JSON
      console.log(jsonResponse);
  } catch (error) {
      console.error('JSON Parse Error:', error);
      console.log('Response Text:', responseText); // Log the response content
  }
})
.catch(error => {
  console.error('Fetch Error:', error);
});
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

// function sendMessage() {
//     const textarea = document.getElementById("input_suggestion");
//     const message = textarea.value.trim();
//     if (message !== "") {
//         console.log("Mensaje enviado:", message);

//         // limpieza del mensaje enviado 
//         textarea.value="";
        
//     }
// }


// Logout
const logOut =()=>{
  window.location.href="logic/logout.php";
}



// function ver mochila
function showMochila(){
  window.location.href="mochila";
}






// el chat
<div class="sms-container">
<div class="conte-suggestion" id="sms_container">
    <div class="close_container">
        <button class="btn_x" onclick="showSms();"> <span class="icon-x"></span></button>
    </div>
    <!-- <div class="container_mess">
        <h3 class="suggestion_text group    ">GROUP CHAT</h3>
        <?php if (isset($_SESSION['userid']) && $_SESSION['userid']) { ?>
            <div id="canvasZone"><canvas id="renderCanvas"></canvas></div>
            <div class="chat">
                <div id="frame" class="frame-chat">
                    <div id="sidepanel">
                        <div id="profile">
                            <?php
                            include('Chat.php');
                            $chat = new Chat();
                            $loggedUser = $chat->getUserDetails($_SESSION['userid']);
                            echo '<div class="wrap">';
                            $currentSession = '';
                            foreach ($loggedUser as $user) {
                                $currentSession = $user['current_session'];
                                $avatar = $user['avatar'];

                                echo '<div class="profile-container">
                                <div class="picture-profile">
                                <img id="profile-img" src="' . 'userpics/' . $user['img_profile'] . '" class="online" alt="user-profile" />';
                                echo  '<p>' . $user['fname'] . ' ' . $user['lastname'] . '</p> </div>';
                                echo '<div id="status-options">';
                                echo '<ul>';
                                echo '<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>';
                                echo '<li id="status-away"><span class="status-circle"></span> <p>Ausente</p></li>';
                                echo '<li id="status-busy"><span class="status-circle"></span> <p>Ocupado</p></li>';
                                echo '<li id="status-offline"><span class="status-circle"></span> <p>Desconectado</p></li>';
                                echo '</ul>';
                                echo '</div>';
                                echo '<div id="expanded" class="container-salir">';
                                echo '<a href="logout.php" class="op-salir"> Sign off <span class="icon-log-out"></span> </a>';
                                echo '</div>';
                            }
                            echo '</div>';
                            ?>
                        </div>
                        <style>
                            .btn-go {
                                margin-top: 10px;
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                            }

                            .btn-go button {
                                background-color: var(--color-secundario);
                                border: 1px solid var(--color-primario);
                                margin-right: 2px;
                                font-size: 14px;
                                cursor: pointer;
                                font-weight: 700;
                                border-radius: 4px;
                            }

                            .btn-go button span {
                                font-weight: 800;
                            }
                        </style>
                        <div id="contacts" hidden>

                            <?php
                            echo '<div class="btn-go">';
                            echo '<h4 style="margin: 0;">Members chat</h4>';
                            echo '</div>';

                            echo '<ul style="position:relative;">';

                            $chatUsers = $chat->chatUsers($_SESSION['userid']);
                            $chatButtonDisplayed = false;
                            $enlinea = 0;
                            foreach ($chatUsers as $user) {
                                if ($user['online'] == 0) {
                                    continue;
                                }
                                $status = 'offline';
                                if ($user['online'] == 1) {
                                    $status = 'online';
                                }
                                $activeUser = '';
                                if ($user['userid'] == $currentSession) {
                                    $activeUser = "active";
                                }
                                if (!$chatButtonDisplayed) {
                                    echo '<li id="' . $user['userid'] . '" class="contact ' . $activeUser . '" data-touserid="' . $user['userid'] . '" data-tousername="' . $user['username'] . '" onclick="verMensaje();" style="background:var(--color-en-linea); font-size: 20px; font-weight: 700; text-align: center;
                            border-radius: 6px; margin: 0px 2px 2px 0px; cursor:pointer;  position:sticky; top: 0; z-index: 3;"> Enter the group chat <span class="icon-send" style="font-weight:900;"></span>';
                                    echo ' </li>';
                                    $chatButtonDisplayed = true;
                                }
                                echo '<li id="' . $user['userid'] . '" class="contact ' . $activeUser . '" data-touserid="' . $user['userid'] . '" data-tousername="' . $user['username'] . '">';
                                echo '<div class="wrap">';
                                echo '<div class="contact-profile-contact">';
                                echo '<span id="status_' . $user['userid'] . '" class="contact-status ' . $status . '"></span>';
                                echo '<img src="userpics/' . $user['img_profile'] . '" alt="" /> ';
                                echo '<div class="meta">';
                                echo '<p class="name">' . $user['fname'] . ' ' . $user['lastname'] . '</p>';
                                echo '<p class="preview"><span id="isTyping_' . $user['userid'] . '" class="isTyping"></span></p>';
                                echo '</div></div><div class="icon-cant-sms"><span id="unread_' . $user['userid'] . '" class="">' . $chat->getUnreadMessageCount($user['userid'], $_SESSION['userid']) . '</span></div>';
                                echo '</div>';
                                echo '</li>';
                                $enlinea++;
                            }
                            if ($enlinea === 0) {
                                echo '<div>No hay usuarios en línea</div>';
                            }
                            echo '</ul>';
                            ?>

                        </div>


                        <div id="bottom-bar" style="display: none;">
                            <button id="addcontact"><i class="icon-user" aria-hidden="true"></i> <span>Agregar Contactos</span></button>
                            <button id="settings"><i class="icon-settings" aria-hidden="true"></i> <span>Configuracion</span></button>
                        </div>
                    </div>
                    <div class="content" id="content">
                        <div class="contact-profile" id="userSection" style="    display: flex; height: 0; opacity: 0;">
                            <?php
                            $userDetails = $chat->getUserDetails($currentSession);
                            foreach ($userDetails as $user) {
                                echo '<div  class="img_profile">' . '<span class="icon-arrow-left ico-back" onclick="abrirchat();"></span> ' . '<img src="userpics/conectado.png' . '" alt="user-icon" />';
                                // $user['fname'] .' '. $user['lastname'] 
                                echo '<p>' . 'GLOBAL CHAT' . '</p>' . ' </div>';
                                echo '<div class="social-media">';
                                // echo '<i class="icon-facebook" aria-hidden="true"></i>';
                                // echo '<i class="icon-twitter" aria-hidden="true"></i>';
                                // echo '<i class="icon-instagram" aria-hidden="true">';
                                echo '</i> <span class="icon-x i-cerrar" onclick="cerrarChat();"></span>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div class="messages" id="conversation">
                            <?php
                            echo $chat->getUserChat($_SESSION['userid'], $currentSession);
                            ?>
                        </div>
                        <div class="message-input" id="replySection">
                            <div class="message-input" id="replyContainer">

                                <div class="wrap">
                                    <input type="text" class="chatMessage" id="chatMessage<?php echo $currentSession; ?>" placeholder="Escribe tu mensaje..." />
                                    <button class="submit chatButton" id="chatButton<?php echo $currentSession; ?>"><i class="icon-send" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <audio id="audio" controls hidden>
                <source type="audio/wav" src="audio/send.mp3">
            </audio>
        <?php } else { ?>
            <?php include "index.php" ?>
        <?php } ?>
    </div> -->
</div>
</div>