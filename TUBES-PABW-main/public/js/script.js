document.addEventListener("DOMContentLoaded", function() {
    const menuIcon = document.getElementById("menu-icon");
    const menuList = document.getElementById("menu-list");
    const commentForm = document.querySelector('.komen form');
    const commentInput = document.querySelector('.comment-input');

  
    menuIcon.addEventListener("click", function() {
        menuList.classList.toggle("hidden");
    });

    commentForm.addEventListener('submit', function(event) {
        event.preventDefault(); 
        commentInput.value = ''; 
    });
    });
