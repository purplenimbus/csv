<template>
    <section class="">

	</section>
</template>

<script>
    export default {
		data:function(){
			return {
				loading : true,
				body : '',
			}
		},
		computed : {

		},
		methods : {
			init(){
				var self = this;
				console.log('Modal component init' ,self);					
			}
		},
        mounted() {
            console.log('List Component mounted.');
			this.init();
        }
    }
</script>
