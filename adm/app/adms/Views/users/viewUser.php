<?php

echo "<h2>Detalhes do Usuário</h2>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewUser'])) {
    //var_dump($this->data['viewUser'][0]);
    extract($this->data['viewUser'][0]);
    echo "ID: $id <br>";
    echo "Nome: $name_usr <br>";
    echo "Apelido: $nickname <br>";
    echo "E-mail: $email <br>";
    echo "Usuário: $user <br>";
    echo "Imagem: $image <br>";
    echo "Situação do Usuário: <span style='color: $color;'>$name_sit</span><br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    echo "Editado: ";
    if(!empty($modified)){
        echo date('d/m/Y H:i:s', strtotime($modified));
    }
    echo "<br>";
}
