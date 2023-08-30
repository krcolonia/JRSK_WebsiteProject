function navbarMenu() {
    var menu = document.getElementById("dropdown");
    var button = document.getElementById("navButton");
  
    if(menu.style.display === "none") {
        menu.style.display = "block";
    }
    else {
        menu.style.display = "none";
    }
  }