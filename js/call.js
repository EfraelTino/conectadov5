document.addEventListener('DOMContentLoaded', function () {
  const videoPlayer = document.getElementById('videoPlayer');
  const content_source = document.getElementById('content_source');
  const btnSiguiente = document.getElementById('btnSiguiente');
  const btnAntes = document.getElementById('btnAntes');

  // botones para traer pdf
  const btnAntesSrc = document.getElementById('btnAntesSrc');
  const btnSiguienteSrc = document.getElementById('btnSiguienteSrc');

  // creo una lista de videos que estan en la carpeta video
  const recursos = ['archivos/recurso1.pdf', 'archivos/recurso2.pdf', 'archivos/recurso3.pdf'];
  const videostotal = ['video/vide_1.mp4', 'video/video_2.mp4', 'video/video_3.mp4'];


  let indexsrc = 0;
  let indexVideo = 0;

  function siguienteRecurso() {
    indexsrc = (indexsrc + 1) % videostotal.length;
    content_source.href = recursos[indexsrc];
  }

  function anteriorRecurso (){
    indexsrc = (indexsrc - 1) % videostotal.length;
    content_source.href = recursos[indexsrc];
  }
  function reproducirSiguienteVideo() {
    indexVideo = (indexVideo + 1) % videostotal.length;
    videoPlayer.src = videostotal[indexVideo];
    videoPlayer.play();
  }
  function reproducirVideoAnterior() {
    indexVideo = (indexVideo - 1) % videostotal.length;
    videoPlayer.src = videostotal[indexVideo];
    videoPlayer.play();
  }
  // Agrega un evento al botón de "siguiente" para cambiar al siguiente video
  btnSiguiente.addEventListener('click', reproducirSiguienteVideo);
  btnAntes.addEventListener('click', reproducirVideoAnterior);
  btnAntesSrc.addEventListener('click', anteriorRecurso);
  btnSiguienteSrc.addEventListener('click', siguienteRecurso);
});
