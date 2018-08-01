$(document).ready(function(){
	var csv = $('#csv'),
		result = $('#result'),
		form = $('form#parser'),
		bar = document.getElementById('js-progressbar'),
		upload = new Upload(bar),
		parser = new Parser();		
	
	upload.init();
	
	$('body').on("dropped",function(e,data){
		console.log('dropped',e,data);
		//load parser
		parser.load(data);
	});
	
	$('body').on("csvLoaded",function(e,data){
		console.log('csvLoaded',e,data);
		
		csv.val(data);
	});
	
	form.submit(function(e){
    	e.preventDefault();	
		parser.parse(csv.val());
    });

});