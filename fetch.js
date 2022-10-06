function loadXMLDocc() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "orders/expiredOrders.php", true);
    xhttp.send();
}
setInterval(function() {
    loadXMLDocc();
}, 1600);

function loadXMLDocc() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "app/checkStock.php", true);
    xhttp.send();
}
setInterval(function() {
    loadXMLDocc();
}, 1600);

function loadXMLDoc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var notifNum = document.getElementById("notifNum");
            console.log(this.responseText);
            if (this.responseText != "0") {
                notifNum.classList.remove("d-none");
                notifNum.innerHTML = xhttp.responseText;
                document.getElementById("reloadBtn").classList.add("reloadBtnEff");
                document.getElementById("notNoti").classList.add("d-none");
            } else if (this.responseText == "0") {
                document.getElementById("notifNum").classList.add("d-none");
                document.getElementById("reloadBtn").classList.remove("reloadBtnEff");
                document.getElementById("notNoti").classList.remove("d-none");
            }
        }
    };
    xhttp.open("GET", "orders/reloadCheck.php", true);
    xhttp.send();
}
setInterval(function() {
    loadXMLDoc();
}, 1000);

function loadXMLDoccc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("addNoti").innerHTML = xhttp.responseText;
        }
    };
    xhttp.open("GET", "notification.php", true);
    xhttp.send();
}
setInterval(function() {
    loadXMLDoccc();
}, 1000);