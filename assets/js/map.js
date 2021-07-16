import 'leaflet';

export default class Map {
    // eslint-disable-next-line class-methods-use-this
    init() {
        // On initialise la carte
        const locSearch = document.querySelector('[data-loclat]');
        //  locSearch.getAttribute('data-loc-lat'),locSearch.getAttribute('data-loc-lon')
        let zoom = 11;
        if (parseInt(locSearch.getAttribute('data-zoom'), 10) === 5) {
            zoom = 5;
        }

        const carte = L.map('maCarte', { zoomControl: false }).setView([locSearch.getAttribute('data-loclat'), locSearch.getAttribute('data-loclon')], zoom);
        L.control.zoom({
            position: 'bottomright',
        }).addTo(carte);
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
            // marqueur.bindPopup(`<div class="flex-column"><img class="imgpopup" src="https://cdn.pixabay.com/photo/2021/07/09/06/52/lavender-6398415_960_720.jpg"<h4>${[elem.getAttribute('data-name')]}</h4><p>texte</p></div>`);
            marqueur.bindPopup(`
  <div class="row g-0 popup-card">
    <div class="col-5">
      <img class="imgpopup" src="https://cdn.pixabay.com/photo/2017/06/23/17/38/beer-2435382_960_720.jpg" class="img-fluid rounded-start" alt="image correspondant a la degustation">
    </div>
    <div class="col-7">
    
      <div class="card-body">
        <h6 class="card-title">${[elem.getAttribute('data-name')]}</h6>
        <p class="card-text">${[elem.getAttribute('data-name')]}</p>
        <a class="linkpopup" href="/offer/${[elem.getAttribute('data-id')]}" target="_blank">réserver</a>
      </div>
    </div>
  </div>`);
            // marqueur.on('click');
            elem.addEventListener('click', (event) => {
                event.preventDefault();

                const poslat = event.target.getAttribute('data-lat');
                const poslon = event.target.getAttribute('data-long');
                console.log(poslon, poslat);
                // if (poslat && poslon) {
                //     let locat = pos.split(',');
                carte.setView([poslat, poslon], 11, { animate: true, duration: 1.5 });
                return false;
            });
        });
        // , {animation: true}

        // function markerFunction(id) {
        //     for (let i in cards) {
        //         let markerID = marqueur[i].options.title;
        //         let position = marqueur[i].getLatLng();
        //         if (markerID == id) {
        //             map.setView(position, 11);
        //             marqueur[i].openPopup();
        //         };
        //     }
        // }
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
