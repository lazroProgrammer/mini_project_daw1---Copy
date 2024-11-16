 //supprime la ville
 function deleteItem(i) {
    var link = document.querySelector('a[alt=\'' + i + '\']');
    var data = document.getElementById('delete');
    var button = document.getElementById('deletebutton');


    data.value = 'delete from ville where idvil=' + i + ';\n';
    button.click();
}