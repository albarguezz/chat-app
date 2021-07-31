const form = document.querySelector(".typing-area"),
   incoming_id = form.querySelector(".incoming_id").value,
   inputField = form.querySelector(".input-field"),
   sendBtn = form.querySelector("button"),
   chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
   e.preventDefault(); // This prevent form from submitting
}

inputField.focus();
inputField.onkeyup = () => {
   if (inputField.value != "") {
      sendBtn.classList.add("active");
   } else {
      sendBtn.classList.remove("active");
   }
}

sendBtn.onclick = () => {
   // Ajax
   // Creating XML object
   let xhr = new XMLHttpRequest();

   xhr.open("POST", "php/insert-chat.php", true);
   xhr.onload = () => {

      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            inputField.value = ""; // once messege instead into database then leave blankthe input field
            scrollToBottom();
         }
      }
   }
   // We have to send the form data throw ajax to php
   let formData = new FormData(form); // Create new formData Object
   xhr.send(formData); // sending the form data to php
}

chatBox.onmouseenter = ()=> {
   chatBox.classList.add("active");
}

chatBox.onmouseleave = () => {
   chatBox.classList.remove("active");
}

setInterval(() => {
   // Ajax
   // Creating XML object
   let xhr = new XMLHttpRequest();

   xhr.open("POST", "php/get-chat.php", true);
   xhr.onload = () => {

      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")) { // If active class not contains the class active 
               scrollToBottom();
            }
         }
      }
   }

   let formData = new FormData(form); // Create new formData Object
   xhr.send(formData); // sending the form data to php
   /*
   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhr.send("incoming_id=" + incoming_id);*/

}, 500); // This function will run frecuently after 500ms

function scrollToBottom() {
   chatBox.scrollTop =  chatBox.scrollHeight;
}