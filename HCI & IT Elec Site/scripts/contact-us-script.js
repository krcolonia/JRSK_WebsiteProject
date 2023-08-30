function sendMail() {
    var params = {
        firstName: document.getElementById("firstName").value,
        lastName: document.getElementById("lastName").value,
        email: document.getElementById("email").value,
        inquiry: document.getElementById("inquiry").value,
    };

const serviceID = "service_jbp0vs8";
const templateID = "template_1zy7leb";

emailjs.send(serviceID, templateID, params).then((res) => {
            document.getElementById('firstName').value = "";
            document.getElementById('lastName').value = "";
            document.getElementById('email').value = "";
            document.getElementById('inquiry').value = "";
            console.log(res);
            alert("Message Sent Successfully");
        });
}

