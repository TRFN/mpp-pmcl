<?php
    // Este exemplo demonstra como funciona a nomeclatura de funções de chamada para controles.
    // Para cada sub-diretório, usa-se {nome-do-dir}_..._{nome-do-arquivo}. Veja abaixo:

    /*
        ctrl -> Inicio de nome de todo controle (para evitar duplicidade)
        formulario -> Sub-dir. Se ainda existisse uma pasta dentro de formulario chamada versao2, ficaria ctrl_formularios_(versao2)_processar
        processar -> nome do arquivo (sem extensão)
        $ctx -> variável que armazenará o contexto para interatividade com o motor
        _ [UNDERLINE] -> serve para representar o espaço entre cada palavra chave.
    */

    function ctrl_formularios_processar($ctx){
        /*
            classe de sessões
        */

        $sessao = new sessoes(
            "contas", // nome do banco de dados
            true // debug. se true, não criptografa o DB. se falso (padrão), encripta as informações.
        );

        // Exemplo de criação de contas.

        $sessao->criar_conta(array(
            "email" => "tulio.nasc95@gmail.com",
            "senha" => "12345"
        ));

        // Exemplo de variável de ambiente

        if($sessao->conectado()){
            $ctx->regVarStrict("msg","Você está conectado como: {$sessao->conexao()->email}. <a href='/sair-123'>Logout</a>");
        } else $ctx->regVarStrict("msg",'Aguardando login...');

        if(!isset($_POST["email"])){
            $ctx->regVarStrict("mensagem-erro","");
            $ctx->regVarStrict("email","");
        } else {
            if(!$sessao->login($_POST)){
                if($sessao->erros->login=="conexao_existente"){
                    $sessao->logout();
                    $erro = !$sessao->login($_POST);
                } else {
                    $erro = true;
                }
            }

            if($erro){
                $ctx->regVarStrict("msg",'Usuario e/ou senha incorreto(s). Tente novamente.');
            } else {
                $ctx->regVarStrict("msg","Você está conectado como: {$sessao->conexao()->email}. <a href='/sair-123'>Logout</a>");
            }
        }
    }
?>
