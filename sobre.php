<?php
//vai incluir o ficheiro header.php que se encontra na pasta inc.
require(__DIR__ . '/inc/header.php');

$title = 'Sobre a WikiFerramentas';
?>

<style>
    .card-border-radius {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin: 20px auto;
        max-width: 800px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
        width: 50px;
        height: 50px;
    }
    .ler-mais {
    background-color: #007bff;
    color: white;
    font-size: 16px;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
  }

  .ler-mais:hover {
    background-color: #0056b3;
    transform: scale(1.05);
    box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.2);
  }
</style>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card mb-5 card-border-radius">
        <img src="public/images/logo (5).ico" class="card-img-top mx-auto mt-3" alt="Logo">
        <div class="card-body text-center">
            <h5 class="card-title">Sobre a WikiFerramentas</h5>
            <p class="card-text">Pode saber os preços das ferramentas modernas e onde pode comprar as ferramentas. Além disso, pode criar a sua própria lista personalizada.</p>
        </div>
    </div>
</div>

<?php
//vai incluir o ficheiro footer.php que se encontra na pasta inc.
require __DIR__ . '/inc/footer.php';
?>