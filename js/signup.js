const form = document.querySelector(".singup form"),
continueBtn = form.querySelector(".button input"),
errorTxt = form.querySelector(".error-txt");

form.onsubmit = (e) => {
   e.preventDefault(); // This prevent form from submitting
}

continueBtn.onclick = () => {
   // Ajax
   // Creating XML object
   let xhr = new XMLHttpRequest(); 

   xhr.open("POST", "php/signup.php", true);
   xhr.onload = ()=>{

      if(xhr.readyState === XMLHttpRequest.DONE) {
         if(xhr.status === 200){
            let data = xhr.response;
            if(data == "success") {
               location.href = "users.php"
            }else {
               errorTxt.textContent = data;
               errorTxt.style.display = "block";

            }
         }
      }
   }
   // We have to send the form data throw ajax to php
   let formData = new FormData(form); // Create new formData Object
   xhr.send(formData); // sending the form data to php
}