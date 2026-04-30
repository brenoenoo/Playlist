<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['deletar_id'])) {

        $_SESSION['musicas'] = array_filter(
            $_SESSION['musicas'],
            fn($m) => $m['id'] !== $_POST['deletar_id']
        );

        header("Location: teste.php");
        exit;
    }

    if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
        $_SESSION['musicas'][] = [
            'id' => uniqid(),
            'nome' => $_POST['nome'],
            'genero' => $_POST['genero'],
            'cantor' => $_POST['cantor'],
            'duracao' => $_POST['duracao'],
            'link' => $_POST['link']
        ];
    }

    if (isset($_POST['acao']) && $_POST['acao'] === 'editar') {
        foreach ($_SESSION['musicas'] as &$m) {
            if ($m['id'] === $_POST['id']) {
                $m['nome'] = $_POST['nome'];
                $m['genero'] = $_POST['genero'];
                $m['cantor'] = $_POST['cantor'];
                $m['duracao'] = $_POST['duracao'];
                $m['link'] = $_POST['link'];
            }
        }
    }

    header("Location: teste.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Playlist</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/cadastrar.css">
    </head>

    <body>
        <main>
            <div class="container-pagina">
                <div class="tabela-header">
                    <div>
                        <h2>Playlist</h2>
                    </div>
                </div>

                <div class="tabela-wrapper">
                    <table class="tabela">
                        <thead>
                            <tr>
                                <th>Música</th>
                                <th>Gênero</th>
                                <th>Cantor</th>
                                <th>Duração</th>
                                <th>Link</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="btn-add-text">
                                    <button class="btn-add" onclick="abrirModal('modalCadastro')">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                    <p>Adicionar música a playlist</p>
                                </td>
                            </tr>

                            <?php if (!empty($_SESSION['musicas'])): ?>

                                <?php foreach ($_SESSION['musicas'] as $musica): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($musica['nome']) ?></td>
                                        <td><?= htmlspecialchars($musica['genero']) ?></td>
                                        <td><?= htmlspecialchars($musica['cantor']) ?></td>
                                        <td><?= htmlspecialchars($musica['duracao']) ?></td>

                                        <td>
                                            <a href="<?= htmlspecialchars($musica['link']) ?>" target="_blank">
                                                Abrir
                                            </a>
                                        </td>

                                        <td class="td-acao">
                                            <button class="btn-acao btn-ver" onclick='abrirVisualizar(<?= json_encode($musica) ?>)'>
                                                <i class="bi bi-eye-fill"></i>
                                            </button>

                                            <button class="btn-acao btn-edit" onclick='abrirEditar(<?= json_encode($musica) ?>)'>
                                                <i class="bi bi-pen-fill"></i>
                                            </button>

                                            <form method="POST">
                                                <button type="submit" class="btn-acao btn-del" onclick="return confirm('Deseja excluir essa música?')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:20px;">
                                        Nenhuma música cadastrada
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </body>

    <div id="modalEditar" class="modal">
        <div class="modal-content">

            <span class="fechar" onclick="fecharModal('modalEditar')">&times;</span>

            <h2 id="tituloModal">Editar Música</h2>

            <form method="POST">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id" id="edit_id">

                <input type="text" name="nome" id="edit_nome">
                <input type="text" name="genero" id="edit_genero">
                <input type="text" name="cantor" id="edit_cantor">
                <input type="text" name="duracao" pattern="^[0-9]{1,2}:[0-5][0-9]$" id="edit_duracao">
                <input type="text" name="link" id="edit_link">

                <button type="submit">Salvar Alterações</button>
            </form>

        </div>
    </div>

    <div id="modalCadastro" class="modal">
        <div class="modal-content">

            <span class="fechar" onclick="fecharModal('modalCadastro')">&times;</span>

            <h2>Nova Música</h2>

            <form method="POST">
                <input type="hidden" name="acao" value="cadastrar">

                <input type="text" name="nome" placeholder="Nome" required>
                <input type="text" name="genero" placeholder="Gênero" required>
                <input type="text" name="cantor" placeholder="Cantor" required>
                <input type="text" name="duracao" pattern="^[0-9]{1,2}:[0-5][0-9]$" placeholder="Duração" required>
                <input type="text" name="link" placeholder="Link" >

                <button type="submit">Salvar</button>
            </form>

        </div>
    </div>

    <div id="modalVisualizar" class="modal">
        <div class="modal-content">

            <span class="fechar" onclick="fecharModal('modalVisualizar')">&times;</span>

            <h2 id="view_nome"></h2>

            <p><strong>Cantor:</strong> <span id="view_cantor"></span></p>
            <p><strong>Gênero:</strong> <span id="view_genero"></span></p>
            <p><strong>Duração:</strong> <span id="view_duracao"></span></p>

            <div id="view_link_box"></div>

        </div>
    </div>
    
    <script>
    function abrirModal(id) {
        document.getElementById(id).style.display = "flex";
    }

    function fecharModal(id) {
        document.getElementById(id).style.display = "none";
    }

    function abrirEditar(musica) {
        abrirModal('modalEditar');

        document.getElementById('edit_id').value = musica.id;
        document.getElementById('edit_nome').value = musica.nome;
        document.getElementById('edit_genero').value = musica.genero;
        document.getElementById('edit_cantor').value = musica.cantor;
        document.getElementById('edit_duracao').value = musica.duracao;
        document.getElementById('edit_link').value = musica.link;
    }

    function abrirVisualizar(musica) {
        abrirModal('modalVisualizar');

        document.getElementById('view_nome').innerText = musica.nome;
        document.getElementById('view_cantor').innerText = musica.cantor;
        document.getElementById('view_genero').innerText = musica.genero;
        document.getElementById('view_duracao').innerText = musica.duracao;

        let linkBox = document.getElementById('view_link_box');

        if (musica.link) {
            linkBox.innerHTML = `<a href="${musica.link}" target="_blank">▶ Ouvir música</a>`;
        } else {
            linkBox.innerHTML = `<p>Sem link disponível</p>`;
        }
    }
    </script>
</html>