<template>
    <section class="uk-section uk-section-primary uk-height-viewport">
		<div class="uk-container">
			<div uk-grid>
				<h1>CSV Parser</h1>
				<form class="uk-width-1-1" id="parser" uk-grid>
					<fieldset class="uk-fieldset uk-width-1-1">

						<div class="uk-margin">
							<upload-component v-on:csv-ready="init" v-on:processing="init"></upload-component>
						</div>

					</fieldset>
				</form>
				<div uk-grid v-if="result">
					<fieldset class="uk-fieldset uk-width-1-1">

						<div class="uk-margin">
							<textarea class="uk-textarea" rows="5" placeholder="" id="result" v-model="result"></textarea>
						</div>

					</fieldset>
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
