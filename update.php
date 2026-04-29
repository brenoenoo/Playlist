<?php
require_once 'crud.php';

$idLivro = 676;

$dadosAtualizados = [
    'titulo' => 'Magia Negra for Dummies',
    'isbn' => '9781118008188',
    'autor' => 'Leticia',
    'preco' => '299.99',
    'situacao' => 'Disponivel',
    'categoria' => 'Outros'
];

$linhasAfetadas = update($pdo, 'livros', $dadosAtualizados, 'id = '.$idLivro);
if ($linhasAfetadas > 0) {
    echo 'Livro atualizado com sucesso!!!';
} else {
    echo 'Não foi possível atualizar o livro!!!';
}