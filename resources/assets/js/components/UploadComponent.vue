<template>
	<div>
		<div class="js-upload uk-placeholder uk-text-center">
			<span v-if="!loading">
				<span uk-icon="icon: cloud-upload"></span>
				<span class="uk-text-middle">Drop CSV file here or</span>
				<div uk-form-custom>
					<input type="file" name="csv">
					<span class="uk-link">select one</span>
				</div>
			</span>
		</div>
		
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

					url: '/csv/process',
					multiple: false,
					beforeSend: function (e) {
						console.log('beforeSend file',e );
						e.headers = {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
						};						
					},
					beforeAll: function (e,files) {
						//console.log('beforeAll file',files );
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
					complete: function (e) {
						
						//self.loading = false;
						var response = JSON.parse(e.response);
						
						console.log('complete',e);
						
						UIkit.notification("Processing CSV id "+response.id, {status: 'info'});
						
						self.$emit('processing', response);
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
