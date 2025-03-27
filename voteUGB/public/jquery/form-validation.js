$(function () {
    $("form[name='formulaire']").validate({
        rules: {
            prenom: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            nom: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            email: {
                required: true,
                email: true
            },
            ufr: {
                required: true
            },
            password: {
                required: true,
                minlength: 6
            },
            confpassword: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            prenom: {
                required: "Veuillez entrer votre prénom",
                minlength: "Le prénom doit contenir au moins 2 caractères"
            },
            nom: {
                required: "Veuillez entrer votre nom",
                minlength: "Le nom doit contenir au moins 2 caractères"
            },
            password: {
                required: "Entrer un mot de passe valide",
                minlength: "Votre mot de passe doit contenir au moins 6 caratères"
            },
            email: {
                required: "Veuillez entrer votre email",
                email: "Veuillez entrer un email valide"
            },
            ufr: {
                required: "Veuillez sélectionner votre UFR"
            },
            password: {
                required: "Veuillez entrer un mot de passe",
                minlength: "Le mot de passe doit contenir au moins 6 caractères"
            },
            confpassword: {
                required: "Veuillez confirmer votre mot de passe",
                equalTo: "Les mots de passe ne correspondent pas"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});