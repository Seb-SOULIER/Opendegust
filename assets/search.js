
document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('searchField').addEventListener('input', function (event) {
        let search = event.target.value;
        fetch('/search/autocomplete?q=' + search)
            .then(response => response.json())
            .then(function (data) {
                let list = '';
                for (const item of data.features) {
                    list += `<li><a href="/search/${item.properties.label}">${item.properties.label}</a></li>`
                }
                document.getElementById('autocomplete').innerHTML = list;
            })
            
    });
})
