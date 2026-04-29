<?php
require_once 'crud.php';

$idLivro = 674;

$deleted = delete($pdo, 'livros', 'id = '.$idLivro);

if ($deleted) {
    echo 'Livro excluido com sucesso';
} else {
    echo 'Não foi possivel excluir o livro';
}