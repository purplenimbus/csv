<template>
	<div>
		<div class="js-upload uk-placeholder uk-text-center uk-margin-remove">
			<span v-if="!loading">
				<span uk-icon="icon: cloud-upload"></span>
				<span class="uk-text-middle">Drop Image here or</span>
				<div uk-form-custom>
					<input type="file" name="csv">
					<span class="uk-link">select one</span>
				</div>
			</span>
		</div>
		<ul class="uk-list uk-list-divider" v-if="files.length && !loading">
			<li v-for="file in files" :class="file.error ? 'uk-text-danger' : ''">
				{{ file.name }} {{ file.error }} <div uk-spinner v-if="file.loading"></div>
			</li>
		</ul>
	</div>
</template>

<script>
    export default {
		data:function(){
			return {
				el : {},
				loading : false,
				progress : {},
				files : []
			}
		},
		methods : {
			init(){
				var self = this;
		
				self.Uikit = UIkit.upload('.js-upload', {
					url: 'http://nimbus-media.herokuapp.com/upload',
					multiple: false,
					//mime : 'image/*',
					beforeSend: function (e) {
						console.log('beforeSend file',e);
						
						e.headers = {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
						};
						
					},
					beforeAll: function (e,files) {
						//console.log('beforeAll file',files );
						self.files = files;
						self.files[0].loading = true;
						self.$emit('files', files);

					},
					progress: function (e) {
						console.log('progress',e);
						
						self.progress.total = e.total;
						self.progress.loaded = e.loaded;
					},
					error: function () {
						console.log('error', arguments);
						self.files[0].loading = false;
						self.files[0].error = true;
						UIkit.notification("Error uploading file", {status: 'danger'});
					},
					complete: function (e) {
						console.log('complete',e);

						var message = 'Success',
							resposne = false;
						
						if(JSON.parse(e.response)){
							var response = JSON.parse(e.response),
								url = response.data.wp_data.guid.rendered ? response.data.wp_data.guid.rendered : false,
								message = url ? "<p>"+url+'</p>' : '';
																																				
						}
						
						self.$emit('complete', response);
						
						UIkit.notification(message, {status: 'success' });
						
						self.files = [];
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

			console.log('Upload component mounted',self);
        }
    }
</script>
