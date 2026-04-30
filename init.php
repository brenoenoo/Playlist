<?php
session_start();

if (!isset($_SESSION['musicas'])) {
    $_SESSION['musicas'] = [];
}