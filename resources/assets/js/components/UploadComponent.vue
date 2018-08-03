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

					url: 'http://purplenimbus.net/media/wp-json/wp/v2/media?oauth_secret=IDg4QX8YQccOjnrYM6ump31IEQAHn9NRUh4w8ia2EcxL8ENS&oauth_consumer_key=iKX0DWS0oktD&oauth_token=eB2O5VCgmHksNfomWnArAjx9&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1533275327&oauth_nonce=aUqDIgF8XIQ&oauth_version=1.0&oauth_signature=7Zw5h8Hj9MtkGVDBGRpeZ6AilfA%3D',
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
        }
    }
</script>
