<template>
    <vue-final-modal v-model="show" classes="modal-container" content-class="modal-content">
        <Row class="title" split>
            <Column w10 centerv>
                <P xl semibold>{{title}}</P>
            </Column>
            <Column w3 end centerv>
                <div class="nm-flex">
                    <i class="icon icon-hide-window" @click="show=false"></i>
                    <i class="icon icon-maximize" @click="show=false"></i>
                    <i class="icon icon-clear" @click="show=false"></i>
                </div>
            </Column>
        </Row>
		<Row class="nm-row">
			<Column centerh>
				<Input v-model:value="recipient"  class="nm-rec" placeholder="Recipients"></Input>
			</Column>
		</Row>
		<Row class="nm-row">
			<Column centerh>
				<Input v-model:value="subject" class="nm-rec" placeholder="Subject"></Input>
			</Column>
		</Row>
		<Row class="nm-row nm-textarea content" nm >	
			<Column centerh>
				<Textarea v-model:value="content" class="nm-content" @keydown.tab.prevent="tabber($event)"></Textarea>
			</Column>
		</Row>
		<Row class="actions" centerv>
			<Column w1 centerv>
				<Button class="nm-send" small icon="send">Send</Button>
			</Column>
			<Column w10 centerv>
				<div class="nm-tool-flex">
					
				<i @click="format()" :class="{icon:true, 'icon-text-formatting':true, ico:true, active:formatText}"></i>
				<i class="icon icon-paperclip ico" @click="browseFile"><input type="file" ref="fileBrowse" style="display:none;"/></i>
				<i class="icon icon-link ico"></i>
				<i class="icon icon-photo ico" @click="browsePhoto"><input type="file" ref="photoBrowse" accept="image/*" style="display:none;"/></i>
				<i class="icon icon-dots-vertical ico"></i>
				
				</div>
			</Column>
			<Column w1 centerv end>
				<i class="icon icon-trash ico"></i>
			</Column>
		</Row>
		<Wrapper nm class="nm-formatter" v-if="formatText">
			<Row class="nm-toolbar">
				<Column centerv>
					<div class="nm-tool-flex">
						<i class="icon icon-undo ico"></i>
						<i class="icon icon-redo ico"></i>
						<div class="toolbar-div"></div>
						<P ellipsis large semibold>Sans Serif</P>
						<i class="icon icon-double-carret-down ico"></i>
						<div class="toolbar-div"></div>
						<i class="icon icon-letter ico icon-nm"></i>
						<i class="icon icon-double-carret-down ico "></i>
						<div class="toolbar-div"></div>
						<i class="icon icon-text-bold ico"></i>
						<i class="icon icon-text-italic ico"></i>
						<i class="icon icon-text-underline ico"></i>
						<i class="icon icon-text-formatting ico icon-nm"></i>
						<i class="icon icon-double-carret-down ico "></i>
						<div class="toolbar-div"></div>
						<i class="icon icon-align-left ico icon-nm"></i>
						<i class="icon icon-double-carret-down ico "></i>
						<i class="icon icon-list-ol ico"></i>
						<i class="icon icon-list-bullet ico"></i>
						<i class="icon icon-indent-less ico "></i>
						<i class="icon icon-indent-more ico "></i>
						<i class="icon icon-quote-right ico "></i>
						<div class="toolbar-div"></div>
						<i class="icon icon-strikethrough ico "></i>
						<div class="toolbar-div"></div>
						<i class="icon icon-x-alt ico "></i>
					</div>
				</Column>
			</Row>
		</Wrapper>
    </vue-final-modal>
</template>

<script>
import {ModalsContainer, VueFinalModal} from 'vue-final-modal'

