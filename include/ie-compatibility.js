
//These is for IE compatibility.

if (!Array.indexOf) {
    Array.prototype.indexOf = function(obj) {
	for (var i=0; i < this.length; i++) {
	    if (this[i] == obj) {
		return i;
	    }
	}
	return -1;
    }
}

//OMG! Seriously IE you really don't have these?!
if (!Array.map) {
    Array.prototype.map = function(funct) {
	var output = [];
	for (var i=0; i < this.length; i++){
	    output[i] = funct(this[i]);
	}
	return output;
    }
}

if (!Array.forEach) {
    Array.prototype.forEach = function(funct) {
	for (var i=0; i < this.length; i++){
	    funct(this[i]);
	}
    }
}
