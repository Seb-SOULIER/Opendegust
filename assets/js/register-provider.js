document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('registerProvider').addEventListener('click', (event) => {
        const providerBtn = document.getElementById('registerProvider');
        const customerBtn = document.getElementById('registerClient');
        const userRole = document.getElementById('userRole');
        providerBtn.classList.add('active');
        customerBtn.classList.remove('active');
        fetch('/register-provider')
            .then((response) => response.text())
            .then((html) => {
                userRole.setAttribute('value', 'provider');
                // eslint-disable-next-line no-console
                document.querySelector('#formRegister').innerHTML = html;
            });
    });
});
