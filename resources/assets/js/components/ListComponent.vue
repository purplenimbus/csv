<template>
    <section class="uk-section uk-section-primary uk-height-viewport uk-padding-small">
		<div class="uk-grid-collapse" uk-grid>
			<div class="uk-width-1-1">
				<form id="parser">
					<fieldset class="uk-fieldset uk-width-1-1">
						<upload-component v-on:files="init"></upload-component>
					</fieldset>
				</form>
				<ul class="uk-list uk-list-divider" v-if="data.length">
					<li v-for="file in data" :class="file.error ? 'uk-text-danger' : ''">
						{{ file.name }} {{ file.error }} <div uk-spinner v-if="file.loading"></div>
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
				data : []
			}
		},
		methods : {
			init(data = []){
				var self = this;
				console.log('init',self,data);	
				
				self.data = data;
			}
		},
        mounted() {
            console.log('List Component mounted.');
			this.init();
        }
    }
</script>
