var contador = 0;
var primero = false;
var lugarActualDB = $("lugar-usuario");
var lugardeOtroUsuario = $("lugar-otro-usuario");
var ubicacionGeneral = 0;
// datos de usuario actual
var lugarUsuarioActual = "";
var avatarUsuarioActual = "";
var estadoUsuarioActual = "";
// datos de otros usuarios
var lugarOtroUsuario = "";
var avatarOtroUsuario = "";
var estadoOtroUsuario = "";
// estado del usuario en lista
var listauser = document.getElementById("content");
var profile = document.getElementById("profile");
var chatContainer = document.querySelector(".chat");
//var btnMapa = document.getElementById("button-mapa");
var mapaContainer = document.getElementById("mapa");
//var btnClose = document.querySelector('.btn-close');
var inicio = false;
var temporizador = 0;

function checkTodo() {
	// updateUserChat();
	actualizarLugar();
	scrollToBottom();
}
function cerrarChat() {
	const chatContainer = $(".chat");
	chatContainer.removeClass('view_chat');
	const contenChat = $("#content");
	const profile = $("#profile");
	contenChat.removeClass("view_chat");
	profile.removeClass("ocutlar_profile");
	window.Vagon.focusIframe();
}
$(document).ready(function () {
	setInterval(function () {

		temporizador++;
		if (inicio) {

			checkTodo();
		}
		if (temporizador > 6) {
			temporizador = 0; inicio = false; console.log("auto off");
			window.Vagon.focusIframe();
			cerrarChat();
		}
	}, 5000);
	$(".messages").animate({
		scrollTop: $(document).height()
	}, "fast");
	$(document).on("click", '#profile-img', function (event) {
		$("#status-options").toggleClass("active");
	});
	// $(document).on("click", '.expand-button', function(event) { 	
	// 	$("#profile").toggleClass("expanded");
	// 	$("#contacts").toggleClass("expanded");
	// });	
	$(document).on("click", '#status-options ul li', function (event) {
		$("#profile-img").removeClass();
		$("#status-online").removeClass("active");
		$("#status-away").removeClass("active");
		$("#status-busy").removeClass("active");
		$("#status-offline").removeClass("active");
		$(this).addClass("active");
		if ($("#status-online").hasClass("active")) {
			$("#profile-img").addClass("online");
		} else if ($("#status-away").hasClass("active")) {
			$("#profile-img").addClass("away");
		} else if ($("#status-busy").hasClass("active")) {
			$("#profile-img").addClass("busy");
		} else if ($("#status-offline").hasClass("active")) {
			$("#profile-img").addClass("offline");
		} else {
			$("#profile-img").removeClass();
		};
		$("#status-options").removeClass("active");
	});
	$(document).on('click', '.contact', function () {
		$('.contact').removeClass('active');
		$(this).addClass('active');
		var to_user_id = $(this).data('touserid');
		showUserChat(to_user_id);
		$(".chatMessage").attr('id', 'chatMessage' + to_user_id);
		$(".chatButton").attr('id', 'chatButton' + to_user_id);
	});
	$(document).on("click", '.submit', function (event) {
		var to_user_id = $(this).attr('id');
		to_user_id = to_user_id.replace(/chatButton/g, "");
		sendMessage(to_user_id);
	});
	$(document).on('focus', '.message-input', function () {
		var is_type = 'yes';
		$.ajax({
			url: "chat_action.php",
			method: "POST",
			data: { is_type: is_type, action: 'update_typing_status' },
			success: function () {
			}
		});
	});
	$(document).on('blur', '.message-input', function () {
		var is_type = 'no';
		$.ajax({
			url: "chat_action.php",
			method: "POST",
			data: { is_type: is_type, action: 'update_typing_status' },
			success: function () {
			}
		});
	});

});

// esta función aún no se está usando
function updateUserList() {
	// estadoenLista=document.getElementById("personasEnLinea");
	console.log("actualizar");
	$.ajax({
		url: "chat_action.php",
		method: "POST",
		dataType: "json",
		data: { action: 'update_user_list' },
		success: function (response) {
			// console.log(response);
			var obj = response.profileHTML;
			var to_user_id = $(this).attr('data-touserid');
			Object.keys(obj).forEach(function (key) {
				// update user online/offline status
				if ($("#" + obj[key].userid).length) {
					if (obj[key].online == 1 && !$("#status_" + obj[key].userid).hasClass('online')) {
						$("#status_" + obj[key].userid).addClass('online');
						// $(to_user_id + obj[key].userid).addClass('mostraLista').removeClass('ocultarLista');
					} else if (obj[key].online == 1) {
						$("#status_" + obj[key].userid).removeClass('online');
						// $(to_user_id + obj[key].userid).removeClass('mostraLista').addClass('ocultarLista');	
					}
				}
			});
		}, error: function (xhr, status, error) {
			console.log(xhr.responseText);
			console.log(xhr);
			console.log(status);
			console.log(error);
		}
	});
}

