const searchBar = document.querySelector(" .search input"),
searchIcon = document.querySelector(" .search button"),
usersList = document.querySelector(".users .users-list");

searchIcon.onclick = () => {
   searchBar.classList.toggle("show");
   searchIcon.classList.toggle("active");
   searchBar.focus();
   if (searchBar.classList.contains("active")) {
      searchBar.value = "";
      searchBar.classList.remove("active");
   }
}



searchBar.onkeyup = () => {
   let searchTerm = searchBar.value;

   // Adding an active class when user start searching and only run the setInterval Ajax if there is no active class
   if(searchTerm != '') {
      searchBar.classList.add('active');
   }else {
      searchBar.classList.remove('active');
   }

   // Ajax
   // Creating XML object
   let xhr = new XMLHttpRequest();

   xhr.open("POST", "php/search.php", true);
   xhr.onload = () => {

      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            usersList.innerHTML = data;
         }
      }
   }
   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhr.send("searchTerm=" + searchTerm);
}

setInterval(()=> {
   // Ajax
   // Creating XML object
   let xhr = new XMLHttpRequest();

   xhr.open("GET", "php/users.php", true);
   xhr.onload = () => {

      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            let data = xhr.response;
            // if active the active class not contains in search bar then add this data
            if(!searchBar.classList.contains("active")) {
               usersList.innerHTML = data;
            }
            
         }
      }
   }
   xhr.send();
}, 500); // This function will run frecuently after 500ms