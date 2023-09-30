document.addEventListener('DOMContentLoaded', function () {
    const videoPlayer = document.getElementById('videoPlayer');
    const btnSiguiente = document.getElementById('btnSiguiente');
    
    // Agrega un evento al botón de "siguiente" para cambiar al siguiente video
    btnSiguiente.addEventListener('click', function () {
      // Lógica para cargar el siguiente video desde la base de datos
      // Actualiza el src del reproductor de video con la nueva ruta del video
      videoPlayer.src = 'video/video_2.mp4';
      // Inicia la reproducción automáticamente si lo deseas
      videoPlayer.play();
    });
  });
  