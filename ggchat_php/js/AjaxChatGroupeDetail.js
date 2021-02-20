setInterval(function() {
    showGroupChat();
}, 5000);
function $_GET(param) {
	var vars = {};
	window.location.href.replace( location.hash, '' ).replace( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
}
function showGroupChat() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("chat").insertAdjacentHTML("afterbegin",this.responseText);
        }
    }
    if(document.getElementById("chat").innerHTML != "")
    {
        this.public_id = document.getElementById("chat").firstChild.id;
        this.groupe = $_GET('groupe');
        console.log(this.public_id);
        xmlhttp.open("GET","getChatGroupeDetail.php?groupe="+this.groupe+"&public_id="+this.public_id,true);
        xmlhttp.send();
    }
  }
