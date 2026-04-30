<?php
require_once 'crud.php';
// titulo, isbn, autor, preco, situacao, categoria
// $novoLivro = [
//     'titulo' => 'PHP for Dummies',
//     'isbn' => '9781118008188',
//     'autor' => 'John Doe',
//     'preco' => '299.99',
//     'situacao' => 'Disponivel',
//     'categoria' => 'Informatica'
// ];

// $idLivroNovo = create($pdo, 'livros', $novoLivro);
// echo 'novo livro inserido com ID: '.$idLivroNovo;

$novaMusica[] = [
    'nome' => $_POST['nome'],
    'genero' => $_POST['genero'],
    'cantor' => $_POST['cantor'],
    'duracao' => $_POST['duracao'],
    'link' => $_POST['link']
];

$idMusicaNova = create($pdo, 'livros', $novaMusica);
// echo 'novo livro inserido com ID: '.$idLivroNovo;
if ($idMusicaNova) {
    header("Location: index.php");
    exit;
}