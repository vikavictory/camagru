window.onload = function () {
   let button = document.getElementById("menuButton");
   let menu = document.getElementById("menu");

   let showMenu = function (event) {
       if (menu.style.display === 'none'){
           menu.style.display = 'block';
       } else {
           menu.style.display = 'none'
       }
   }

   button.addEventListener('click', showMenu);
}