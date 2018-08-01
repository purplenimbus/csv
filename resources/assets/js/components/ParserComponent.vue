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
							<textarea class="uk-textarea" rows="5" id="csv"></textarea>
						</div>

						<div class="uk-margin">
							<button class="uk-button uk-button-primary uk-button-large uk-width-1-1" @click="submit()">submit</button>
						</div>

					</fieldset>
				</form>
				<div uk-grid v-if="result">
					<fieldset class="uk-fieldset uk-width-1-1">

						<div class="uk-margin">
							<textarea class="uk-textarea" rows="5" placeholder="" id="result"></textarea>
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
				csv:'',
				result:''
			}
		},
		methods : {
			submit(){
				console.log('submit form');
			}
		},
        mounted() {
            console.log('Parser Component mounted.');
        }
    }
</script>
