function Parser(){
	this.load = function(file,el){
		
		console.log('Parser.load',file);
		
		var reader = new FileReader();
		
		reader.readAsText(file);
		
		// attach event, that will be fired, when read is end
		reader.addEventListener("loadend", function() {
		   $('body').trigger('csvLoaded',[reader.result]);
		});

	
	}
	
	this.parse = function(csv){
		console.log('Parser.parse',csv);
	}
}