function showHint(str) {
    var txtHint = document.getElementById("txtHint");
    if (str.length === 0) {
        txtHint.innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                if (this.responseText.trim() !== "no results") {
                    txtHint.innerHTML = ""; // Clear previous results
                    var deliveryRecords = JSON.parse(this.responseText);
                    var content = "";
                    deliveryRecords.forEach(function(obj) {
                        content += "<li class='list-group-item'>" +
                            "<a href='/page1.php?name=" + encodeURIComponent(obj._name) + "'>" +
                            "<img src='/images/" + obj._del_photo + "' width='50px' height='50px'> " +
                            obj._name + ": " + obj._address_2 + " " + obj._postcode + "</a></li>";
                    });
                    txtHint.innerHTML = content;
                } else {
                    txtHint.innerHTML = "<p>No suggestions</p>";
                }
            }
        };
        xmlhttp.open("GET", "LiveSearchHint.php?q=" + encodeURIComponent(str), true);
        xmlhttp.send();
    }
}
