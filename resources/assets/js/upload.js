function Upload(bar){
	this.files = [];
	this.bar = bar;
	this.el = false;
	
	this.setFiles = function(files){
		var self = this,
			str = '';
		
		console.log('Upload.setFiles',files,self.el);
		
		str +=	'<span class="uk-text-middle">'+files[0].name+'</span>';
								
		$(self.el).html(str);
	};
	
	this.init = function(){
		var self = this;
		
		self.Uikit = UIkit.upload('.js-upload', {

			url: '',
			multiple: false,

			beforeSend: function () {
						
				console.log('beforeSend file', arguments );
			},
			beforeAll: function () {
				
				//validate for csv here ?
				
				self.files.push(arguments[1][0]); 
				
				console.log('beforeAll', arguments , self.files);
				
				self.setFiles(self.files);
				
				$( "body" ).trigger("dropped",[self.files[0]]);
						
			},
			load: function () {
				console.log('load', arguments);
			},
			error: function () {
				console.log('error', arguments);
			},
			complete: function () {
				console.log('complete', arguments);
			},

			loadStart: function (e) {
				console.log('loadStart', arguments);

				self.bar.removeAttribute('hidden');
				self.bar.max = e.total;
				self.bar.value = e.loaded;
			},

			progress: function (e) {
				console.log('progress', arguments);

				self.bar.max = e.total;
				self.bar.value = e.loaded;
			},

			loadEnd: function (e) {
				console.log('loadEnd', arguments);

				self.bar.max = e.total;
				self.bar.value = e.loaded;
			},

			completeAll: function () {
				console.log('completeAll', arguments);

				setTimeout(function () {
					self.bar.setAttribute('hidden', 'hidden');
				}, 1000);

				alert('Upload Completed');
			}

		});
		
		self.el = self.Uikit.$el;
	}
}

