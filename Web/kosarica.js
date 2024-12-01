const kosaricaBadge = document.querySelector('.bi-cart3 + .badge');
const kosaricaProizvodiList = document.getElementById('kosaricaProizvodi');
const ukupnaCijenaElement = document.getElementById('ukupnaCijena');

// Dohvati košaricu iz LocalStorage
let kosarica = JSON.parse(localStorage.getItem('kosarica')) || [];

// Ažuriraj broj artikala i prikaz
function azurirajKosaricu() {
    if (kosaricaProizvodiList) {
        kosaricaProizvodiList.innerHTML = '';
    }
    let ukupnaCijena = 0;

    kosarica.forEach((proizvod, index) => {
        ukupnaCijena += proizvod.cijena * proizvod.kolicina;
        if (kosaricaProizvodiList) {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                ${proizvod.naziv} - ${proizvod.cijena}€ x ${proizvod.kolicina}
                <div>
                    <button class="btn btn-sm btn-danger ukloniJedan" data-index="${index}">-</button>
                    <button class="btn btn-sm btn-success dodajJedan" data-index="${index}">+</button>
                </div>
            `;
            kosaricaProizvodiList.appendChild(li);
        }
    });

    if (ukupnaCijenaElement) {
        ukupnaCijenaElement.textContent = `${ukupnaCijena}€`;
    }
    kosaricaBadge.textContent = kosarica.reduce((total, proizvod) => total + proizvod.kolicina, 0);

    // Omogućite povećanje ili smanjenje količine
    document.querySelectorAll('.dodajJedan').forEach(button => {
        button.addEventListener('click', function () {
            const index = this.dataset.index;
            kosarica[index].kolicina++;
            spremiKosaricu();
            azurirajKosaricu();
        });
    });

    document.querySelectorAll('.ukloniJedan').forEach(button => {
        button.addEventListener('click', function () {
            const index = this.dataset.index;
            kosarica[index].kolicina--;
            if (kosarica[index].kolicina <= 0) {
                kosarica.splice(index, 1);
            }
            spremiKosaricu();
            azurirajKosaricu();
        });
    });
}

// Dodavanje proizvoda u košaricu
document.querySelectorAll('.btn-outline-primary').forEach(button => {
    button.addEventListener('click', function () {
        const proizvodCard = this.closest('.col-lg-4');
        const naziv = proizvodCard.querySelector('.card-title').textContent;
        const cijena = parseInt(proizvodCard.dataset.cijena);

        // Provjera postoji li proizvod u košarici
        const postojeciProizvod = kosarica.find(proizvod => proizvod.naziv === naziv);
        if (postojeciProizvod) {
            postojeciProizvod.kolicina++;
        } else {
            kosarica.push({ naziv, cijena, kolicina: 1 });
        }
        spremiKosaricu();
        azurirajKosaricu();
    });
});

// Spremanje košarice u LocalStorage
function spremiKosaricu() {
    localStorage.setItem('kosarica', JSON.stringify(kosarica));
}

// Učitavanje košarice pri pokretanju
window.onload = azurirajKosaricu;
