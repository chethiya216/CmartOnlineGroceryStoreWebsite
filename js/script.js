let userBox = document.querySelector('.header .header-2 .user-box');

document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active');
   navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .header-2 .navbar');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   userBox.classList.remove('active');
}

window.onscroll = () =>{
   userBox.classList.remove('active');
   navbar.classList.remove('active');

   if(window.scrollY > 60){
      document.querySelector('.header .header-2').classList.add('active');
   }else{
      document.querySelector('.header .header-2').classList.remove('active');
   }
}


function isValidEmail(email) {
   const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
   return emailRegex.test(email);
}


// password toggle functionality for register
function togglePassword(inputId, icon) {
   const password = document.getElementById(inputId);
   if (password.type === "password") {
       password.type = "text";
       icon.classList.remove('fa-eye');
       icon.classList.add('fa-eye-slash');
   } else {
       password.type = "password";
       icon.classList.remove('fa-eye-slash');
       icon.classList.add('fa-eye');
   }
}

// password toggle functionality for login
function togglePassword(icon) {
   const password = document.getElementById('password');
   if (password.type === "password") {
       password.type = "text";
       icon.classList.remove('fa-eye');
       icon.classList.add('fa-eye-slash');
   } else {
       password.type = "password";
       icon.classList.remove('fa-eye-slash');
       icon.classList.add('fa-eye');
   }
}

