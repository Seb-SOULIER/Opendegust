const $autocomplete = document.getElementById('autocomplete');
const fetchSearch = (search) => {
    fetch(`/search/autocomplete?q=${search}`)
        .then((response) => response.json())
        .then((data) => {
            let list = '';
            // eslint-disable-next-line no-restricted-syntax
            for (const item of data.features) {
                list += `<li><a class="search-link" href="/search/${item.properties.label}">${item.properties.label}</a></li>`;
            }

            $autocomplete.innerHTML = list;
            $autocomplete.classList.remove('d-none');
            const links = document.querySelectorAll('.search-link');
            links.forEach((elem) => {
                elem.addEventListener('click', (e) => {
                    e.preventDefault();
                    const result = e.target.innerText;
                    document.getElementById('searchField').value = result;
                    $autocomplete.classList.add('d-none');
                });
            });
        });
};
document.addEventListener('DOMContentLoaded', () => {
    const searchField = document.getElementById('searchField');
    if (searchField) {
        let timer;
        searchField.addEventListener('input', (event) => {
            const search = event.target.value;
            clearTimeout(timer);
            timer = setTimeout(() => {
                if (search !== '') {
                    fetchSearch(search);
                } else {
                    $autocomplete.classList.add('d-none');
                }
            }, 400);
        });
        document.querySelector('body').addEventListener('click', (event) => {
            $autocomplete.classList.add('d-none');
        });
    }
});
