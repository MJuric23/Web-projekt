<?php
session_start(); // Pokretanje sesije

$imeKorisnika = isset($_SESSION['korisnik_ime']) ? htmlspecialchars($_SESSION['korisnik_ime']) : null;
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web projekt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

    <!-- Navbar --> 
    <nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="pocetna.php">ParfemiShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="proizvodi.php">
                        <i class="bi bi-bag"></i>  
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#kosaricaModal">
                        <i class="bi bi-cart3"></i>
                        <span class="badge bg-secondary">0</span>
                    </a>
                </li>

                <?php if ($imeKorisnika): ?>
                    <!-- Prikaz imena prijavljenog korisnika -->
                    <li class="nav-item">
                        <span class="nav-link">Dobrodošli, <?= $imeKorisnika ?>!</span>
                    </li>
                    <!-- Gumb za odjavu -->
                    <a class="nav-link" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i> Odjava
                    </a>
                <?php else: ?>
                    <!-- Gumb za registraciju/prijavu -->
                    <li class="nav-item">
                        <a class="nav-link" href="registracija_login.html">
                            <i class="bi bi-person"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    
    

<!-- Hero Sekcija sa Carousel-om -->
<!-- Carousel -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">

    <!-- Indicators/dots -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
    </div>
  
    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://via.placeholder.com/1200x500" alt="Los Angeles" class="d-block w-100">
        <div class="carousel-caption">
            <h3></h3> <!--Naslov ako treba-->    
            <p></p><!-- podnaslov ako treba -->
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://via.placeholder.com/1200x500" alt="Chicago" class="d-block w-100">
      </div>
      <div class="carousel-item">
        <img src="https://via.placeholder.com/1200x500" alt="New York" class="d-block w-100">
      </div>
    </div>
  
    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>



    <!-- Product Gallery -->
    <div class="container my-5">
        <div class="row text-center">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Proizvod 1">
                    <div class="card-body">
                        <h5 class="card-title">Proizvod 1</h5>
                        <p class="card-text">Opis proizvoda 1.</p>
                        <p class="card-text fw-bold">Cijena: 100€</p>
                        <a href="proizvodi.php" class="btn btn-outline-primary">Detaljnije</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Proizvod 2">
                    <div class="card-body">
                        <h5 class="card-title">Proizvod 2</h5>
                        <p class="card-text">Opis proizvoda 2.</p>
                        <p class="card-text fw-bold">Cijena: 200€</p>
                        <a href="proizvodi.php" class="btn btn-outline-primary">Detaljnije</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Proizvod 3">
                    <div class="card-body">
                        <h5 class="card-title">Proizvod 3</h5>
                        <p class="card-text">Opis proizvoda 3.</p>
                        <p class="card-text fw-bold">Cijena: 90€</p>
                        <a href="proizvodi.php" class="btn btn-outline-primary">Detaljnije</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

<!-- Footer -->
<footer class="bg-light text-center text-lg-start">
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">ParfemiShop</h5>
                <p>
                    Inspiracija za mirise sa tradicijom i stilom.
                </p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0"></div> <!-- Prazna kolona za balansiranje -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0  ">
                <h5 class="text-uppercase">Kontakt</h5>
                <ul class="list-unstyled">
                    <li>Email: ParfemiShop@ferit.hr</li>
                    <li>Telefon: +385 95 576 1234</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="text-center p-3 text-white" style="background-color: #27352A;">
        &copy; 2024 Brend. Sva prava zadržana.
    </div>
</footer>


<div class="modal fade" id="kosaricaModal" tabindex="-1" aria-labelledby="kosaricaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kosaricaModalLabel">Vaša košarica</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zatvori"></button>
            </div>
            <div class="modal-body">
                <ul id="kosaricaProizvodi" class="list-group"></ul>
                <div class="mt-3">
                    <strong>Ukupna cijena:</strong> <span id="ukupnaCijena">0€</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                <button type="button" class="btn btn-primary">Kupi</button>
            </div>
        </div>
    </div>
</div>

 
     
    <script src="kosarica.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
