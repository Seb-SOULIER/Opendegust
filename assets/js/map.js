export default class Map {
    // eslint-disable-next-line class-methods-use-this
    init() {
        // On initialise la carte
        let L;
        const carte = L.map('maCarte').setView([45.7460663, -0.6300671], 11);

        // On charge les "tuiles"
        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            minZoom: 10,
            maxZoom: 15,
            attribution: '&copy; OpenStreetMap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(carte);

        const cards = document.querySelectorAll('[data-lat]');
        cards.forEach((elem) => {
            //           console.log(elem.getAttribute('data-lat'), elem.getAttribute('data-long'));
        });
        // on ajoute des marqueurs

        const marqueur = L.marker([45.7460663, -0.6300671]).addTo(carte);

        // création de sa popup
        marqueur.bindPopup('<h4>Saintes</h4>');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const map = new Map();
    map.init();
});
