document.getElementById("submit-button").addEventListener("click", sendPutRequest);

async function sendPutRequest() {
    let newEmail = document.getElementById("email").value;
    let newLogin = document.getElementById("login").value;
    let newPassword = document.getElementById("password").value;
    let superAdmin = document.getElementById("super-admin").value;
    let _id = document.getElementById("id").value;

    let url = "/admins/update";

    let newAdminInfo = {
        email: newEmail,
        login: newLogin,
        password: newPassword,
        super_admin: superAdmin,
        id: _id
    };

    let putRequest = {
        method: "PUT",
        body: JSON.stringify(newAdminInfo)
    };

    let response = await fetch(url, putRequest);

    if (response.ok !== false) {
        window.location="/admins/";
    } else {
        let errorField = document.getElementById("error-field");
        errorField.innerHTML = "Wrong name or email";
    }
}