export default {
    components: {
        VueFinalModal,
        ModalsContainer
    },
    watch:{
        show(newval){
            this.$emit('update:show', newval);
        }
    },
    props: {
        show: {Type: Boolean, default: false},
        title: {Type: String, default: ''},
        confirm: {Type: String, default: 'Confirm'},
        cancel: {Type: String, default: 'Cancel'},
		recipient:{Type: String, default: ''},
		subject:{Type: String, default: ''},
		content:{Type: String, default: ''},
    },
    data(){
        return{
			formatText: false
        }
    },
    computed: {

    },
    methods: {
        clickCancel(){
            this.$emit('cancel')
        },
        clickConfirm(){
            this.$emit('confirm')
        },
		tabber(event){
			event.preventDefault();
		},
		format(){
			if(this.formatText){
				this.formatText = false;
			}else{
				this.formatText = true;
			}
		},
		browseFile(){
			this.$refs.fileBrowse.click();
		},
		browsePhoto(){
			this.$refs.photoBrowse.click();
		}
    },
    created() {
    },
    mounted() {
        this.$el.parentNode.removeChild(this.$el);
        document.getElementById('modal-wrapper').appendChild(this.$el);
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
    min-width: 500px;
    border-radius: $radius;

    .content{
        // padding: calc(#{$padding} * 2);
        // background: #ffffff;
        // border-top: 1px solid $gray-L2;
        // border-bottom: 1px solid $gray-L2;
        margin: 0;
		margin-top: 12px;
		height: 100%;
        max-height: 80vh;
        overflow: auto;
    }

  

    .title{
        padding: $padding calc(#{$padding} * 2);
        margin: 0;
        border-bottom: 1px solid #E5E9ED99;
		background: linear-gradient(0deg, #FAFBFF, #FAFBFF), 
        linear-gradient(0deg, rgba(250, 251, 252, 0.7),
         rgba(250, 251, 252, 0.7)), #FFFFFF;
		border-radius: $radius $radius 0px 0px;
        i{
			margin-right: 10px;
            font-size: 20px;
            color: $gray-L1;
            cursor: pointer;
            transition: $transition;
			&:last-child{
				margin-right: 0px;
			}
            &:hover{
                color: $gray-D2;
            }
        }
    }

}
  :deep(.actions){
        padding: $padding calc(#{$padding} * 2);
        margin: 0 !important;
		.w1{
			margin-right: 44px;
		}
		.nm-send{
		height: 36px;
		border-radius: 44px;
		}
    }
.nm-flex{
	display: inline-flex;
}
.nm-tool-flex{
		display: inline-flex;
		align-items: center;
		.ico{
		cursor: pointer;
		margin-right: 10px;
		color: $gray-D2;
		line-height: 0.5;
		font-size: calc(8px + 1vw);
		&:last-child{
			margin-right: 0px;
		}
			&:hover, &.active{
		color: $gray-D3;
		}
    }
		.icon-nm{
				margin-right: 0px !important;	
			}
		.icon-double-carret-down{
			line-height: 2.0 !important;
			margin-right: 0px !important;
		}
}

:deep(.nm-content){
		height: 100%;
		width: 95% !important;
		 .field{
			height: 100%;
			max-height: 80vh !important;
            border-radius: 0%;
            border:0px; 
			box-shadow: none;
			textarea{
				padding: 0px !important;
			}
            i{
                line-height: 1;
            }
			&:hover{
				border:0px;
				box-shadow:none;
			}
			&.focus{
				border:0px;
				box-shadow: none;
			}
        }
	}
.nm-formatter{
    position:fixed;
    margin-left: calc(#{$padding} * 2) !important;
    margin-right: calc(#{$padding} * 2) !important;
    width: 48vw !important;
    height: 36px;
    border: none;
    bottom: 98px;
    border-radius: 16px;
    box-shadow: 0px 4px 5px 0px rgba(0,0,0,.14),0px 1px 10px 0px rgba(0,0,0,.12),0px 2px 4px -1px rgba(0,0,0,.2);
	.nm-toolbar{
		height: 100%;
		padding: 12px 12px;
	}
		.toolbar-div{
		width: 1px;
		height: 20px;
		border-left: 1px solid #cfcfcf ;
		margin-right: 10px;
		
	}
}
</style>