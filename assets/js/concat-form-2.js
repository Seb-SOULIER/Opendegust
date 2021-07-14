const addFormToCollection = (collectionHolderClass) => {
    // Get the ul that holds the collection of tags
    const collectionHolder = document.querySelector(`.${collectionHolderClass}`);
    // Get the data-prototype explained earlier
    const prototype = collectionHolder.getAttribute('data-prototype');
    // get the new index
    const index = parseInt(collectionHolder.getAttribute('index'), 10);
    let newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.setAttribute('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    const li = document.createElement('li');
    li.innerHTML = newForm;
    // Add the new form at the end of the list
    collectionHolder.appendChild(li);
};

const initCollection = (elem) => {
    const collectionHolder = document.querySelector(elem);
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    const index = collectionHolder.querySelectorAll('input').length;
    collectionHolder.setAttribute('index', index);
};

document.addEventListener('DOMContentLoaded', () => {
    // Get the ul that holds the collection of tags
    const $buttons = document.querySelectorAll('.add_item_link');
    $buttons.forEach(($button) => {
        $button.addEventListener('click', (e) => {
            const $collectionHolderClass = e.target.getAttribute('data-collection-holder-class');
            // add a new tag form (see next code block)
            addFormToCollection($collectionHolderClass);
        });
    });
    initCollection('ul.offerVariations');
    initCollection('ul.calendars');
});
