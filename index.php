<?php
require_once 'classe-pessoa.php';
$p = new Pessoa("bd", "host", "user", "password");
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <title>Cadastro de Pessoa</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Link CSS -->
    <link rel="stylesheet" href="estilo.css">
    <!-- DATATABLES -->
    <script src="jquery/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js">
    </script>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <div class="row">
                <h2 id="tit-sist">Sistema CRUD <i class="fab fa-php"></i></h2>
            </div>
            <div class="row"><small>CREATE | READ | UPDATE | DELETE</small></div>
        </div>

    </nav>
    <?php 
if(isset($_GET['id'])){
    $id_pessoa = addslashes($_GET['id']);
    $p->excluirPessoa($id_pessoa);
    header("location: index.php");
}

?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p id="make-pdo">Desenvolvido usando PDO</p>
            </div>
        </div>
    </div>
    <div id="main" class="container">
        <div class="row">
            <?php 
                    if(isset($_POST['nome'])){
                        if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
                            $id_upd = addslashes($_GET['id_up']);
                            $nome = addslashes($_POST['nome']);
                            $telefone = addslashes($_POST['telefone']);
                            $email = addslashes($_POST['email']);
                            if(!empty($nome) && !empty($telefone) && !empty($email)){
                                $p->atualizarDados($id_upd, $nome, $telefone, $email);           
                                header("location: index.php");                
                            }else{
                                ?>
            <div class="aviso">
                <img src="aviso.png" height="60" alt="aviso">
                <h5>Preencha todos os campos!</h5>
            </div>
            <?php
                            } 
                        }else{
                            $nome = addslashes($_POST['nome']);
                            $telefone = addslashes($_POST['telefone']);
                            $email = addslashes($_POST['email']);
                            if(!empty($nome) && !empty($telefone) && !empty($email)){
                                if(!$p->cadastrarPessoa($nome, $telefone, $email)){            
                                    ?>
            <div class="aviso">
                <img src="aviso.png" height="60" alt="aviso">
                <h5>E-mail já cadastrado</h5>
            </div>
            <?php
                                }
                            }else{
                                ?>
            <div class="aviso">
                <img src="aviso.png" height="60" alt="aviso">
                <h5>Preencha todos os campos!</h5>
            </div>
        </div>
        <div class="row">
            <?php
                                } 
                            }       
                        }
                ?>
            <?php 
            if (isset($_GET['id_up'])) {
                $id_update = addslashes($_GET['id_up']);
                $res = $p->buscarDadosPessoa($id_update);
            }
            ?>
            <div class="col-sm-12 col-md-12 col-lg-4">
                <section id="esquerda">
                    <form method="post">
                        <h2>Cadastrar Contatos</h2>
                        <label for="nome">Nome</label>
                        <input class="form-control input_i" value="<?php if(isset($res)){echo $res['nome'];} ?>"
                            type="text" name="nome" id="nome">
                        <label for="telefone">Telefone</label>
                        <input class="form-control input_i" value="<?php if(isset($res)){echo $res['telefone'];} ?>"
                            type="text" name="telefone" id="telefone" maxlength="15">
                        <label for="email">E-mail</label>
                        <input class="form-control input_i" value="<?php if(isset($res)){echo $res['email'];} ?>"
                            type="email" name="email" id="email">
                        <input class="btn btn-dark" type="submit"
                            value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";} ?>">
                    </form>
                </section>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-8">
                <section id="direita" class="">
                    <table id="table_id" class="table table-striped table-sm table-responsive">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 200px">Nome</th>
                                <th style="width: 150px">Telefone</th>
                                <th style="width: 280px">E-mail</th>
                                <th style="width: 100px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php        
                        $dados = $p->buscarDados();
                        if(count($dados) > 0){
                            for ($i=0; $i < count($dados); $i++) {
                                echo "<tr>";
                                foreach($dados[$i] as $k => $v){
                                    if($k != "id"){
                                        echo "<td style='font-size: 10pt;'>".$v."</td>";
                                    }
                                }
                                ?>
                            <td>
                                <a class="text-success" href="index.php?id_up=<?php echo $dados[$i]['id']?>">Editar</a>
                                <a class="text-danger" href="index.php?id=<?php echo $dados[$i]['id']?>">Excluir</a>
                            </td>
                            <?php
                                echo "</tr>";
                            }                            
                        }else{
                            ?>
                        </tbody>
                    </table>
                    <!-- <div class="aviso">
                                <h4>Ainda não há pessoas cadastradas</h4>
                            </div>             -->
                    <?php
                        }
                        ?>
                </section>
            </div>
            <!-- Optional JavaScript -->
            <script>
                function mascara(o, f) {
                    v_obj = o
                    v_fun = f
                    setTimeout("execmascara()", 1)
                }

                function execmascara() {
                    v_obj.value = v_fun(v_obj.value)
                }

                function mtel(v) {
                    v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
                    v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
                    v = v.replace(/(\d)(\d{4})$/, "$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
                    return v;
                }

                function id(el) {
                    return document.getElementById(el);
                }
                window.onload = function () {
                    id('telefone').onkeyup = function () {
                        mascara(this, mtel);
                    }
                }
            </script>
            <script>
                $(document).ready(function () {
                    $('#table_id').DataTable({
                        "language": {
                            "sLengthMenu": "Mostrando <select>" +
                                "<option value='5'>5</option>" +
                                "<option value='10'>10</option>" +
                                "<option value='20'>20</option>" +
                                "</select> registros por página",
                            "pageLength": 05,
                            "zeroRecords": "Nada encontrado",
                            "info": "Mostrando _PAGE_ de _PAGES_",
                            "infoEmpty": "Nenhum dado disponível",
                            "infoFiltered": "(filtrado de _MAX_ registros no total)",
                            "sSearch": "Pesquisar",
                            "oPaginate": {
                                "sFirst": "Primeira",
                                "sPrevious": "Anterior",
                                "sNext": "Próxima",
                                "sLast": "Última"
                            }
                        }
                    });
                });
            </script>
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->

            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
                crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                crossorigin="anonymous"></script>
        </div>
    </div>
</body>

</html>