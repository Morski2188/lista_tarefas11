<?php

	require "C:/xampp/htdocs/lista_tarefas11/tarefa.model.php";
	require "C:/xampp/htdocs/lista_tarefas11/tarefa.service.php";
	require "C:/xampp/htdocs/lista_tarefas11/conexao.php";


	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	if($acao == 'inserir' ) {
		$tarefa = new Tarefa();
		$tarefa->__set('tarefa', $_POST['tarefa']);
		$tarefa->__set('prazo', $_POST['prazo']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->inserir();

		header('Location: nova_tarefa.php?inclusao=1');
	
	} else if($acao == 'recuperar') {
		
		$tarefa = new Tarefa();
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperar();
		
	
	} else if($acao == 'atualizar') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_POST['id'])
			->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();
		$tarefa->__set('prazo', $_POST['prazo']);

		$tarefaService = new TarefaService($conexao, $tarefa);
		if($tarefaService->atualizar()) {
			
			if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
				header('location: index.php');	
			} else {
				header('location: todas_tarefas.php');
			}
		}


	} else if($acao == 'remover') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->remover();

		if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'marcarRealizada') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->marcarRealizada();

		if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'recuperarTarefasPendentes') {
		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);
		
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperarTarefasPendentes();
	}
	if (isset($_GET['filtro'])) {
		$filtro = $_GET['filtro'];
	
		// Define o filtro na variável de sessão para ser utilizado posteriormente
		$_SESSION['filtro'] = $filtro;
	
		// Redireciona de volta para a página atual para aplicar o filtro
		header("Location: ".$_SERVER['PHP_SELF']);
		exit();
	}
	
	// Verifica se a variável de sessão para o filtro está definida
	if (isset($_SESSION['filtro'])) {
		$filtro = $_SESSION['filtro'];
	
		// Aqui você deve modificar sua lógica de recuperação de tarefas
		// para incluir a aplicação do filtro, dependendo do valor de $filtro
	
		// Exemplo:
		if ($filtro == 'concluidas') {
			// Lógica para recuperar apenas tarefas concluídas
		} elseif ($filtro == 'pendentes') {
			// Lógica para recuperar apenas tarefas pendentes
		} elseif ($filtro == 'todas') {
			// Lógica para recuperar todas as tarefas
		}
	}
	
	


?>