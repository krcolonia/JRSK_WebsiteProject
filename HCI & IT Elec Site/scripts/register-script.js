function privacyPolicyMenu() {
    var menu = document.getElementById("privacyPolicyWindow");
    var button = document.getElementById("privacyPolicyButton");
  
    if(menu.style.display === "none") {
        menu.style.display = "flex";
    }
    else {
        menu.style.display = "none";
    }
  }