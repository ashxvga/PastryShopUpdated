/*
 * This script contains AJAX methods
 */
var xmlHttp;
var numNames = 0;  //total number of suggested pastry names
var activeName = -1;  //pastry name currently being selected
var searchBoxObj, suggestionBoxObj;

//this function creates a XMLHttpRequest object
function createXmlHttpRequestObject() {
    //create a XMLHttpRequest object compatible to most browsers
    if (window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else {
        alert("Error creating the XMLHttpRequest object.");
        return false;
    }
}

//initial actions to take when the page load
window.onload = function () {
    //create an XMLHttpRequest object by calling the createXmlHttpRequestObject function
    xmlHttp = createXmlHttpRequestObject();

    //DOM objects
    searchBoxObj = document.getElementById('searchtextbox');
    suggestionBoxObj = document.getElementById('suggestionDiv');
};

window.onclick = function () {
    suggestionBoxObj.style.display = 'none';
};

//set and send XMLHttp request. The parameter is the search term
function suggest(query) {
    //if the search term is empty, clear the suggestion box.
    if (query === "") {
        suggestionBoxObj.innerHTML = "";
        return;
    }

    //proceed only if the search term isn't empty
    // open an asynchronous request to the server.
    xmlHttp.open("GET", base_url + "/" + media + "/suggest/" + query, true);

    //handle server's responses
    xmlHttp.onreadystatechange = function () {
        //proceed only if the transaction has completed and the transaction completed successfully
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            // extract the JSON received from the server
            var names = JSON.parse(xmlHttp.responseText);
            //console.log(namesJSON);
            // display suggested names in a div block
            displayNames(names);
        }
    };

    // make the request
    xmlHttp.send(null);
}


//for suggestions in the spans tags
function displayNames(names) {
    numNames = names.length;
    //console.log(numNames);
    activeName = -1;
    if (numNames === 0) {
        //hide all suggestions
        suggestionBoxObj.style.display = 'none';
        return false;
    }

    var divContent = "";
    //retrive the names from the JSON doc and create a new span for each name
    for (i = 0; i < names.length; i++) {
        divContent += "<span id=s_" + i + " onclick='clickName(this)'>" + names[i] + "</span>";
    }
    //display the spans in the div block
    suggestionBoxObj.innerHTML = divContent;
    suggestionBoxObj.style.display = 'block';
}

//This function handles keyup event. The function is called for every keystroke.
function handleKeyUp(e) {
    // get the key event for different browsers
    e = (!e) ? window.event : e;

    if (e.keyCode !== 38 && e.keyCode !== 40) {
        suggest(e.target.value);
        return;
    }

    //if the up arrow key is pressed
    if (e.keyCode === 38 && activeName > 0) {
        //add code here to handle up arrow key. e.g. select the previous item
        activeNameObj.style.backgroundColor = "#FFF";
        activeName--;
        activeNameObj = document.getElementById("s_" + activeName);
        activeNameObj.style.backgroundColor = "#F5DEB3";
        searchBoxObj.value = activeNameObj.innerHTML;
        return;
    }

    //if the down arrow key is pressed
    if (e.keyCode === 40 && activeName < numNames - 1) {
        //add code here to handle down arrow key, e.g. select the next item

        if(typeof(activeNameObj) != "undefined") {
            activeNameObj.style.backgroundColor = "#FFF";
        }
        activeName++;
        activeNameObj = document.getElementById("s_" + activeName);
        activeNameObj.style.backgroundColor = "#F5DEB3";
        searchBoxObj.value = activeNameObj.innerHTML;
    }
}



//when a name is clicked, fill the search box with the name and then hide the suggestion list
function clickName(name) {
    //display the name in the search box
    searchBoxObj.value = name.innerHTML;

    //hide all suggestions
    suggestionBoxObj.style.display = 'none';
}