<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'delete') {
	// pegando o PUT com o php
	parse_str(file_get_contents('php://input'), $input);

	// se não estiver usando PHP7.4, usa esse código
	// $id = (!empty($input['id'])) ? $input['id'] : null;

	// poderia ficar assim
	// $id = filter_var($input['id'] ?? null);

	$id = $input['id'] ?? null; // PHP7.4

	$id = filter_var($id);

	if ($id) {
		// consulta para saber o id existe
		$sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		if ($sql->rowCount() > 0) {

			$sql = $pdo->prepare("DELETE FROM notes WHERE id = :id");
			$sql->bindValue(':id', $id);
			$sql->execute();

			$array['result'] = 'Note DELETADO com sucesso!';

		} else {
			$array['error'] = 'ID não existe.';
		}
	} else {
		$array['error'] = 'ID não enviados';
	}

} else {
	$array['error'] = 'Método não permitido (apenas DELETE)';
}

require('../return.php');