<?php
    session_start();
    include_once "config.php";
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $nom  = mysqli_real_escape_string($conn, $_POST['nom']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $mdp = mysqli_real_escape_string($conn, $_POST['mdp']);

    if(!empty($prenom) &&!empty($nom) && !empty($email) && !empty($mdp))
    {
        // Vérification de la validité de l'email
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            // Si l'email est valide 
            // Vérifier si l'emaail existe déjà dans la bdd 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0)
            {
                echo "$email existe déjà";
            }
            else
            {
                // Regarde si l'utilisateur a uploadé une image
                if(isset($_FILES['images']))
                {
                    // Si l'image est bien uploadé
                    $img_name = $_FILES['image']['name']; // Nom de l'image de l'utilisateur
                    $img_type = $_FILES['image']['type']; // Type de l'image
                    $img_name = $_FILES['image']['tmp_name']; // Nom temporaire pour sauvegarder/bouger l'image

                    // Récupération de l'extension de l'image (png/jpg/jpeg)
                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode); // La on a l'extension

                    $extensions = ['png', 'jpeg', 'jpg'];
                    if(in_array($img_ext, $extensions) === true) // regarde si l'extension match avec les extensions du tableau 
                    {
                        $time = time(); // moment de l'inscription pour donner un nom unique à chaque image

                        $new_img_name = $time.$img_name;
                        if(move_uploaded_file($tmp_name, "images/users_img/".$new_img_name)) // Si l'image est dans notre fichier
                        {
                            $status = "Actif"; // Quand l'utilisateur est connecté il obtient le status actif
                            $random_id = rand(time(), 10000000);

                            // Insertion des données utilisateurs

                            $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, prenom, nom, email, password, img, status)
                                                        VALUES ({$random_id}, '{$prenom}, '{$nom}, '{$email}, '{$password}, '{$new_img_name}, '{$status},')");

                            if($sql2) // Si les données sont déjà présentes
                            {
                                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if(mysqli_num_rows($sql3) > 0)
                                {
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['unique_id']; // Utilisation de l'id unique dans les autres fichiers php
                                    echo"succés";
                                }
                            }
                            else
                            {
                                echo"Une erreur c'est produite";
                            }
                        }
                            
                    }
                    else
                    {
                        echo "Il faut selectionner une image en jpg, jpeg, png";
                    }
                }
                else
                {
                    echo "Choississez une image de profil";
                }
            }

        }
        else
        {
            // Si l'email est invalide
            echo "$mail n'est pas une adresse mail valide";
        }
    }
    else
    {
        echo "Tout les champs sont requis !";
    }
?>