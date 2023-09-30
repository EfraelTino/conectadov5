var pwd= document.getElementById("password"), toggleIcon=document.getElementById("icon-eyes");


toggleIcon.onclick=()=>{
    if(pwd.type== "password"){
        pwd.type="text";
        toggleIcon.classList.add("active")
    }else{
        pwd.type="password";
        toggleIcon.classList.remove("active");
    }
}
// FUNCION SALIR 
// var isOpen = false;
// var salirIcon = document.getElementById("expanded");

// function salir() {
//   if (isOpen) {
//     salirIcon.classList.add("show");
//   } else {
//     salirIcon.classList.remove("show");
//   }
//   isOpen = !isOpen;
// }
