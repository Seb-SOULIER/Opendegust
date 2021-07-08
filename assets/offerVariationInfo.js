document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('calendar').addEventListener('change', (event) => {
        const calendarId = event.target.value;
        fetch(`/offer/offer-variation-info?q=${calendarId}`)
            .then((response) => response.json())
            .then((data) => {
                // eslint-disable-next-line no-console
                // let list = '';
                // for (const item of data.features) {
                // eslint-disable-next-line max-len
                // list += `<li><a href="/search/${item.properties.label}">${item.properties.label}</a></li>
                // }
                // document.getElementById('autocomplete').innerHTML = list;
            });
    });
});
