document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('calendar').addEventListener('change', (event) => {
        const calendarId = event.target.value;

        fetch(`/offer/offer-variation-info/${calendarId}`)
            .then((response) => response.text())
            .then((html) => {
                document.querySelector('#formBooking').innerHTML = html;
                // initSubmitOnLoad();
                // console.log(html);
                document.querySelector('#formBooking').innerHTML = html;
                // initSubmitOnLoad();
                let totalAdultPrice = 0;
                let totalChildPrice = 0;
                const totalPrice = document.getElementById('price');
                const adultPrice = document.getElementById('adultPrice');
                const childPrice = document.getElementById('childPrice');
                const nbrOfAdults = document.getElementById('nbrAdultPlaces');
                const nbrOfChilds = document.getElementById('nbrChildPlaces');
                const childPlaces = document.getElementById('booking_childPlaces');
                const adultPlaces = document.getElementById('booking_adultPlaces');
                const availablePlaces = document.getElementById('availablePlaces');
                const addAdult = document.getElementById('addAdult');
                const addChild = document.getElementById('addChild');
                const removeAdult = document.getElementById('removeAdult');
                const removeChild = document.getElementById('removeChild');

                addAdult.addEventListener('click', (event2) => {
                    event2.preventDefault();
                    if (availablePlaces.innerHTML > 0) {
                        // eslint-disable-next-line no-plusplus
                        nbrOfAdults.innerHTML++;
                        // eslint-disable-next-line no-plusplus
                        availablePlaces.innerHTML--;
                        adultPlaces.setAttribute('value', nbrOfAdults.innerHTML);
                    }
                    totalAdultPrice = nbrOfAdults.innerHTML * adultPrice.innerHTML;
                    totalPrice.innerHTML = (totalAdultPrice + totalChildPrice).toString();
                });
                removeAdult.addEventListener('click', (event2) => {
                    event2.preventDefault();
                    if (nbrOfAdults.innerHTML > 0) {
                        // eslint-disable-next-line no-plusplus
                        nbrOfAdults.innerHTML--;
                        // eslint-disable-next-line no-plusplus
                        availablePlaces.innerHTML++;
                        adultPlaces.setAttribute('value', nbrOfAdults.innerHTML);
                    }
                    totalAdultPrice = nbrOfAdults.innerHTML * adultPrice.innerHTML;
                    totalPrice.innerHTML = (totalAdultPrice + totalChildPrice).toString();
                });
                addChild.addEventListener('click', (event2) => {
                    event2.preventDefault();
                    if (availablePlaces.innerHTML > 0) {
                        // eslint-disable-next-line no-plusplus
                        nbrOfChilds.innerHTML++;
                        // eslint-disable-next-line no-plusplus
                        availablePlaces.innerHTML--;
                        childPlaces.setAttribute('value', nbrOfChilds.innerHTML);
                    }
                    totalChildPrice = nbrOfChilds.innerHTML * childPrice.innerHTML;
                    totalPrice.innerHTML = (totalAdultPrice + totalChildPrice).toString();
                });
                removeChild.addEventListener('click', (event2) => {
                    event2.preventDefault();
                    if (nbrOfChilds.innerHTML > 0) {
                        // eslint-disable-next-line no-plusplus
                        nbrOfChilds.innerHTML--;
                        // eslint-disable-next-line no-plusplus
                        availablePlaces.innerHTML++;
                        childPlaces.setAttribute('value', nbrOfChilds.innerHTML);
                    }
                    totalChildPrice = nbrOfChilds.innerHTML * childPrice.innerHTML;
                    totalPrice.innerHTML = (totalAdultPrice + totalChildPrice).toString();
                });

                // document.querySelectorAll('button[data-change="adult"]').forEach((elem) => {
                // eslint-disable-next-line no-tabs
                // elem.addEventListener('click', (event) => {
                // eslint-disable-next-line no-tabs
                // event.preventDefault();
                // eslint-disable-next-line no-tabs,no-mixed-spaces-and-tabs
                // const sens = event.target.g;
                // console.log(event.target.getAttribute('data-sens'));
                // eslint-disable-next-line no-tabs
                // })
                // });
            });
    });

    let totalAdultPrice = 0;
    let totalChildPrice = 0;
    const totalPrice = document.getElementById('price');
    const adultPrice = document.getElementById('adultPrice');
    const childPrice = document.getElementById('childPrice');
    const nbrOfAdults = document.getElementById('nbrAdultPlaces');
    const nbrOfChilds = document.getElementById('nbrChildPlaces');
    const childPlaces = document.getElementById('booking_childPlaces');
    const adultPlaces = document.getElementById('booking_adultPlaces');
    const availablePlaces = document.getElementById('availablePlaces');
    const addAdult = document.getElementById('addAdult');
    const addChild = document.getElementById('addChild');
    const removeAdult = document.getElementById('removeAdult');
    const removeChild = document.getElementById('removeChild');

    addAdult.addEventListener('click', (event2) => {
        event2.preventDefault();
        if (availablePlaces.innerHTML > 0) {
            // eslint-disable-next-line no-plusplus
            nbrOfAdults.innerHTML++;
            // eslint-disable-next-line no-plusplus
            availablePlaces.innerHTML--;
            adultPlaces.setAttribute('value', nbrOfAdults.innerHTML);
        }
        totalAdultPrice = nbrOfAdults.innerHTML * adultPrice.innerHTML;
        totalPrice.innerHTML = (totalAdultPrice + totalChildPrice).toString();
    });
    removeAdult.addEventListener('click', (event2) => {
        event2.preventDefault();
        if (nbrOfAdults.innerHTML > 0) {
            // eslint-disable-next-line no-plusplus
            nbrOfAdults.innerHTML--;
            // eslint-disable-next-line no-plusplus
            availablePlaces.innerHTML++;
            adultPlaces.setAttribute('value', nbrOfAdults.innerHTML);
        }
        totalAdultPrice = nbrOfAdults.innerHTML * adultPrice.innerHTML;
        totalPrice.innerHTML = (totalAdultPrice + totalChildPrice).toString();
    });
    addChild.addEventListener('click', (event2) => {
        event2.preventDefault();
        if (availablePlaces.innerHTML > 0) {
            // eslint-disable-next-line no-plusplus
            nbrOfChilds.innerHTML++;
            // eslint-disable-next-line no-plusplus
            availablePlaces.innerHTML--;
            childPlaces.setAttribute('value', nbrOfChilds.innerHTML);
        }
        totalChildPrice = nbrOfChilds.innerHTML * childPrice.innerHTML;
        totalPrice.innerHTML = (totalAdultPrice + totalChildPrice).toString();
    });
    removeChild.addEventListener('click', (event2) => {
        event2.preventDefault();
        if (nbrOfChilds.innerHTML > 0) {
            // eslint-disable-next-line no-plusplus
            nbrOfChilds.innerHTML--;
            // eslint-disable-next-line no-plusplus
            availablePlaces.innerHTML++;
            childPlaces.setAttribute('value', nbrOfChilds.innerHTML);
        }
        totalChildPrice = nbrOfChilds.innerHTML * childPrice.innerHTML;
        totalPrice.innerHTML = (totalAdultPrice + totalChildPrice).toString();
    });
});
