
let ajoutContinentPays = false;
let dataOthers = '';
let dataNecessaire = '';
let dataSite = '';
let dataPhoto = '';
let Paysajoutee = '';

//ajouter les continents/pays a la comboliste
function nouveauPaysContinent() {
    let input;
    let message = prompt('vous voulaiez ajouter un pays(1) ou un continent(2)?');


    //ajouter un continent
    if (message == 2) {

        var list = [];
        list = getContinentList();

        input = prompt('entrer le nom du continent');
        //teste d'input

        if (input == null) return;
        for (var i = 0; i < list.length; i++) {
            if (input == list[i]) {
                alert(input + ' existe deja');
                return;
            }
        }
        dataOthers = dataOthers + 'insert into continent(nomCon) values(\"' + input + '\");';

        addOptGroup(input);
        ajoutContinentPays = true;
    }

    //ajouter un pays
    else if (message == 1) {
        var list = [];
        list = getContinentList();
        var continentListmessage = '';


        //afficher la liste de continent
        for (var i = 0; i < list.length; i++) {
            continentListmessage += (i + 1) + ": " + list[i] + "\n";
        }
        let continentIndex;
        continentIndex = prompt('entre l\"indexe du continent \n' + continentListmessage + '\n ne saisie rien si le continent n\"existe pas ');
        // teste d'index
        if (continentIndex <= 0 || continentIndex > list.length) {
            alert('vous avez entrer une valeur non valide');
            return;
        }

        //add <option value='pays'>pays</option> in the specific optGroup
        input = prompt('donner le nom de pays');

        //teste d'input
        if (input == null) return;
        let paysList = [];
        paysList = getPaysList();

        for (var i = 0; i < paysList.length; i++) {
            if (input == paysList[i]) {
                alert(input + ' existe deja');
                return;
            }

        }

        //creation de pays a la liste
        let parent = document.querySelector('[label="' + list[continentIndex - 1] + '"]');
        let newChild = document.createElement('option');


        newChild.setAttribute('value', input);
        newChild.textContent = input;
        parent.appendChild(newChild);
        dataOthers = dataOthers + 'insert into pays(nompay,idcon) values(\"' + input + '\", ' + continentIndex + ');';

        ajoutContinentPays = true;
    }

    else {
        return;
    }
}


function addOptGroup(input) {
    let optElement = document.createElement('optgroup');
    let pays = document.getElementById('pays')
    optElement.setAttribute('label', input);
    pays.appendChild(optElement)

}

//pour les hotels,restaurants...
function addOption2(id, idInput) {
    //teste if the value of input is null or it's is an existing input
    if (document.getElementById(idInput).value == 0)
        return;

    var selectedOptions = document.getElementById(id).options;
    var contentList = [];

    for (var i = 0; i < selectedOptions.length; i++) {
        if (selectedOptions[i].textContent == document.getElementById(idInput).value)
            return;
    }
    //remarque: id est le typenec
    dataNecessaire = dataNecessaire + 'insert into necessaire(typenec,nomnec,idvil) values(\"' + id + '\",\"' + document.getElementById(idInput).value + '\", ~);';

    let parent = document.getElementById(id);
    let newChild = document.createElement('option');


    newChild.setAttribute('value', document.getElementById(idInput).value);
    newChild.textContent = document.getElementById(idInput).value;
    parent.appendChild(newChild);
    ajoutContinentPays = true;
}

//envoyer les instructions d'insertions
function sendSQLCommands() {

    var inputElement1 = document.getElementById('sqlNecessaire');
    inputElement1.setAttribute('value', dataNecessaire);

    var inputElement2 = document.getElementById('sqlOthers');
    inputElement2.setAttribute('value', dataOthers);

    var inputElement3 = document.getElementById('sqlSite');
    inputElement3.setAttribute('value', dataSite);

    var inputElement4 = document.getElementById('sqlPhoto');
    inputElement4.setAttribute('value', dataPhoto);
}

//la construction de la liste des continent appartir d'optgroup
function getContinentList() {
    var list = [];
    var optgroupElements = document.getElementsByTagName('optgroup');
    for (var i = 0; i < optgroupElements.length; i++) {

        let value = optgroupElements[i].getAttribute('label')
        list.push(value);
    }
    return list;
}

//la construction de la liste des continent appartir des options
function getPaysList() {
    var list = [];
    var optionElements = document.getElementById('pays').getElementsByTagName('option');
    for (var i = 0; i < optionElements.length; i++) {

        let value = optionElements[i].getAttribute('value');
        list.push(value);
    }
    return list;
}

// ajoute le site,photo si l'url existe
async function getSitePhoto(){

    if (await URLExists(document.getElementById('photos').value)) {
        getSite();
        getPhoto();
        alert('you have successfully added the items')
    }
    else{
        alert('you may have entered a wrong URL.');
    }

}

//ajouter un site
function getSite() {

    var site = document.getElementById('site').value;
    if (dataSite == '') {
        dataSite = dataSite + site;
    }
    else {
        dataSite = dataSite + "~" + site;
    }


}

//ajouter la photo
function getPhoto() {
    var photoUrl = document.getElementById('photos').value;
    if (dataPhoto == '') {
        dataPhoto = dataPhoto + photoUrl;
    }
    else {
        dataPhoto = dataPhoto + "<>" + photoUrl;
    }
}

// teste de l'url
function URLExists(url) {
    return fetch(url)
        .then(response => {
            if (response.ok) {
                return true; // URL exists
            } else {
                return false; // URL does not exist
            }
        })
        .catch(() => {
            return false; // Error occurred, URL does not exist
        });
}

