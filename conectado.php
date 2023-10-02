<?php
session_start();
$title = "Conectado";
include('Chat.php');
$chat = new Chat();
include('page-master/head.php');
if (isset($_SESSION["userid"]) &&  $_SESSION["userid"]) {
    $userid =  $_SESSION["userid"];
} else {
    header("Location: ./");
}

include('page-master/js.php');
?>

<body>
    <div class="container-conectado-logo">
        <img src="textures/conectado_logo.webp" alt="">
    </div>
    <div class="container-skins" id="contColores" hidden>
        <!-- <span class="icon-chevron-right" id="mostrarA" ></span> -->
        <button class="btn_show" id="btnShow" onclick="mostrarA();">Avatar</button>
        <div class="wrap_skins" id="skins_cont" hidden>
            <h2>Select your Avatar</h2>
            <button class="skin_one" data-skin-number="1" onclick="seleccionarA();"><img src="images/King.png" class="skins" alt="primer skin" id="mujer"></button>
            <button class="skin_two" data-skin-number="2" onclick="seleccionarA();"><img src="images/Queen.png" class="skins" alt="segundo skin" id="hombre">></button>

        </div>

    </div>
    <div class="container-skins2" id="contColores" hidden>
        <!-- <span class="icon-chevron-left" id="mostrarC" onclick="mostrarC();"></span> -->
        <button class="btn_show show_2" id="btnShow2" onclick="mostrarC();">Skin</button>
        <div class="wrap_skins2" id="skins_cont2" hidden>
            <h2>Select your skins</h2>
            <button class="skin_one" data-skin-number="1" onclick="seleccionarC();"><img src="images/yellow.png" class="skins" alt="primer skin" id="color1"></button>
            <button class="skin_two" data-skin-number="2" onclick="seleccionarC();"><img src="images/gray.png" class="skins" alt="segundo skin" id="color2">></button>

        </div>

    </div>
    <div class="container-emojis">
        <button id="Saludo" class="emoji-button" hidden>
            <img src="images/han.webp" alt="greeting icon" class="icon-hand">
        </button>
        <button id="Dance" class="emoji-button" hidden>
            <img src="images/dancing.webp" alt="greeting icon" class="icon-greting">
        </button>
        <button id="suggestion_button" class="emoji-button" onclick="showSuggestion();">
            <img src="images/suggestion.webp" alt="greeting icon" class="icon-suggestion">
        </button>
        <button class="btn_sms" onclick="showSms();" hidden>
            <span class="icon-message-circle"></span>
        </button>
        <!-- mochila(); -->
        <button class="btn_camera" onclick="openProfile(1);">
            <img src="images/maleta2.webp" alt="greeting icon" class="icon-greting">
        </button>
        <button class="btn_camera" onclick="openProfile(3);">
            <img src="images/callwebp.webp" alt="greeting icon" class="icon-greting">
        </button>
        <button class="btn_camera" onclick="logOut();">
        <img src="images/logou_icon.webp" alt="logout icon" class="icon-greting">
        </button>
    </div>
    <!-- SECCION DEL CHAT -->
    <?php if (isset($_SESSION['userid']) && $_SESSION['userid']) { ?>
			<button class="flotante" onclick="openChat()">
				<span class="icon-message-square"></span>
			</button>
			<div class="chat">
				<div id="frame" class="frame-chat">
					<div id="sidepanel">
						<div id="profile" class="profile">

							<?php
							$loggedUser = $chat->getUserDetails($_SESSION['userid']);

							function colocarAvatar($avatar)
							// Si se requiere implementar: /$name['avatar']
							{
								switch ($avatar) {
									case "avatar1.png":
										echo 'avatar/avatar1.png';
										break;
									case "avatar2.png":
										echo 'avatar/avatar2.png';
										break;
									case "avatar3.png":
										echo 'avatar/avatar3.png';
										break;
									case "avatar4.png":
										echo 'avatar/avatar4.png';
										break;
								}
							}

							echo 
                            '<div class="wrap">';
							$currentSession = '';
							foreach ($loggedUser as $user) {
								$currentSession = $user['current_session'];
								$avatar = $user['avatar'];
							echo 
                                '<div class="profile-container">
							        <div class="picture-profile">
							            <img id="profile-img" src="' . 'userpics/' . $user['img_profile'] . '" class="online" alt="user-profile" />';
							echo  
                                        '<p>' . $user['fname'] . ' ' . $user['lastname'] . '</p> 
                                    </div>';
							echo 
                                    '<div>
                                        <i class="icon-x" onclick="openChat();">
                                        </i>
                                    </div> ';
							echo 
                                    '<div id="status-options">';
							echo 
                                        '<ul>';
							echo 
                                            '<li id="status-online" class="active">
                                                <span class="status-circle">
                                                </span> <p>Online</p>
                                            </li>';
							echo 
                                            '<li id="status-away">
                                                <span class="status-circle"></span> <p>Ausente</p>
                                            </li>';
							echo 
                                            '<li id="status-busy">
                                                <span class="status-circle"></span> <p>Ocupado</p>
                                            </li>';
							echo            
                                            '<li id="status-offline">
                                                <span class="status-circle"></span> <p>Desconectado</p>
                                            </li>';
							echo 
                                        '</ul>';
							echo 
                                    '</div>';
							echo 
                                    '<div id="expanded" class="container-salir">';
							echo        
                                        '<a href="logout.php" class="op-salir"> Sign off <span class="icon-log-out"></span> </a>';
							echo 
                                    '</div>';
							}
							echo 
                                '</div>';
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
						<div id="contacts">

							<?php
							echo '<div class="btn-go">';
							echo '<h4 style="margin: 0;">Members chat</h4>';
							echo '</div>';

							echo '<ul style="position:relative;">';

							$chatUsers = $chat->chatUsers($_SESSION['userid']);
							$chatButtonDisplayed = false;
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
								echo 
                                    '<li id="' . $user['userid'] . '" class="contact ' . $activeUser . '" data-touserid="' . $user['userid'] . '" data-tousername="' . $user['username'] . '" onclick="viewChat();" style="
                                    background:var(--color-en-linea); font-size: 20px; font-weight: 700; text-align: center;
        							border-radius: 6px; margin: 0px 2px 2px 0px; cursor:pointer;  position:sticky; top: 0; z-index: 3;"> Enter the group chat <span class="icon-send" style="font-weight:900;"></span>';
									echo '
                                    </li>';
									$chatButtonDisplayed = true;
								}
								echo 
                                    '<li id="' . $user['userid'] . '" class="contact ' . $activeUser . '" data-touserid="' . $user['userid'] . '" data-tousername="' . $user['username'] . '">';
								echo 
                                        '<div class="wrap">';
								echo 
                                            '<div class="contact-profile-contact">';
								echo 
                                                '<span id="status_' . $user['userid'] . '" class="contact-status ' . $status . '">
                                                </span>';
								echo 
                                                '<img src="userpics/' . $user['img_profile'] . '" alt="profile image" /> ';
								echo 
                                                '<div class="meta">';
								echo 
                                                    '<p class="name">' . $user['fname'] . ' ' . $user['lastname'] . 
                                                    '</p>';
								echo 
                                                    '<p class="preview">
                                                        <span id="isTyping_' . $user['userid'] . '" class="isTyping">
                                                        </span>
                                                    </p>';
								echo 
                                                '</div>
                                            </div>
                                            <div class="icon-cant-sms">
                                                <span hidden id="unread_' . $user['userid'] . '" class="">' . $chat->getUnreadMessageCount($user['userid'], $_SESSION['userid']) . 
                                                '</span>
                                            </div>';
								echo 
                                        '</div>';
								echo 
                                    '</li>';
							}
							echo '</ul>';
							?>

						</div>
					</div>
					<div class="content" id="content">
						<div class="contact-profile" id="userSection">
							<?php
							$userDetails = $chat->getUserDetails($currentSession);
							foreach ($userDetails as $user) {
							echo 
                                '<div class="img_profile">' .
 '<img src="userpics/conectado.png' . '" alt="user-icon" />';
				
							echo 
                                    '<p class="title_class">' . 'GLOBAL CHAT' . 
                                    '</p>' . 
                                '</div>';
							echo 
                                '<div class="social-media">';
							echo 
                                    '<span class="icon-x i-cerrar" onclick="openChat();">
                                    </span>';
							echo 
                                '</div>';
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
								<div class="wrap_input">
									<input type="text" class="chatMessage" id="chatMessage<?php echo $currentSession; ?>" placeholder="Escribe tu mensaje..." />
									<button class="submit chatButton" id="chatButton<?php echo $currentSession; ?>">
                                    <i class="icon-send" aria-hidden="true"></i>
                                    </button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
                        </div>
		<?php } else { ?>
			<?php include "index.php" ?>
		<?php } ?>

    <!-- FIN CHAT -->
    <div class="suggestion-container">
        <div class="conte-suggestion" id="suggestion_container">
            <button class="btn_x" onclick="showSuggestion();"> <span class="icon-x"></span></button>
            <h3 class="suggestion_text">SUGGESTION <strong>BOX</strong></h3>
            <?php

            $sql = "SELECT fname, lastname, username FROM chat_users WHERE userid = '$userid'";
            $stmt = $chat->dbConnect->query($sql);
            if (!$stmt) {
                die("Error en la consulta: " . $chat->dbConnect->error);
            }
            while ($row = $stmt->fetch_assoc()) {
                $fname = $row['fname'];
                $lname = $row['lastname'];
                $completename = $fname . ' ' . $lname;
                $username = $row['username'];
            }
            ?>
            <form action="" method="" id="" class="form_col">
                <input type="text" value="<?php echo $completename ?>" name="fname" id="fname" hidden>
                <input type="text" value="<?php echo $username ?>" name="email" id="email" hidden>
                <textarea type="text" id="input_suggestion" name="input_suggestion" class="input_suggestion" placeholder="PLEASE LEAVE US YOUR COMMENTS OF THE EXPERIENCE IN CONECTADO WORD"></textarea>
                <button type="button" class="send_suggestion" onclick="enviarSugerencia();">SEND</button>
                <div id="respuesta">

                </div>
            </form>

        </div>
    </div>
    <div class="conectado_container">
        <iframe id="vagonFrame" allow="microphone  *; clipboard-read *; clipboard-write *; encrypted-media *;" src="
https://streams.vagon.io/streams/8e5ceeed-94a3-4c18-88f1-a8abc6688eb7"></iframe> 
    </div>

    <?php
    echo "<div id='mochila_container' class='mochila_item'> ";
    include('backpack.php');
    include('universities.php');
    include ('videollamada.php');
    include ('avatar.php');
    include("modal.php");
    include('modals.php');
    echo "</div>";

    echo "
<script src='./js/mochila.js'> </script>
<script src='https://tokbox.com/embed/embed/ot-embed.js?embedId=6eed51e8-8b66-4676-822b-a6f4edaefaa8&room=DEFAULT_ROOM'></script>
";
    include "page-master/footer.php";
    ?>