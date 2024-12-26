<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}

echo "<pre>";
var_dump($this->data['form']); //var_dump($this->data['form'][0]['email']);
echo "</pre>";

?>

<h1>Editar Usuário</h1>

<?php
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-user">
    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome: </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php echo $name; ?>" required><br><br>

    <?php
    $nickname = "";
    if (isset($valorForm['nickname'])) {
        $nickname = $valorForm['nickname'];
    }
    ?>
    <label>Nickname: </label>
    <input type="text" name="nickname" id="nickname" placeholder="Digite o apelido" value="<?php echo $nickname; ?>" required><br><br>


    <?php
    $email = "";
    if (isset($valorForm['email'])) {
        $email = $valorForm['email'];
    }
    ?>
    <label>E-mail: </label>
    <input type="email" name="email" id="email" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>" required><br><br>

    <?php
    $user = "";
    if (isset($valorForm['user'])) {
        $user = $valorForm['user'];
    }
    ?>
    <label>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário para acessar o administrativo" value="<?php echo $user; ?>" required><br><br>



    <button type="submit" name="SendAddUser" value="Cadastrar">Cadastrar</button>
</form>
<p><a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar</p>
