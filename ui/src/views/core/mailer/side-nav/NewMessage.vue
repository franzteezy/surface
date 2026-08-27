<template>
    <Wrapper nm class="content-wrap">
    <!-- <vue-final-modal v-model="show" classes="modal-container" content-class="modal-content"> -->
        <Row class="title" split>
            <Column w10 centerv>
                <P xl semibold>{{title}}</P>
            </Column>
            <Column w3 end centerv>
                <div class="nm-flex">
                    <i class="icon icon-hide-window" @click="hideWindow()"></i>
                    <i class="icon icon-maximize" @click="maxWindow()"></i>
                    <i class="icon icon-clear" @click="closeWindow()"></i>
                </div>
            </Column>
        </Row>
		<Row class="nm-row">
			<Column centerh>
				<Input v-model:value="mailer.email_to" class="nm-rec" placeholder="Recipients"></Input>
			</Column>
		</Row>
		<Row class="nm-row">
			<Column centerh>
				<Input v-model:value="mailer.subject" class="nm-rec" placeholder="Subject"></Input>
			</Column>
		</Row>
		<Wrapper nm class="content" @dragover.prevent @drop.prevent>
			<Row class="nm-textarea" nm >	
				<Column centerh class="colTextarea">
						<div @drop="onFileChange" id="textEditor" ref="text" :class="{text:true, dragOver:isOver}" :contenteditable="true" spellcheck="true" v-html="(isOver ? dragDropContent : content)" @input="input" @keyup="process_current_text_style" @keydown="keydown">
						</div>						
				</Column>
			</Row>
			<Row nm :class="{attContainer:true, attToolbarExist:formatText, attToolbarNotExist:!formatText}">
				<Column centerv>
					<Row class="nm-attachments" v-for="(file, index) in fileUploads">
						<Column centerv>
								<P large semibold class="att-link"><a  :href="file.url" :download="file.fileName">{{file.fileName}}</a> ({{file.size}}) <i class="icon icon-clear" @click="removeAttachment(index)"></i></P>
						</Column>
					</Row>
				</Column>
			</Row>
		</Wrapper>
		<Row class="actions" centerv>
			<Column :w1="this.maximized ? true : null" :w3="!this.maximized ? true : null" centerv>
				<Button class="nm-send" small icon="send" @click="sendClick">Send</Button>
			</Column>
			<Column w10 centerv>
				<div class="nm-tool-flex">
					
				<i @click="format()" :class="{icon:true, 'icon-text-formatting':true, ico:true, active:formatText}"></i>
				<i class="icon icon-paperclip ico" @click="browseFile"><input type="file" ref="fileBrowse" style="display:none;" @change="onFileChange"/></i>
				<i class="icon icon-link ico"></i>
				<i class="icon icon-photo ico" @click="browsePhoto"><input type="file" ref="photoBrowse" accept="image/*" @change="onFileChange" style="display:none;"/></i>
				<i class="icon icon-dots-vertical ico"></i>
				
				</div>
			</Column>
			<Column w1 centerv end>
				<i class="icon icon-trash ico"></i>
			</Column>
		</Row>

		<Wrapper nm :class="{nmFormatter:this.maximized, nmFormatterMin:!this.maximized}" v-if="formatText">
			<Row :class="{nmToolbar: this.maximized, nmToolbarMin:!this.maximized}" >
				<Column centerv>
					<vue-file-toolbar-menu :content="menu" class="bar" />
				</Column>
			</Row>
		</Wrapper>
    </Wrapper>
    <!-- </vue-final-modal> -->
</template>

<script>
import {ModalsContainer, VueFinalModal} from 'vue-final-modal'
import VueFileToolbarMenu from 'vue-file-toolbar-menu';
import { Console } from 'console';

