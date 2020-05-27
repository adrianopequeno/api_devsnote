<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'put') {
	// pegando o PUT com o php
	parse_str(file_get_contents('php://input'), $input);

	// se não estiver usando PHP7.4, usa esse código
	// $id = (!empty($input['id'])) ? $input['id'] : null;
	// $title = (!empty($input['title'])) ? $input['title'] : null;
	// $body = (!empty($input['body'])) ? $input['body'] : null;

	// poderia ficar assim
	// $id = filter_var($input['id'] ?? null);

	$id = $input['id'] ?? null; // PHP7.4
	$title = $input['title'] ?? null; // PHP7.4
	$body = $input['body'] ?? null; // PHP7.4

	$id = filter_var($id);
	$title = filter_var($title);
	$body = filter_var($body);

	if ($id && $title && $body) {
		$sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
		$sql->bindValue(':id', $id);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$sql = $pdo->prepare("UPDATE notes SET title = :title, body = :body WHERE id = :id");
			$sql->bindValue(':id', $id);
			$sql->bindValue(':title', $title);
			$sql->bindValue(':body', $body);
			$sql->execute();

			// retorno
			$array['result'] = [
				'id' => $id,
				'title' => $title,
				'body' => $body
			];
		} else {
			$array['error'] = 'ID não existe.';
		}
	} else {
		$array['error'] = 'Dados não enviados';
	}

} else {
	$array['error'] = 'Método não permitido (apenas PUT)';
}

require('../return.php');