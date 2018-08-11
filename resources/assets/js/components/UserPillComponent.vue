<template>
    <div>
		<a v-on:click="open">{{ user }}</a>
		<modal-component v-on:modal="init"></modal-component>
	</div>
</template>

<script>
    export default {
		data:function(){
			return {
				user:false,
				loading:true
			}
		},
		computed : {

		},
		methods : {
			open(){
				var body = '';
				console.log('UserPill modal open');
				this.$broadcast('modal',body);
			},
			init(){
				var self = this;
				console.log('UserPill component init' ,self);	
				self.loading = false;
			}
		},
        mounted() {
            console.log('UserPill Component mounted.');
			this.init();
        }
    }
</script>
