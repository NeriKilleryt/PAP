<?php
// Incluir o cabeçalho
require(__DIR__ . '/inc/header.php');

$title = 'Contato';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Contatos</h1>
    <p class="text-center">Entre em contato com as lojas abaixo para mais informações:</p>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Loja</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Leroy Merlin</td>
                        <td>21 194 4944</td>
                    </tr>
                    <tr>
                        <td>Aury MAT</td>
                        <td>261 417 200</td>
                    </tr>
                    <tr>
                        <td>Worten</td>
                        <td>21 015 5222</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Incluir o rodapé
require __DIR__ . '/inc/footer.php';
?>