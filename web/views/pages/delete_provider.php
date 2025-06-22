<?php
// web/views/pages/delete_provider.php
require_once '../../../api/models/connection.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /views/pages/providers_list.php');
    exit;
}

$link = Connection::connect();
$stmt = $link->prepare("DELETE FROM providers WHERE id = ?");
$stmt->execute([$id]);

header('Location: /views/pages/providers_list.php?deleted=1');
exit;
