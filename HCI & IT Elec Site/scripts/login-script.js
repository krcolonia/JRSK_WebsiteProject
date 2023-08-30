function emptyForm() {
    alert("Please fill in all fields.");
    window.location.href="login.php";
}

function loginSuccess() {
    alert("Login Successful.");
    window.location.href="home.php";
}

function loginFailed() {
    alert("Your Login Name or Password is Invalid");
    window.location.href="login.php";
}