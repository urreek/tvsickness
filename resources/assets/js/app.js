
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.search = function search(searchString){
    getSearchResult(searchString);
}

function getSearchResult(searchString){
    fetch('/api/search?search='+searchString+'') // Call the fetch function passing the url of the API as a parameter
    .then(function(response) {
        if(response.ok) {
            response.json().then(function(json) {
                (searchString !== "") ? renderResult(json) : renderResult([]);
              });
        } else {
            console.log(response);
        }
    });
}

function renderResult(result){
    let searchContent = document.getElementById("search-content");
    while(searchContent.firstChild){
        searchContent.removeChild(searchContent.firstChild);
    }
    
    result["movies"].forEach(element => {
        let anchor = document.createElement("a"); 
        anchor.setAttribute("href", "/movies/"+element.id);
        element.release_date = new Date(element.release_date).getFullYear();
        anchor.innerHTML = "<div class='search-result-row'><img class='z-depth-3' src='https://image.tmdb.org/t/p/w500"+element.poster_path+"'><p>"+element.title+" ("+element.release_date+")</p></div>";
        searchContent.appendChild(anchor);
    });

    result["tvshows"].forEach(element => {
        let anchor = document.createElement("a"); 
        anchor.setAttribute("href", "/tvshows/"+element.id);
        element.first_air_date = new Date(element.first_air_date).getFullYear();
        anchor.innerHTML = "<div class='search-result-row'><img class='z-depth-3' src='https://image.tmdb.org/t/p/w500"+element.poster_path+"'><p>"+element.name+" ("+element.first_air_date+")</p></div>";
        searchContent.appendChild(anchor);
    });
}