$(document).ready(function (to_user_id) {
	// Obtén to_user_id de algún lugar y luego llama a las funciones de evento


	$("#sendButton").on("click", function () {
		sendMessage(to_user_id);
	});

	$(".message-input input").on("keydown", function (event) {
		if (event.keyCode === 13) {
			event.preventDefault();
			sendMessage(to_user_id);
		}
	});


});


function sendMessage(to_user_id) {

	ubicacionGeneral;
	var message = $(".message-input input").val();
	$('.message-input input').val('');
	if ($.trim(message) == '') {
		return false;
	}
	var formData = new FormData();
	formData.append('to_user_id', to_user_id);
	formData.append('chat_message', message);
	formData.append('action', 'insert_chat');
	formData.append('lugar', ubicacionGeneral);
	$.ajax({
		url: "chat_action.php",
		method: "POST",
		data: formData,
		dataType: "json",
		contentType: false,
		processData: false,
		success: function (response) {
			var resp = $.parseJSON(response);
			$('#conversation').html(resp.conversation);
			$(".messages").animate({ scrollTop: $('.messages').height() }, "fast");
		}
	});
	//alert(message);
	updateUnreadMessageCount();
	updateUserChat();
}
// se está usando para ver el chat grupal
function showUserChat(to_user_id) {
	//console.log(to_user_id);
	$.ajax({
		url: "chat_action.php",
		method: "POST",
		data: { to_user_id: to_user_id, action: 'show_chat' },
		dataType: "json",
		success: function (response) {
			$('#userSection').html('CHAT GLOBAL');
			$('#userSection').html(response.userSection);
			$('#conversation').html(response.conversation);
			$('#unread_' + to_user_id).html('');
			$('#unread_' + to_user_id).addClass('unread');
		}
	});

}


var entraNuevo = "";
function updateUserChat() {

	$('li.contact').each(function () {//li.contact.active
		var to_user_id = $(this).attr('data-touserid');
		$.ajax({
			url: "chat_action.php",
			method: "POST",
			data: { to_user_id: to_user_id, action: 'update_user_chat' },
			dataType: "json",
			success: function (response) {
				$('#conversation').html(response.conversation);
				if (entraNuevo != $('#conversation')[0].innerText) {//&& primero
					entraNuevo = $('#conversation')[0].innerText; //-----------------------------------
					//var audio = document.getElementById("audio");
					//audio.play();
					//console.log(response+" -*-*-*-*-*-*-*-*-*-*-*-");
					temporizador = 1;
				}
			}
		});
	});
}
var entrada = "";
function updateUnreadMessageCount() {
	$('li.contact').each(function () {
		if (!$(this).hasClass('active')) {
			var to_user_id = $(this).attr('data-touserid');
			$.ajax({
				url: "chat_action.php",
				method: "POST",
				data: { to_user_id: to_user_id, action: 'update_unread_message' },
				dataType: "json",
				success: function (response) {
					if (entrada != $('#conversation')[0].scrollHeight) {
						// console.log($('#conversation')[0].scrollHeight);
						entrada = $('#conversation')[0].scrollHeight;
						scrollToBottom();
						// El mensaje que llega de otro usuario sucede acá
						// console.log("MENSAJE DE UPDATEUNREADMESSAGECOUNT");

					}
				}
			});
		}
	});
}
function showTypingStatus() {
	$('li.contact.active').each(function () {
		var to_user_id = $(this).attr('data-touserid');
		$.ajax({
			url: "chat_action.php",
			method: "POST",
			data: { to_user_id: to_user_id, action: 'show_typing_status' },
			dataType: "json",
			success: function (response) {
				$('#isTyping_' + to_user_id).html(response.message);

			}
		});
	});
}



// Capturar el evento de desplazamiento del scroll
function scrollToBottom() {

	var docChat = document.getElementById("conversation");
	if (docChat != null) {
		docChat.scrollTop = docChat.scrollHeight;
		inicio = true;

	}
}





// actualizar  lugar de ubicacion del usuario
function actualizarLugar(ubicacion) {
	if (ubicacion != undefined) {
		//   console.log(ubicacion);
		var formData = new FormData();
		formData.append('action', 'actualizar_lugar_usuario');
		formData.append('lugar', ubicacion);
		$.ajax({
			url: "chat_action.php",
			method: "POST",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			success: function (response) {
				//   console.log(response);
				//   Obtener el lugar que el response nos manda
				var lugarActualizado = response.lugar;
				//   console.log("Lugar actualizado:", lugarActualizado);
				$('#lugar-del-usuario').text(lugarActualizado);
			},
			error: function (xhr, status, error) {
				//   console.log(xhr.responseText);
				//   console.log(error);
			}
		});
	}
}

