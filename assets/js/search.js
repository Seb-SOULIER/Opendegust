document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('searchField').addEventListener('input', (event) => {
        const search = event.target.value;
        fetch(`/search/autocomplete?q=${search}`)
            .then((response) => response.json())
            .then((data) => {
                let list = '';
                // eslint-disable-next-line no-restricted-syntax
                for (const item of data.features) {
                    list += `<li><a href="/search/${item.properties.label}">${item.properties.label}</a></li>`;
                }
                document.getElementById('autocomplete').innerHTML = list;
            });
    });
    document.getElementById('searchField').addEventListener('keyup', () => {
        const autocomplete = document.getElementById('autocomplete');
        autocomplete.classList.toggle('visually-hidden');
    });
});
