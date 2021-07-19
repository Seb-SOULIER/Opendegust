const addFormToCollection = (collectionHolderClass) => {
    const collectionHolder = document.querySelector(`.${collectionHolderClass}`);
    const prototype = collectionHolder.getAttribute('data-prototype');
    const index = parseInt(collectionHolder.getAttribute('index'), 10);
    let newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    collectionHolder.setAttribute('index', index + 1);
    const li = document.createElement('li');
    li.innerHTML = newForm;
    collectionHolder.appendChild(li);
};

const initCollection = (elem) => {
    const collectionHolder = document.querySelector(elem);
    const index = collectionHolder.querySelectorAll('input').length;
    collectionHolder.setAttribute('index', index);
};

document.addEventListener('DOMContentLoaded', () => {
    const $buttons = document.querySelectorAll('.add_item_link');
    $buttons.forEach(($button) => {
        $button.addEventListener('click', (e) => {
            const $collectionHolderClass = e.target.getAttribute('data-collection-holder-class');
            addFormToCollection($collectionHolderClass);
        });
    });
    initCollection('ul.calendars');
    initCollection('ul.variations');
});
