<?php
    function ctrl_logout(){ // Carregamento do contexto não é obrigatório
        $sessao = new sessoes("contas", true);
        $sessao->logout();
    }
?>
