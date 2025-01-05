<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}

// echo "<pre>";
// var_dump($this->data['form']); //var_dump($this->data['form'][0]['email']);
// echo "</pre>";

?>

<h1>Editar Senha</h1>

<?php

echo "<a href='" . URLADM . "list-users/index'>Listar</a><br>";
if (isset($valorForm['id'])) {
  echo "<a href='" . URLADM . "view-users/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-edit-user-pass">

    <?php
    $id = "";
    if (isset($valorForm['id'])) {
        $id = $valorForm['id'];
    }
    ?>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

    <?php
    $password = "";
    if (isset($valorForm['password'])) {
        $password = $valorForm['password'];
    }
    ?>
    <label>Senha:<span style="color: #f00;">*</span> </label>
    <input type="password" name="password" id="password" onkeyup="passwordStrength()" autocomplete="on" placeholder="Digite a nova senha" value="<?php echo $password; ?>" required><br><br>
    <span id="msgViewStrength"><br><br></span>

    <label><span style="color: #f00;">* Campo Obrigatório</span> </label><br><br>



    <button type="submit" name="SendEditUserPass" value="Salvar">Salvar</button>
</form>
