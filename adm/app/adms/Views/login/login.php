<?php
    //form action empty, it means that the Controller will receive the form
    if (isset($this->data['form']))
        $valorForm = $this->data['form'];

?>
<h1>Área Restrita</h1>
<form method="POST" action=""> 

    <label>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário" value="<?php if (isset($valorForm['user'])) echo $valorForm['user']; ?>"><br><br>

    <label>Senha: </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha"><br><br>

    <input type="submit" name="SendLogin" value="Acessar">
</form>