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
					<li class="uk-clearfix">
						<div class="uk-float-left">
							<ul class="uk-iconnav uk-padding-remove">
								<li><a v-on:click="typeFilterKey = 'image'"  :class="{ active: typeFilterKey == 'image' }" uk-icon="icon: image"></a></li>
								<li><a v-on:click="typeFilterKey = 'audio'"  :class="{ active: typeFilterKey == 'audio' }" uk-icon="icon: play"></a></li>
								<li><a v-on:click="typeFilterKey = 'document'"  :class="{ active: typeFilterKey == 'document' }" uk-icon="icon: file"></a></li>
							</ul>
						</div>
					</li>
					<li v-for="file in files" :class="file.error ? 'uk-text-danger' : ''" class="uk-clearfix">
						<div class="uk-float-left">
							<img :src="file.meta.wp_data.guid.rendered" width="50" height="50" class="uk-hidden">
							<span class="uk-text-middle" uk-lightbox><a :href="file.meta.wp_data.guid.rendered">{{ file.meta.wp_data.title.raw }}</a></span>
						</div>
						<ul class="uk-iconnav uk-float-right">
							<li class="uk-hidden"><a href="#" uk-icon="icon: download"></a></li>
							<li class="uk-hidden"><a href="#" uk-icon="icon: link"></a></li>
							<li class="uk-hidden"><a href="#" uk-icon="icon: trash"></a></li>
							<li v-if="file.error" class="uk-hidden"><a href="#" uk-icon="icon: trash"></a></li>
						</ul>
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
				loading : true,
				typeFilterKey :'all'
			}
		},
		computed : {
			typeFilter(){
				console.log('computed typeFilter',this.typeFilterKey,this[this.typeFilterKey]);
				return this[this.typeFilterKey];
			},
			image(){
				return this.file.filter((file) => file.meta.wp_meta.mime_type === 'image/jpeg')
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
