 <?php 

class Classe {

    public function __construct() {
        
    }

    public function checkUsername($username) {

        if (strlen($username) < 6) {
            return "min  6 chr";
            
        } else if (strlen($username) > 12) {
            return "max  12 chr";
        }

        if (!ctype_alnum($username)) {
            return "chr alfanumerici";
        }
        return true;
    }

    public function checkPassword($password) {

        if (strlen($password) < 8) {
            return "min  8 chr";
        } else if (strlen($password) > 12) {
            return "max  12 chr";
        }

        if (!preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) {
            return "password non valida";
        }
     
        return true;
    }

    public function aggiornaSicurezza($user, $post) {
        
        foreach ($post as $key => $value) {
            ${$key} = $value;
        }

        $checkUsername = $this->checkUsername($username);
        if ($checkUsername !== true) {
            return $checkUsername;
        }

        $checkPassword = $this->checkPassword($password);
        if ($checkPassword !== true) {
            return $checkPassword;
        }
        
        $user->setUsername($username);
        $user->setPassword($password);
        
        if (UtenteGenericoFactory::instance()->salva($user) != 1) {
                echo '<p class="messaggio">Salvataggio fallito</p>';
        }
        
        return  true;
    }
}

?>