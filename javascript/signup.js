const form = document.querySelector(".signup form"),
    continueBtn = form.querySelector(".button input"),
    errorText = form.querySelector(".error-txt");

continueBtn.onsubmit = (e) => 
{
    e.preventDefault(); // Ne pas envoyer le formulaire
}

continueBtn.onclick = () =>
{
    // AJAX
    let xhr = new XMLHttpRequest(); // Création de l'objet XML
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = () => 
    {
        if(xhr.readyState === XMLHttpRequest.DONE)
        {
            if(xhr.status === 200)
            {
                let data = xhr.response;
                if(data == "succés")
                {
                    location.href="users.php";
                }
                else
                {
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }

    // Il faut envoyer les données du formulaire via de l'ajax vers le PHP

    let formData = new FormData(form); // Creation d'un objet
    xhr.send(formData); // Envoie de l'objet vers le PHP
}