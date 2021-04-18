<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>

<?php
    $localhost = "localhost";
    $user = "root";
    $senha = "";
    $db = "pet";
    $id = 1;
    $cadastro = "<h2 class='resposta2'>.</h2>";
    
    $conexao = mysqli_connect($localhost,$user,$senha,$db);
    
    if(mysqli_connect_errno($conexao)){
        echo "Erro ao tentar se conectar com o banco de dados! Erro: ".mysqli_connect_error();
    }
    //Cadastro Clientes
    else{
        if (isset($_POST['cadastro'])){

        $cpf = $_POST['cpf']; // Antes de cadastrar o CPF é consultado no Banco de dados.

        $sql = "SELECT CPF FROM cadastro_cliente WHERE CPF = '$cpf'";
        $result = mysqli_query($conexao,$sql);
        $row = mysqli_fetch_assoc($result);
        
            if($row > 0){ 
                //Caso a pesquisa consta com verdadeiro o cadastro não seguira em frente.
                $cadastro = $cpf." já possui cadastro!";
            }
            
            else{
                $email = $_POST['email'];// Depois de verificar o CPF, o email será verificado

                $sql = "SELECT EMAIL FROM cadastro_cliente WHERE EMAIL = '$email'";
                $result2 = mysqli_query($conexao,$sql);
                $row2= mysqli_fetch_assoc($result2);

                if($row2 > 0){
                    $cadastro = $email." ja possui cadastro!";
                }
                // Caso CPF e Email não constar ja cadastrado, segue com cadastro...
                else{
                    $sql = "SELECT ID FROM cadastro_cliente ORDER BY id DESC LIMIT 1";
                    $consulta = mysqli_query($conexao,$sql);
                    
                    // Geração de ID a partir do ultimo ID registrado no Banco de Dados.
                    while($clientes_array = mysqli_fetch_array($consulta)){
                        $identifica = $clientes_array['ID'];
                        $id = $identifica + 1; 
                    }
            
                    $sql = "INSERT INTO cadastro_cliente (id,nome,cpf,email,senha,endereco,numero,complemento,bairro,estado,cidade,telefone) VALUES(
                        $id,
                        '$_POST[nome]',
                        '$_POST[cpf]',
                        '$_POST[email]',
                        '$_POST[senha]',
                        '$_POST[endereco]',
                        '$_POST[numero]',
                        '$_POST[complemento]',
                        '$_POST[bairro]',
                        '$_POST[estado]',
                        '$_POST[cidade]',
                        '$_POST[telefone]'
                        )";

                    if(mysqli_query($conexao,$sql)){
                        $cadastro = "Cadastrado concluido com sucesso";
                    }
                    else{
                        echo "Erro ao inserir cliente! Erro: ".mysqli_error($conexao);
                        $cadastro = "Erro ao cadastrar";
                    }    
                }
            }
        }
        mysqli_close($conexao);
    }
?>

<body>
    <div class="mestre">

        <div class="card">
        <div class="header"><h2>Cadastrar</h2> </div>
        
            <div class="formulario-card">
            <form name="cadastro" method="POST" action="Cadastro.php">
                <!--<p class="form2">Nome</p> -->
                <input type="text" placeholder="Nome" name="nome"class="form-campo" required>

            
                <!-- <p class="form2">CPF</p> -->
                <input type="text" placeholder="CPF" name="cpf"class="form-campo" oninput="mascara(this)">

                <!-- <p class="form2">E-mail</p> -->
                <input type="email" placeholder="E-mail" name="email"class="form-campo">

                <!-- <p class="form2">Senha</p> -->
                <input type="password" placeholder="Senha" name="senha" id ="senha" class="form-password">

                <input type="password" placeholder="Confirmar senha" name="senha2" id="senha2" class="form-password">

                <!-- <p class="form2">Endereço</p> -->
                <input type="text" placeholder="Endereço" name="endereco"class="form-campo">

                <!-- <p class="form2">Nº</p> -->
                <input type="number" placeholder="Nº" name="numero" class="form-numero">
                <input type="text" placeholder="Complemento" name="complemento" class="form-complemento">

                <!-- <p class="form2">Bairro</p> -->
                <input type="text" placeholder="Bairro" name="bairro" class="form-campo">
                <p> </p>
                <!-- <p  class="form2">Estado / Cidade</p> -->
                <select id="estado" name="estado" class="form-estado">
                    <option value="AC">AC</option>
                    <option value="AL">AL</option>
                    <option value="AP">AP</option>
                    <option value="AM">AM</option>
                    <option value="BA">BA</option>
                    <option value="CE">CE</option>
                    <option value="DF">DF</option>
                    <option value="ES">ES</option>
                    <option value="GO">GO</option>
                    <option value="MA">MA</option>
                    <option value="MT">MT</option>
                    <option value="MS">MS</option>
                    <option value="MG">MG</option>
                    <option value="PA">PA</option>
                    <option value="PB">PB</option>
                    <option value="PR">PR</option>
                    <option value="PE">PE</option>
                    <option value="PI">PI</option>
                    <option value="RJ">RJ</option>
                    <option value="RN">RN</option>
                    <option value="RS">RS</option>
                    <option value="RO">RO</option>
                    <option value="RR">RR</option>
                    <option value="SC">SC</option>
                    <option value="SP" selected>SP</option>
                    <option value="SE">SE</option>
                    <option value="TO">TO</option>
                </select>

                <input type="text" placeholder="Cidade" name="cidade" class="form-cidade">

                <!-- <p class="form2">Telefone</p> -->
                <input type="text" placeholder="Contato" name="telefone" id="telefone" class="form-campo" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" >

                <a href="http://localhost/TCC/Cadastrar.php"> <button class="button3"> Voltar</button> </a>

                <p class="resposta">
                    
                <?php echo $cadastro; ?>
                
                </p>

                <button type="submit" value="Cadastrar" class="button2" name="cadastro" onClick="validarSenha()" id="Cadastrar"style="display:invisible">Cadastrar</button>
                
            </form>
            </div> 
        </div>
    </div>
</body>
<script type="text/javascript" src="script.js"></script>
</html>