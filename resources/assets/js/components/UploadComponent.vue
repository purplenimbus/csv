<template>
	<div class="js-upload uk-placeholder uk-text-center">
		<span v-if="!files.length">
			<span uk-icon="icon: cloud-upload"></span>
			<span class="uk-text-middle">Drop CSV file here or</span>
			<div uk-form-custom>
				<input type="file">
				<span class="uk-link">select one</span>
			</div>
		</span>
		<ul class="uk-list uk-list-divider" v-if="files">
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
				el : {}
			}
		},
		methods : {
			init(){
				var self = this;
		
				self.Uikit = UIkit.upload('.js-upload', {

					url: '',
					multiple: false,

					beforeSend: function () {
								
						console.log('beforeSend file', arguments );
					},
					beforeAll: function () {
						
						//validate for csv here ?
						
						var file = arguments[1][0];
												
						self.files.push(file); 
						
						console.log('beforeAll', self);
						
						//self.setFiles(self.files);
						
						//$( "body" ).trigger("dropped",[self.files[0]]);
								
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
					},

					progress: function (e) {
						console.log('progress', arguments);
					},

					loadEnd: function (e) {
						console.log('loadEnd', arguments);
					},

					completeAll: function () {
						console.log('completeAll', arguments);
					}

				});
				
				self.el = self.Uikit.$el;
			}
		},
        mounted() {
            console.log('Upload Component mounted.',this);
			this.init();
        }
    }
</script>
