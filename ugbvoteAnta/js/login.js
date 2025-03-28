$(document).ready(function() {
    
    $("#loginForm").submit(function(event) {
        
        event.preventDefault();

        
        var email = $("#email").val();
        var password = $("#password").val();

        // Réinitialiser les messages d'erreur
        $("#message").removeClass("d-none alert-success alert-danger").text("");

        // Validation de l'email
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            $("#message").addClass("alert-danger").text("L'email n'est pas valide.").removeClass("d-none");
            return; 
        }

        // Validation du mot de passe (au moins 6 caractères)
        if (password.length < 6) {
            $("#message").addClass("alert-danger").text("Le mot de passe doit comporter au moins 6 caractères.").removeClass("d-none");
            return; 
        }

        
        this.submit(); 
    });
});
