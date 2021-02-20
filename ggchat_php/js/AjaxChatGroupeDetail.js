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
        document.getElementById("chat").innerHTML = this.responseText;
    }
    };
    this.groupe = $_GET('groupe');
    xmlhttp.open("GET","getChatGroupeDetail.php?groupe="+this.groupe,true);
    xmlhttp.send();
    
  }
