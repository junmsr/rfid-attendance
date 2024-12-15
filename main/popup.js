document.querySelector("#admin-login").addEventListener("click", function(){
    document.querySelector(".modal").classList.add("active")
    document.getElementById("box").style.filter = "blur(5px)";
    document.getElementById("username").value = "";
    document.getElementById("password").value = "";
});
document.querySelector(".modal .close-btn").addEventListener("click", function(){
    document.querySelector(".modal").classList.remove("active")
    document.getElementById("box").style.filter = "none";
    document.getElementById("message").innerHTML = "";
});

document.querySelector(".form-element button").addEventListener("click", function (event) {
    // Prevent the default form submission
    event.preventDefault();

    // Get the input values
    const username = document.querySelector('input[type="text"]').value;
    const password = document.querySelector('input[type="password"]').value;
    
    // Predefined credentials (for demonstration purposes only)
    const validUsername = "admin";
    const validPassword = "capstone";

    // var input = document.getElementById("submit");

    // // Execute a function when the user presses a key on the keyboard
    // input.addEventListener("keypress", function(event) {
    // // If the user presses the "Enter" key on the keyboard
    // if (event.key === "Enter") {
    //     // Cancel the default action, if needed
    //     event.preventDefault();
    //     // Trigger the button element with a click
    //     document.getElementById("submit").click();
    // }
    // }); 

    // Check the credentials
    if (username === validUsername && password === validPassword) {
        // Optionally close the modal and unblur the background
        window.location.href = "../admin/admin.php";
        document.querySelector(".modal").classList.remove("active");
        document.getElementById("box").style.filter = "none";
    } else{
        document.getElementById("message").innerHTML = "Invalid username or password."
    }
});