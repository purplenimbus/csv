<template>
    <section class="uk-section uk-section-primary uk-height-viewport">
		<div class="uk-container">
			<div uk-grid>
				<div class="uk-width-1-1">
					<form id="parser">
						<fieldset class="uk-fieldset uk-width-1-1">

							<div class="uk-margin">
								<upload-component v-on:csv-ready="init" v-on:processing="init" v-on:files="load"></upload-component>
							</div>

						</fieldset>
					</form>
					<ul class="uk-list uk-list-divider" v-if="files.length">
						<li class="uk-text-uppercase uk-text-bold">files</li>
						<li v-for="file in files" :class="file.error ? 'uk-text-danger' : ''">
							{{ file.name }} {{ file.error }} <div uk-spinner v-if="loading"></div>
						</li>
					</ul>
					<div uk-grid v-if="result">
						<fieldset class="uk-fieldset uk-width-1-1">

							<div class="uk-margin">
								<textarea class="uk-textarea" rows="5" placeholder="" id="result" v-model="result"></textarea>
							</div>

						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
    export default {
		data:function(){
			return {
				result:'',
				loading: false,
				files : []
			}
		},
		methods : {
			load(files){
				var self = this;
				console.log('load file',files);	
				
				self.files = files;
								
				/*self.files.concat(toArray(files));*/
		
				function toArray(fileList) {
					return Array.prototype.slice.call(fileList);
				}	
			},
			init(data){
				var self = this;
				self.csv = data;
				
				console.log('Parser init form',self.csv);	
			}
		},
        mounted() {
            console.log('Parser Component mounted.');
        }
    }
</script>
