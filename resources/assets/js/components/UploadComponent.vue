<template>
	<div class="js-upload uk-placeholder uk-text-center uk-margin-remove">
		<span v-if="!loading">
			<span uk-icon="icon: cloud-upload"></span>
			<span class="uk-text-middle">Drop CSV file here or</span>
			<div uk-form-custom>
				<input type="file" name="csv">
				<span class="uk-link">select one</span>
			</div>
		</span>
	</div>
</template>

<script>
    export default {
		data:function(){
			return {
				el : {},
				loading : false,
				progress : {}
			}
		},
		methods : {
			init(){
				var self = this;
		
				self.Uikit = UIkit.upload('.js-upload', {

					url: 'http://localhost:8000/upload',
					multiple: false,
					beforeSend: function (e) {
						console.log('beforeSend file',e);
						
						e.headers = {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
						};
						
					},
					beforeAll: function (e,files) {
						//console.log('beforeAll file',files );
						self.files = files;
						//self.loading = true;
						self.$emit('files', files);

					},
					progress: function (e) {
						//console.log('progress',e);
						
						self.progress.total = e.total;
						self.progress.loaded = e.loaded;
					},
					error: function () {
						console.log('error', arguments);
						self.loading = false;
						self.files[0].error = true;
						UIkit.notification("Error uploading CSV ", {status: 'danger'});
					},
					complete: function () {
						console.log('error', arguments);
					
						//self.$emit('processing', response);
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
			
			console.log('Parser.load',this);
        }
    }
</script>
