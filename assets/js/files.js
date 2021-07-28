document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('[data-delete]');
    // eslint-disable-next-line no-restricted-syntax,no-undef
    for (const link of links) {
        // eslint-disable-next-line no-undef
        link.addEventListener('click', (event) => {
            event.preventDefault();
            // eslint-disable-next-line no-restricted-globals
            if (confirm('Voulez-vous supprimer ce fichier?')) {
                fetch(link.getAttribute('href'),
                    {
                        method: 'GET',
                        //     headers: {
                        //         'X-Requested-With': 'XMLHttpRequest',
                        //         'Content-Type': 'application/json',
                        //     },
                        //     body: JSON.stringify({ _token: this.dataset.token }),
                    }).then(
                    (response) => response.json(),
                ).then((data) => {
                    if (data.success) { this.parentElement.remove(); } else { alert(data.error); }
                }).catch((event) => alert(event));
            }
        });
    }
});
