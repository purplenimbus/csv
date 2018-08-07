<template>
    <section class="uk-section uk-section-primary uk-height-viewport uk-padding-small">
		<div class="uk-grid-collapse" uk-grid>
			<div class="uk-width-1-1">
				<form id="parser">
					<fieldset class="uk-fieldset uk-width-1-1">
						<upload-component v-on:complete:="init"></upload-component>
					</fieldset>
				</form>
				
				<div uk-spinner v-if="loading" class="uk-text-center uk-width-1-1 uk-margin"></div>
				<ul class="uk-list uk-list-divider" v-if="files.length">
					<li>Your Files</li>
					<li v-for="file in files" :class="file.error ? 'uk-text-danger' : ''">
						{{ file.meta.wp_data.title.raw }} {{ file.error }}
					</li>
				</ul>
			</div>
		</div>
	</section>
</template>

<script>
    export default {
		data:function(){
			return {
				list : [],
				files : [],
				loading : true
			}
		},
		methods : {
			init(){
				var self = this;
				console.log('List component init , user id '+self.$root.userId,self);	
								
				if(self.$root.userId){
					axios.get('/user/'+self.$root.userId+'/files').then(function(result){
						console.log('List component axios',result);	
						self.files = result.data;
						self.loading = false;
					});
				}
				
			}
		},
        mounted() {
            console.log('List Component mounted.');
			this.init();
        }
    }
</script>
