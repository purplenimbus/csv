<template>
    <section class="uk-section uk-section-primary uk-height-viewport">
		<div class="uk-container">
			<div uk-grid>
				<h1>CSV Parser</h1>
				<form class="uk-width-1-1" id="parser" uk-grid>
					<fieldset class="uk-fieldset uk-width-1-1">

						<div class="uk-margin">
							<upload-component></upload-component>
						</div>

						<div class="uk-margin">
							<textarea class="uk-textarea" rows="5" placeholder="" name="csv" id="csv" v-model="csv"></textarea>
						</div>

						<div class="uk-margin">
							<input class="uk-button uk-button-primary uk-button-large uk-width-1-1" type="submit" value="Submit" @click="submit()">
						</div>

					</fieldset>
				</form>
				<div uk-grid v-if="result">
					<fieldset class="uk-fieldset uk-width-1-1">

						<div class="uk-margin">
							<textarea class="uk-textarea" rows="5" placeholder="" name="result" id="result" v-model="result"></textarea>
						</div>

					</fieldset>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
    export default {
		data:{
			csv:'',
			result:false
		},
		methods : {
			submit(){
				console.log('submit form');
			}
		},
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>
