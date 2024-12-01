<?php
session_start();
$imeKorisnika = isset($_SESSION['korisnik_ime']) ? htmlspecialchars($_SESSION['korisnik_ime']) : null; // Pokreni sesiju
?>


<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proizvodi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- ParfemiShop ime ostaje na lijevoj strani -->
        <a class="navbar-brand" href="pocetna.php">ParfemiShop</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Lijevi dio: Početna stranica i košarica -->
            <ul class="navbar-nav me-auto">
                <!-- Ovdje ostavljamo prazno, da se kućica i košarica pomaknu na desnu stranu -->
            </ul>

            <!-- Desni dio: Početna stranica, Košarica, Dobrodošli, ime! i Odjava -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="pocetna.php">
                        <i class="bi bi-house"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#kosaricaModal">
                        <i class="bi bi-cart3"></i>
                        <span class="badge bg-secondary">0</span>
                    </a>
                </li>

                <?php if ($imeKorisnika): ?>
                    <li class="nav-item">
                        <span class="nav-link">Dobrodošli, <?= $imeKorisnika ?>!</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Odjava
                        </a>
                    </li>
                <?php else: ?>
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

    <div class="container my-4">
        <div class="row">
            <div class="col-md-6">
                <label for="filterCijena" class="form-label">Filtriraj po cijeni</label>
                <select id="filterCijena" class="form-select">
                    <option value="default">Odaberi</option>
                    <option value="asc">Od najmanje prema najvećoj</option>
                    <option value="desc">Od najveće prema najmanjoj</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="filterNote" class="form-label">Filtriraj po notama parfema</label>
                <select id="filterNote" class="form-select">
                    <option value="default">Odaberi</option>
                    <option value="cvjetne">Cvjetne note</option>
                    <option value="drvenaste">Drvenaste note</option>
                    <option value="svjeze">Svježe note</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Proizvodi -->
    <?php
// Konekcija na bazu podataka
$conn = new mysqli("localhost", "root", "", "korisnici_db");

// Proveri konekciju
if ($conn->connect_error) {
    die("Konekcija na bazu nije uspela: " . $conn->connect_error);
}

// Dohvati proizvode iz baze
$sql = "SELECT * FROM proizvodi";
$result = $conn->query($sql);
?>

<div class="container my-5">
    <h2 class="text-center">Naši Proizvodi</h2>
    <div class="row text-center">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-cijena="<?= $row['cijena'] ?>" data-note="<?= $row['note'] ?>">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($row['slika']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['naziv']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['naziv']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['opis']) ?></p>
                            <p class="card-text fw-bold">Cijena: <?= number_format($row['cijena'], 2) ?>€</p>
                            <a href="#" class="btn btn-outline-primary">Dodaj u Košaricu</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Nema proizvoda za prikaz.</p>
        <?php endif; ?>
    </div>
</div>

<?php
// Zatvori konekciju
$conn->close();
?>


    <!-- Modal za košaricu -->
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

    <script>
// Spremanje početnog redoslijeda proizvoda
        const originalProizvodi = Array.from(document.querySelectorAll('.col-lg-4'));

        document.getElementById('filterCijena').addEventListener('change', function () {
            const proizvodi = document.querySelectorAll('.col-lg-4'); // Svi proizvodi
            const filter = this.value;
            const parent = document.querySelector('.row.text-center');

            if (filter === 'default') {
                // Vratite originalni redoslijed proizvoda
                parent.innerHTML = ''; // Očisti trenutne proizvode
                originalProizvodi.forEach(proizvod => parent.appendChild(proizvod)); // Dodaj proizvode u izvornom redoslijedu
                return;
            }

            // Sortiraj proizvode
            const sortedProizvodi = [...proizvodi].sort((a, b) => {
                const cijenaA = parseInt(a.dataset.cijena);
                const cijenaB = parseInt(b.dataset.cijena);

                if (filter === 'asc') return cijenaA - cijenaB; // Najmanje prema najvećoj
                if (filter === 'desc') return cijenaB - cijenaA; // Najveće prema najmanjoj
                return 0;
            });

            parent.innerHTML = ''; // Očisti trenutne proizvode
            sortedProizvodi.forEach(proizvod => parent.appendChild(proizvod)); // Dodaj sortirane proizvode
        });

    
        document.getElementById('filterNote').addEventListener('change', function () {
            const proizvodi = document.querySelectorAll('.col-lg-4'); // Svi proizvodi
            const filter = this.value;
    
            proizvodi.forEach(proizvod => {
                if (filter === 'default' || proizvod.dataset.note === filter) {
                    proizvod.style.display = ''; // Prikaži proizvod
                } else {
                    proizvod.style.display = 'none'; // Sakrij proizvod
                }
            });
        });
    </script>


    
    <script src="kosarica.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
