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
        this.membre = $_GET('membre');
        console.log(this.public_id);
        xmlhttp.open("GET","getChatPriveDetail.php?membre="+this.membre+"&public_id="+this.public_id,true);
        xmlhttp.send();
    }
  }
