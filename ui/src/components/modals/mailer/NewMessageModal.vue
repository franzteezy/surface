<template>
    <vue-final-modal v-model="show" classes="modal-container" content-class="modal-content">
		<NewMessage v-model:content="content" :maximized="true" @close="closeWindow" @hide="hideWindow" @maximize="minimizeWindow" :title="title"></NewMessage> <!--maximize is Opposite because this is the max window-->
    </vue-final-modal>
</template>

<script>
import {ModalsContainer, VueFinalModal} from 'vue-final-modal'

export default {
    components: {
        VueFinalModal,
        ModalsContainer,},
    watch:{
        show(newval){
            this.$emit('update:nmMaximize', newval);
        },
		content: {
		immediate: true,
		// Fill undo / redo history stack on user input
			handler (new_content) {
				this.$emit('update:content', new_content);
			},
		}
    },
    props: {
		content: {Type: Array, default: []},
        show: {Type: Boolean, default: false},
        title: {Type: String, default: ''},
        confirm: {Type: String, default: 'Confirm'},
        cancel: {Type: String, default: 'Cancel'},
    },
    data(){
        return {

		}
    },
    computed: {
		
	},
	
    methods: {
		hideWindow(){
			this.$emit('hide', true);
		},
		minimizeWindow(){
			this.$emit('minimize', true);
		},
		closeWindow(){
			this.$emit('close', true);
		}
	},
    created() {
		
    },
    mounted() {
		console.log(this.content);
        this.$el.parentNode.removeChild(this.$el);
		// window.addEventListener("click", this.process_current_text_style);
		// this.$refs.text.addEventListener("dragover", () => {
        // 		this.isOver = true;
      	// });
		// this.$refs.text.addEventListener("dragleave", () => {
		// 		this.isOver= false;
		// }); 
        document.getElementById('modal-wrapper').appendChild(this.$el);
		// if(!this.is_touch_device) this.focus_text();
		
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

:deep(.vfm--overlay){
    z-index: $level5;
}

:deep(.modal-container) {
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: $level5;
    overflow: auto;
}
:deep(.modal-content) {
    display: flex;
    flex-direction: column;
	height: 90vh;
	width: 80vw;
    background: #fff;
    box-shadow: $shadow;
    min-width: 1024px;
    border-radius: $radius;

    .content{
        // padding: calc(#{$padding} * 2);
        // background: #ffffff;
        // border-top: 1px solid $gray-L2;
        // border-bottom: 1px solid $gray-L2;
		position:relative;
        margin: 0;
		margin-top: 12px;
		height: 100%;
        max-height: 100%;
        overflow: auto;
    }
}
</style>