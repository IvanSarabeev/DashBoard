function loadXMLDocc() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "app/checkStock.php", true);
    xhttp.send();
}
setInterval(function() {
    loadXMLDocc();
}, 1000);