export default {
    components: {
        VueFinalModal,
        ModalsContainer,
		VueFileToolbarMenu,    },
    watch:{
        show(newval){
            this.$emit('update:show', newval);
        },
        nmMinimize(newval){
            this.$emit('update:nmMinimize', newval);
        },
		content: {
		immediate: true,
		deep: true,
		// Fill undo / redo history stack on user input
			handler (new_content) {
				if(!this._mute_next_content_watcher) { // only update the stack when content is changed by user input, not undo/redo commands
				this.content_history[++this.undo_count] = new_content[0];
				this.content_history.length = this.undo_count + 1; // remove all redo items
				}
				this._mute_next_content_watcher = false;
			}
		}

    },
    props: {
        content: {Type: Array, default: []},
        show: {Type: Boolean, default: false},
        maximized: {Type: Boolean, default: false},
        nmMinimize: {Type: Boolean, default: false},
        title: {Type: String, default: ''},
        confirm: {Type: String, default: 'Confirm'},
        cancel: {Type: String, default: 'Cancel'},
    },
    data(){
        return{
			dragDropContent: [' <!-- <div style="position:relative; margin-top: 10%; margin-left: 30%; "><span style="color: $gray-L3"><h1>DRAG AND DROP HERE</h1></span></div> -->'],
			font: "Arial",
			align: "align-left-2",
            indent: "caret-down",
			color: "rgb(0, 0, 0)",
			theme: "default",
			size: "Small",
			fileUploads: [],
			imageUploads: [],
			hasAttachments: false,
			sz: 30,
			formatText: true,
			current_text_style: false,
			undo_count: -1, 
			content_history: [],
			_mute_next_content_watcher: false,
			selBeforeUndo: false,
			isOver: false
        }
    },
    computed: {
		mailer(){
			return window.store.mailer.single
		},
		menu () {
		return [
			
			// Undo / redo commands
		{ title: "Undo", icon: "undo", disabled: !this.can_undo, hotkey: this.isMacLike ? "command+z" : "ctrl+z", click: () => this.undo() },
		{ title: "Redo", icon: "redo", disabled: !this.can_redo, hotkey: this.isMacLike ? "shift+command+z" : "ctrl+y", click: () => this.redo() },
		{ is: "separator" },
		{
			html: '<div class="ellipsis font-menu-m" style="width: 80px; font-size: 95%;">'+this.font+'</div>',
			title: "Font",
			chevron: true,
			menu_class: "menu-font",
			menu: this.font_menu,
		},
		{ is: "separator" },
		{
			icon: "letter",
			title: "Font Size",
			chevron: true,
			menu: this.size_menu,
			menu_class: "font-size"
		},
		{ is: "separator" },
		// Rich text menus
		{ icon: "text-bold", active: this.isBold, title: "Bold", hotkey: this.isMacLike ? "command+b" : "ctrl+b", click: () => document.execCommand("bold") },
		{ icon: "text-italic", active: this.isItalic, title: "Italic", hotkey: this.isMacLike ? "command+i" : "ctrl+i", click: () => document.execCommand("italic") },
		{ icon: "text-underline", active: this.isUnderline, title: "Underline", hotkey: this.isMacLike ? "command+u" : "ctrl+u", click: () => document.execCommand("underline") },
		{ icon: "strikethrough", active: this.isStrikeThrough, title: "Strike through", click: () => document.execCommand("strikethrough") },
		{is: "separator" },
		{
			is: "button-color",
			type: "compact",
			menu_class: "align-center",
			stay_open: false,
			color: this.color,
			update_color: (new_color) => { this.color = new_color; document.execCommand('foreColor', false, new_color.hex8); }
		},
		{ is: "separator" },
		{
			icon: this.align,
			title: "Align",
			menu_class: "menu-align",
			chevron: true,
			menu: this.align_menu,
			menu_width: 60
		},
		{is: "separator"},
		{ icon: "list-ol", active: this.isNumberedList, title: "Numbered list", click: () => document.execCommand("insertOrderedList") },
		{ icon: "list-bullet", active: this.isBulletedList, title: "Bulleted list", click: () => document.execCommand("insertUnorderedList") },
		{ is: "separator" },
		this.indentMinimize,
		this.outdentMinimize,
		this.clearFormat,
		this.indentMenu,
		// { icon: "indent-more", sbutton_class: "indent-btn", title: "Increase indent", hotkey: "tab", click: () => document.execCommand("indent") },
		// { icon: "indent-less", button_class: "indent-btn", title: "Decrease indent", hotkey: "shift+tab", click: () => document.execCommand("outdent") },
		// { is: "separator" },
        // { icon: "caret-down", title: "Clear format", click () { document.execCommand('removeFormat'); document.execCommand('formatBlock', false, '<div>'); } }
		]
		},
		clearFormat(){
			if(this.maximized){
				return { icon: "x-alt", title: "Clear format", click () { document.execCommand('removeFormat'); document.execCommand('formatBlock', false, '<div>'); } };
			}
			return {};
		},
		indentMenu(){
			if(!this.maximized){
				return {
					icon: this.indent,
					title: "Indent Menu",
					menu_class: "indent-menu",
					menu: this.indent_menu,
					menu_width: 50
				};
			}
			return {is: "separator"};
		},
		indentMinimize(){
			if(this.maximized){
				return { icon: "indent-more", button_class: "indent-btn", title: "Increase indent", hotkey: "tab", click: () => document.execCommand("indent") };
			}
			return {};
		},
		outdentMinimize(){
			if(this.maximized){
				return { icon: "indent-less", button_class: "indent-btn", title: "Decrease indent", hotkey: "shift+tab", click: () => document.execCommand("outdent") };
			}
			return {};
		},
		isMacLike: () => /(Mac|iPhone|iPod|iPad)/i.test(navigator.platform),
		font_menu () {
			return this.font_list.map(font => {
				return {
				html: '<span class="ellipsis" style="font-family:'+font+'">'+font+'</span>',
				icon: (this.theme != "default" && this.font == font) ? 'check' : false,
				active: (this.font == font),
				height: 25,
				click: () => {
					document.execCommand("fontName", false, font);
					this.font = font;
				}
				};
		});
	},
	align_menu () {
		return this.align_list.map(align => {
			return {
			icon: align,
			active: (this.align == align),
			height: 25,
			hotkey: this.getHotkey(align),
			title: align + ' ' + this.getHotkey(align),
			click: () => {
				switch(align){
					case "align-left-2": document.execCommand("justifyLeft");
						break;
					case "align-center": document.execCommand("justifyCenter");
						break;
					case "align-right": document.execCommand("justifyRight");
						break;
					case "text-center": document.execCommand("justifyFull");
						break;
				}
				this.align = align;
			}
			};
		});
	},
	size_menu(){
		return this.size_list.map(size => {
			let sz = "";
			switch(size){
				case "Small": sz = "10px";
					break;
				case "Normal": sz = "13px";
					break;
				case "Large": sz = "18px";
					break;
				case "Huge": sz = "32px";
					break;
			}
			return {
				html: '<span style="font-size:'+ sz +'">'+size+'</span>',
				icon: (this.checkSize == sz) ? 'checkmark' : false,
				active: (this.checkSize == sz),
				height: 25,
				click: () => {
					this.execSize(sz);
					// this.execFontSize(sz, 'px');
					this.size = size;
				}
			}
		})
	},
	indent_menu() {
        return this.indent_list.map(ind => {
			let op = ""
			switch(ind)
			{
				case "indent-more": op = "indent"
					break;
				case "indent-less": op = "outdent"
					break;
				case "x-alt": op = "removeFormat"
					break;
			}
            return{
                icon: ind,
                active: (this.indent == ind),
				heigth: 18,
				click: () => {
					document.execCommand(op);
					if(op == "x-alt"){
						console.log(op);
						document.execCommand('formatBlock', false, '<div>');
					}
				}
            }
        })
    },
    indent_list: () => ['indent-more', 'indent-less', 'x-alt'],
	align_list: () =>["align-left-2", "align-center", "align-right", "text-center"],
    font_list: () => ["Arial", "Arial Narrow", "Arial Black", "Comic Sans MS", "Garamond", "Georgia", "Impact", "Sans Serif", "Tahoma", "Trebuchet MS", "Verdana"],
    size_list: () => ["Small", "Normal", "Large", "Huge"],
	is_touch_device: () => ("ontouchstart" in window) || (window.navigator.msMaxTouchPoints > 0),
	 isBold () {
      const fontWeight = this.current_text_style.fontWeight;
      return fontWeight && (parseInt(fontWeight) > 400 || fontWeight.indexOf("bold") == 0);
    },
	checkSize () {
      const fontSize = this.current_text_style.fontSize;
      return fontSize;
    },
	isItalic () { return this.current_text_style.fontStyle == "italic"; },
    isUnderline () { // text-decoration is not overridden by children, so we query the parent stack
      const stack = this.current_text_style.textDecorationStack;
      return stack && stack.some(d => (d.indexOf("underline") == 0));
    },
    isStrikeThrough () { // text-decoration is not overridden by children, so we query the parent stack
      const stack = this.current_text_style.textDecorationStack;
      return stack && stack.some(d => (d.indexOf("line-through") == 0));
    },
	isNumberedList () { return this.current_text_style.isList && this.current_text_style.listStyleType == "decimal"; },
	isBulletedList () { return this.current_text_style.isList && ["disc", "circle"].includes(this.current_text_style.listStyleType); },
	can_undo () { return this.undo_count > 0; },	
	can_redo () { return this.content_history.length - this.undo_count - 1 > 0; }
    },
    methods: {
        hideWindow(){
            this.$emit('hide', true);
        },
        maxWindow(){
            this.$emit('maximize', true);
        },
        closeWindow(){
            this.$emit('close', true);
        },
		execSize(size) {
		var sel, range;
		if (document.getSelection && (sel = document.getSelection()).rangeCount) {
			let selText = this.getSelectedText();
			let selTextStr = selText.toString();
			console.log(sel);
			range = selText.getRangeAt(0);
			// range.collapse(true);
			var span = document.createElement("span");
			span.id = "myId";
			span.style.fontFamily = this.current_text_style.fontFamily;
			span.style.fontSize = size;
			span.textContent = selText;
			range.deleteContents();
			range.insertNode(span);

			// Move the caret immediately after the inserted span
			range.setStartAfter(span);
			range.collapse(true);
			// sel.removeAllRanges();
			// sel.addRange(range);
		}
	},
		getSelectedText() {
				var t = (document.all) ? document.selection.createRange().text : document.getSelection();
				return t;
		},
		focus_text () {
			this.$refs.text.focus();
			document.execCommand('selectAll', false, null);
			document.getSelection().collapseToEnd();
		},
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
		},
		sendClick(){
				this.mailer.email_from = "tst@gmail.com";
				this.mailer.uploadedFiles = this.fileUploads;
				this.mailer.uploadedImages = this.imageUploads;
				window.store.mailer.put().then(() => {
					console.log("success");
                });
		},
		getHotkey(val){
			
			switch(val){
				case "align-left-2":
					return this.isMacLike ? "shift+command+l" : "ctrl+shift+l";
						break;
					case "align-center": 
					return this.isMacLike ? "shift+command+e" : "ctrl+shift+l";
						break;
					case "align-right": 
					return this.isMacLike ? "shift+command+r" : "ctrl+shift+l";
						break;
					case "text-center":
					return this.isMacLike ? "shift+command+j" : "ctrl+shift+l";
						break;
			}
		},
    // Input event
    input (e) {
      if(!e) return;
		console.log(this.undo_count);
	  this.content[0] = e.target.innerHTML;
		this.mailer.content = this.content[0];
		// this.$emit('update:content', this.content);
      if(e.inputType != "insertText") this.process_current_text_style(); // update current style if it has changed
    },
    // Keydown event
    keydown (e) {
    //   if the document is empty, prevent removing the first page container with a backspace input (keycode 8)
    //   which is now the default behavior for web browsers
      if(e.keyCode == 8 && this.content.length <= 1) {
        const is_text = (this.content[0][0] && typeof(this.content[0][0]) == "string") ? this.content[0][0].replace(/<\w+(\s+("[^"]*"|'[^']*'|[^>])+)?>|<\/\w+>/gi, '') : false;
        if(!is_text) e.preventDefault();
      }
    },

		process_current_text_style () {
			let style = false;
			const sel = window.getSelection();
			if(sel.focusNode) {
				const element = sel.focusNode.tagName ? sel.focusNode : sel.focusNode.parentElement;
				if(element && element.isContentEditable) {
				style = window.getComputedStyle(element);
				style.textDecorationStack = [];
				style.headerLevel = 0;
				style.isList = false;
				let parent = element;
				while(parent){
					const parent_style = window.getComputedStyle(parent);
					style.textDecorationStack.push(parent_style.textDecoration);
					if(parent_style.display == "list-item") style.isList = true;
					if(!style.headerLevel){
					for(let i = 1; i <= 6; i++){
						if(parent.tagName.toUpperCase() == "H"+i) {
						style.headerLevel = i;
						break;
						}
					}
					}
					parent = parent.parentElement;
				}
				}
			}
			this.current_text_style = style;
			let fontSize = this.checkSize;
			switch(fontSize){
				case "10px": this.size = "Small";
					break;
				case "13px": this.size = "Normal";
					break;
				case "18px": this.size = "Large";
					break;
				case "32px": this.size = "Huge";
					break;
			}
		},
		
		undo () { if(this.can_undo){ this._mute_next_content_watcher = true; this.content = [this.content_history[--this.undo_count]]; }},
		redo () { if(this.can_redo){ this._mute_next_content_watcher = true; this.content = [this.content_history[++this.undo_count]]; }},
		resetContentHistory () { this.content_history = []; this.undo_count = -1; },
		
		onFileChange(e) {
			var files = e.target.files || e.dataTransfer.files;
			var progress = document.getElementsByTagName('progress')[0];
			
			if (!files.length)
				return;

			let fileUrl = ""
			for(let i = 0; i < files.length; i ++){
			var reader = new FileReader();
				reader.onload = (e) => {
					fileUrl = e.target.result;

					if(files[i].type.includes("image")){
						var img = new Image();
						img.src = fileUrl;
						img.style.display = "block";
						img.style.objectFit = "contain";
						img.style.maxHeight = "auto";
						img.style.maxWidth= "400px";
						img.href = fileUrl;
						this.imageUploads.push({
							fileName: files[i].name,
							size: this.formatBytes(files[i].size),
							type: files[i].type,
							url: fileUrl,
							loaded: false
						})
						this.$refs.text.appendChild(img);
						this.content[0] = this.$refs.text.innerHTML;
						this.mailer.content = this.content[0];
					}else{
							this.fileUploads.push({
							fileName: files[i].name,
							size: this.formatBytes(files[i].size),
							type: files[i].type,
							url: fileUrl,
							loaded: false
						})
					}
				}
				reader.readAsDataURL(files[i]);
			}
			this.isOver = false;
		},
		removeAttachment(index){
			this.fileUploads.splice(index, 1);
		},
		formatBytes(bytes, decimals = 2) {
			if (bytes === 0) return '0 Bytes';

			const k = 1024;
			const dm = decimals < 0 ? 0 : decimals;
			const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

			const i = Math.floor(Math.log(bytes) / Math.log(k));

			return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
		}
	},
    created() {
			let start_zoom_gesture = false;
			let start_dist_touch = false;
			let start_zoom_touch = false;
			// Manage ctrl+scroll zoom (or trackpad pinch)
			window.addEventListener("wheel", (e) => {
			if(e.ctrlKey){
				e.preventDefault();
				this.zoom = Math.min(Math.max(this.zoom - e.deltaY * 0.01, this.zoom_min), this.zoom_max);
			}
			}, { passive: false });
			// Manage trackpad pinch on Safari
			window.addEventListener("gesturestart", (e) => {
			e.preventDefault();
			start_zoom_gesture = this.zoom;
			});
			window.addEventListener("gesturechange", (e) => {
			e.preventDefault();
			if(!start_zoom_touch){
				this.zoom = Math.min(Math.max(start_zoom_gesture * e.scale, this.zoom_min), this.zoom_max);
			}
			});
			window.addEventListener("gestureend", () => {
			start_zoom_gesture = false;
			});
			// Manage pinch to zoom for touch devices
			window.addEventListener("touchstart", (e) => {
			if (e.touches.length == 2) {
				e.preventDefault();
				start_dist_touch = Math.hypot(
				e.touches[0].pageX - e.touches[1].pageX,
				e.touches[0].pageY - e.touches[1].pageY
				);
				start_zoom_touch = this.zoom;
			}
			}, { passive: false });
			window.addEventListener("touchmove", (e) => {
			if (start_dist_touch && start_zoom_touch) {
				e.preventDefault();
				let zoom = start_zoom_touch * Math.hypot(
				e.touches[0].pageX - e.touches[1].pageX,
				e.touches[0].pageY - e.touches[1].pageY
				) / start_dist_touch;
				this.zoom = Math.min(Math.max(zoom, this.zoom_min), this.zoom_max);
			}
			}, { passive: false });
			window.addEventListener("touchend", () => {
			start_dist_touch = false;
			start_zoom_touch = false;
			}, { passive: false });
			// Manage history undo/redo events
			const manage_undo_redo = (e) => {
			switch(e && e.inputType){
				case "historyUndo": e.preventDefault(); e.stopPropagation(); this.undo(); break;
				case "historyRedo": e.preventDefault(); e.stopPropagation(); this.redo(); break;
				}
			}
			window.addEventListener("beforeInput", manage_undo_redo);
			window.addEventListener("input", manage_undo_redo); // in case of beforeinput event is not implemented (Firefox)


    },
    mounted() {
		this.mounted = true;	
        // this.$el.parentNode.removeChild(this.$el);
		window.addEventListener("click", this.process_current_text_style);
		this.$refs.text.addEventListener("dragover", () => {
        		this.isOver = true;
      	});
		this.$refs.text.addEventListener("dragleave", () => {
				this.isOver= false;
		}); 
        // document.getElementById('modal-wrapper').appendChild(this.$el);
		if(!this.is_touch_device) this.focus_text();
		
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";

.content-wrap{
    height: 100%;
}
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
:deep(.title){
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
:deep(.actions){
        padding: $padding calc(#{$padding} * 2);
        margin: 0 !important;
		.w1{
			margin-right: 56px;
            &:last-child{
                margin-right: 0px;
            }
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
.attToolbarNotExist{
	top: 30px
}
.attToolbarExist{
	top: 0px
}
.attContainer{
	position:relative;
	padding-left: calc(#{$padding} * 2) !important;
    padding-right: calc(#{$padding} * 2) !important;
    border: none;
	.nm-attachments{
    	height: 36px;
		width:fit-content;
		padding: 12px 12px;
		border-radius: 16px;
		margin-bottom: 8px;
		background-color: #f5f5f5 !important;
	}
}
:deep(.nmFormatter){
    position:fixed;
    margin-left: calc(#{$padding} * 2) !important;
    margin-right: calc(#{$padding} * 2) !important;
	width: calc(56vw - 10px);
	min-width: 795px;
    border: none;
    bottom: 98px;
	
	.bar-separator{
		&:last-child{
			display: none;
		}
	}
	
	.nmToolbar{
		background-color: #FFFFFF !important;
    	width: calc(56vw - 10px) !important;
    	height: 36px;
		// height: 100%;
		min-width: 795px;
		padding: 12px 12px;
		border-radius: 16px;
    	box-shadow: 0px 4px 5px 0px rgba(0,0,0,.14),0px 1px 10px 0px rgba(0,0,0,.12),0px 2px 4px -1px rgba(0,0,0,.2);
	}
		.toolbar-div{
		width: 1px;
		height: 20px;
		border-left: 1px solid #cfcfcf ;
		margin-right: 10px;
		
	}
}

:deep(.nmFormatterMin){
    position:fixed;
    margin-left: calc(#{$padding} * 2) !important;
    margin-right: calc(#{$padding} * 2) !important;
	width:35vw;
	min-width: 504px;
    border: none;
    bottom: 60px;

	
	.nmToolbarMin{
		position:relative;
		background-color: #FFFFFF !important;
    	width: 35vw !important;
		min-width: 504px;
    	height: 36px;
		// height: 100%;
		padding: 12px 12px;
		border-radius: 16px;
    	box-shadow: 0px 4px 5px 0px rgba(0,0,0,.14),0px 1px 10px 0px rgba(0,0,0,.12),0px 2px 4px -1px rgba(0,0,0,.2);
        .col{
            .bar{

			.indent-menu{
				top: -140px !important;
			}
			.menu-font{
				top: -300px !important;
			}
			.menu-align{
				top: -110px !important;
				.bar-menu-items > .bar-menu-item > .hotkey{
					display:none;
				}
			}
			.font-size{
				top: -110px !important;
				.bar-menu-items > .bar-menu-item > .icon{
					font-size: 12px;
				}
			}
                .bar-button{
                    padding: 1px;
                    .label{
						
                            .font-menu-m{
                            width:60px !important;
                       }
                    }
                    .icon{
                        width:20px;
                        line-height: 1;
                        .icon{
                            font-size: 18px;
                        }
                    }
                }
            }
        }
	}
		.toolbar-div{
		width: 1px;
		height: 20px;
		border-left: 1px solid #cfcfcf ;
		margin-right: 10px;
		
	}
}

:deep(.bar) {
    z-index: 1000;
    backdrop-filter: blur(10px);
    --bar-button-active-color: #188038;
    --bar-button-open-color: #188038;
    --bar-button-active-bkg: #e6f4ea;
    --bar-button-open-bkg: #e6f4ea;

	.menu-font{
		top: -300px !important;
	}
	.menu-align{
		top: -110px !important;
		.bar-menu-items > .bar-menu-item > .hotkey{
			display:none;
		}
	}
	.font-size{
		top: -110px !important;
		.bar-menu-items > .bar-menu-item > .icon{
			font-size: 12px;
		}
	}
  }
  .text {
	position: relative;
  font-family: var(--bar-font-family);
  width: 95%;
  margin: 0px;
  padding: 24px 16px;
  min-height: 45vh;
  transition: .5s;
  outline: none;
  }
  .nm-textarea{
	display:table;
	.colTextarea{
		width: 100%;
	}
  }

  .att-link{
	white-space: nowrap;
	a{
		text-decoration: none;
		color:#15c;
	}
	.icon-clear{
		cursor:pointer;
		line-height: 0.5;
	}
}
.dragOver{
	-webkit-transition: none !important;
	-moz-transition: none !important;
	-o-transition: none !important;
	transition: none !important;
	border: 4px solid $gray-D1;
 	border-style: dashed;
	align-content: center;
	vertical-align: middle;
	align-items: center;
}
</style>