<template>
    <section class="uk-section uk-section-default uk-height-viewport uk-padding-small">
		<div class="uk-grid-collapse" uk-grid>
			<div class="uk-width-1-1">
				<form id="parser">
					<fieldset class="uk-fieldset uk-width-1-1">
						<upload-component v-on:complete="init"></upload-component>
					</fieldset>
				</form>
				
				<div uk-spinner v-if="loading" class="uk-text-center uk-width-1-1 uk-margin"></div>
				<ul class="uk-list uk-list-divider" v-if="files.length && !loading">
					<li class="uk-clearfix uk-hidden">
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
						<ul class="uk-iconnav uk-float-right uk-margin-remove">
							<li class=""><span class="uk-label">{{ file.meta.wp_data.mime_type }}</span></li>
							<li class="uk-hidden"><a href="#" uk-icon="icon: download"></a></li>
							<li class="uk-hidden"><a href="#" uk-icon="icon: link"></a></li>
							<li class="uk-hidden"><a href="#" uk-icon="icon: trash"></a></li>
							<li v-if="file.error" class="uk-hidden"><a href="#" uk-icon="icon: trash"></a></li>
						</ul>
					</li>
				</ul>
				<button v-on:click="load()" class="uk-button uk-button-default uk-width-1-1" v-if="!lastPage">
					<span>Load More</span>
					<div uk-spinner v-if="loadingPaginate"></div>
				</button>
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
				typeFilterKey :'all',
				currentPage:1,
				loadingPaginate:false,
				lastPage:false
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
			load(){
				this.loadingPaginate = true;
				this.currentPage++;
				this.init();
			},
			init(){
				var self = this;
				console.log('List component init' ,self.currentPage);	
				
				self.loading = !self.files.length ? true : false;
				
				if(self.$root.userId){
					axios.get('/user/'+self.$root.userId+'/files?page='+self.currentPage).then(function(result){
						console.log('List component axios',self.currentPage,result.data.last_page);	
						if(self.files.length){
							self.files = self.files.concat(result.data.data);
							self.loadingPaginate = false;							
						}else{
							self.files = result.data.data;
						}
						
						self.lastPage = result.data.last_page === self.currentPage ? true : false;
						self.loading = false;
						
					}).catch(function(){
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
