import "leaflet";

export default class Map {
    // eslint-disable-next-line class-methods-use-this
    init() {
        // On initialise la carte
        const locSearch = document.querySelector('[data-loclat]');
        //  locSearch.getAttribute('data-loc-lat'),locSearch.getAttribute('data-loc-lon')
        let carte = L.map('maCarte').setView([locSearch.getAttribute('data-loclat'), locSearch.getAttribute('data-loclon')], 11);
        // On charge les "tuiles"
        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            minZoom: 2,
            maxZoom: 15,
            attribution: '&copy; OpenStreetMap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(carte);

        //  On personalise le marqueur
        const cards = document.querySelectorAll('[data-lat]');
        cards.forEach((elem) => {
            // console.log(elem.getAttribute('data-lat'), elem.getAttribute('data-long'));
            const marqueur = L.marker([elem.getAttribute('data-lat'), elem.getAttribute('data-long')]).addTo(carte);
            marqueur.bindPopup('<h4>' + [elem.getAttribute('data-name')] + '</h4>');
        });
        // on ajoute des marqueurs
        //  marqueur.bindPopup(([elem.getAttribute('data-name')]));
        // const myIcon = L.icon({
        // iconUrl: 'assets/images/marker-icon.png'});
        // const marqueur = L.marker([45.7460663, -0.6300671]).addTo(carte);

        // création de sa popup
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const map = new Map();
    map.init();
});
