<?php

echo "<h2>Listar Usuários</h2>";

echo "<a href='" . URLADM . "add-users/index'>Cadastrar</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listUsers'] as $user) {
    //var_dump($user);
    extract($user);
    //echo "ID: " . $user['id'] . "<br>";
    echo "ID: $id <br>";
    echo "Nome: $name <br>";
    echo "E-mail: $email <br>";
    echo "<a href='" . URLADM . "view-users/index/$id'>Visualizar</a><br>";
    echo "<hr>";
}
