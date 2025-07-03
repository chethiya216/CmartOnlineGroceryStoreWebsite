let navbar = document.querySelector('.header .navbar');
let accountBox = document.querySelector('.header .account-box');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   accountBox.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   accountBox.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   accountBox.classList.remove('active');
}

document.querySelector('#close-update').onclick = () =>{
   document.querySelector('.edit-product-form').style.display = 'none';
   window.location.href = 'admin_products.php';
}

function isValidEmail(email) {
   const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
   return re.test(email);
}

function togglePassword(id, element) {
   const input = document.getElementById(id);
   if (input.type === 'password') {
       input.type = 'text';
       element.classList.remove('fa-eye');
       element.classList.add('fa-eye-slash');
   } else {
       input.type = 'password';
       element.classList.remove('fa-eye-slash');
       element.classList.add('fa-eye');
   }
}

function showMessage(message) {
   const alertDiv = document.createElement('div');
   alertDiv.className = 'alert';
   alertDiv.innerHTML = `${message}<i class="fas fa-times" onclick="this.parentElement.remove();"></i>`;
   document.querySelector('.login-container').insertBefore(alertDiv, document.querySelector('form'));
   setTimeout(() => alertDiv.remove(), 5000);
}

