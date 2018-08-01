<template>
	<div class="js-upload uk-placeholder uk-text-center">
		<div uk-spinner v-if="loading"></div>
		<span v-if="!files.length && !loading">
			<span uk-icon="icon: cloud-upload"></span>
			<span class="uk-text-middle">Drop CSV file here or</span>
			<div uk-form-custom>
				<input type="file">
				<span class="uk-link">select one</span>
			</div>
		</span>
		<ul class="uk-list uk-list-divider" v-if="files && !loading">
			<li v-for="file in files">
				{{ file.name }}
			</li>
		</ul>
	</div>
</template>

<script>
    export default {
		data:function(){
			return {
				files:[],
				el : {},
				loading : false,
				progress : {}
			}
		},
		methods : {
			init(){
				var self = this;
		
				self.Uikit = UIkit.upload('.js-upload', {

					url: '',
					multiple: false,

					beforeSend: function () {
						console.log('beforeSend file', arguments ,self );
					},
					beforeAll: function () {
						
						//var file = arguments[1][0];
																		
						//self.files.push(file); 
						
						self.loading = true;
										
						//self.parse(self.files[0]);		
					},
					progress: function (e) {
						console.log('progress', arguments,e.total,e.loaded);
						
						self.progress.total = e.total;
						self.progress.loaded = e.loaded;
					}

				});
				
				self.el = self.Uikit.$el;
			},
			parse(file){
				var self = this;
				
				console.log('Parser.load',file);
		
				var reader = new FileReader();
				
				reader.readAsText(file);
				
				// attach event, that will be fired, when read is end
				reader.addEventListener("load", function() {
					self.loading = false;
					console.log('reader loaded',reader);
					self.$emit('csv-ready', reader.result);
				});
			}
		},
        mounted() {
			this.init();
        }
    }
</script>
