document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('registerClient').addEventListener('click', (event) => {
        const providerBtn = document.getElementById('registerProvider');
        const customerBtn = document.getElementById('registerClient');
        const userRole = document.getElementById('userRole');
        providerBtn.classList.remove('active');
        customerBtn.classList.add('active');
        fetch('/register-customer')
            .then((response) => response.text())
            .then((html) => {
                userRole.setAttribute('value', 'customer');
                // eslint-disable-next-line no-console
                document.querySelector('#formRegister').innerHTML = html;
            });
    });
});
