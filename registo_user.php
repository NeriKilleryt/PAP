<?php
$title = 'Registar Utilizador';
require(__DIR__ . '/inc/header.php');
?>
<section class="container mt-5">
    <main class="row">
        <div class="col-4"></div>
        <!-- Apresentação do formulário -->
        <section class="col-4 border rounded bg-primary-subtle text-primary-emphasis">
            <p class="h2 d-flex justify-content-center">Registar</p>
            <form action="insere_user.php" method="post">
                <div class="mb-4">
                    <input type="text" class="form-control" name="nome" style="width:300;" placeholder="Nome Válido" required>
                </div>
                <div class="mb-4">
                    <input type="email" class="form-control" name="email" style="width:300;" placeholder="Email Válido" required>
                </div>
                <div class="mb-4">
                    <input type="password" class="form-control" name="password" style="width:300;" placeholder="Password" required>
                </div>
                <div class="mb-4">
                    <input type="date" class="form-control" name="data_nascimento" style="width:300;" placeholder="Data de Nascimento" required>
                </div>
                <div class="mb-4">
                    <input type="text" class="form-control" name="contacto" style="width:300;" placeholder="Contacto" required>
                </div>
                <div class="mb-4">
                    <select class="form-control" name="perfil" style="width:300;" required>
                        <option value="">Selecione o Perfil</option>
                        <option value="3">Colaborador</option>
                        <option value="2">Utilizador</option>
                    </select>
                </div>

                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary cursor-pointer" name="submitBtn">Registar</button>
                </div>
            </form>
        </section>
    </main>
</section>
<?php
require(__DIR__ . '/inc/footer.php');
?>