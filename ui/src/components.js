//Static
import Core from "./Core.vue";
import Notifier from "./components/invokers/Notifier.vue";
import Base from "./views/Base.vue";

//Dynamics
import Todo from "./components/dynamics/Todo.vue";
import Activity from "./components/dynamics/Activity.vue";
import Submenu from "./components/dynamics/Submenu.vue";
import ContextMenu from "./components/dynamics/ContextMenu.vue";
import Avatar from "./components/dynamics/Avatar.vue";
import MailModal from "./components/dynamics/MailModal.vue";
import Modal from "./components/dynamics/Modal.vue";
import Tip from "./components/dynamics/Tip.vue";
import Steps from "./components/dynamics/Steps.vue";
import Campaignlistview from "./components/dynamics/Campaignlistview.vue";
import Campaignboxview from "./components/dynamics/Campaignboxview.vue";
import Campaignintegrations from "./components/dynamics/Campaignintegrations.vue";
import Campaignuploadfile from "./components/dynamics/Campaignuploadfile.vue";

//Fields
import Input from "./components/fields/Input.vue";
import Dropdown from "./components/fields/Dropdown.vue";
import Checkbox from "./components/fields/Checkbox.vue";
import Editor from "./components/fields/Editor.vue";
import Image from "./components/fields/Image.vue";
import Tel from "./components/fields/Tel.vue";
import Radio from "./components/fields/Radio.vue";
import Filter from "./components/fields/Filter.vue";
import Textarea from "./components/fields/Textarea.vue";
import Loc from "./components/fields/Loc.vue";

//Layouts
import Notification from "./components/layout/Notification.vue";
import Button from "./components/layout/Button.vue";
import H1 from "./components/layout/H1.vue";
import H2 from "./components/layout/H2.vue";
import H3 from "./components/layout/H3.vue";
import H4 from "./components/layout/H4.vue";
import H5 from "./components/layout/H5.vue";
import H6 from "./components/layout/H6.vue";
import P from "./components/layout/P.vue";
import Wrapper from "./components/layout/Wrapper.vue";
import Row from "./components/layout/Row.vue";
import Box from "./components/layout/Box.vue";
import Col from "./components/layout/Col.vue";
import Menu from "./components/layout/Menu.vue";
import Top from "./components/layout/Top.vue";

//Menus
import CrmMenu from "./wrappers/menu/CrmMenu.vue";
import ModuleArea from "./components/dynamics/ModuleArea.vue";
import Nav from "./components/dynamics/Nav.vue";
import UserArea from "./components/dynamics/UserArea.vue";

//Login screens
import LoginScreen from "./wrappers/login/Login.vue";
import ResetPassword from "./wrappers/login/ResetPassword.vue";
import ForgotPassword from "./wrappers/login/ForgotPassword.vue";

//Register steps
import RegisterStepOne from "./wrappers/register/StepOne.vue";
import RegisterStepTwo from "./wrappers/register/StepTwo.vue";
import RegisterStepThree from "./wrappers/register/StepThree.vue";
import RegisterStepFour from "./wrappers/register/StepFour.vue";
import RegisterStepVerify from "./wrappers/register/StepVerify.vue";
import RegisterStepFive from "./wrappers/register/StepFive.vue";

//Campaign Create
import Campaignstepone from "./wrappers/createcampaign/campaignstepone.vue";
import Campaignsteptwo from "./wrappers/createcampaign/campaignsteptwo.vue";
import Campaignstepthree from "./wrappers/createcampaign/campaignstepthree.vue";
import Campaignstepfour from "./wrappers/createcampaign/campaignstepfour.vue";
import Campaignstepfive from "./wrappers/createcampaign/campaignstepfive.vue";

//Modals
import AddCustomerModal from "./components/modals/crm/AddCustomer.vue";
import AddCustomerCompany from "./components/modals/crm/AddCustomerCompany.vue";
import NewMessageModal from "./components/modals/mailer/NewMessageModal.vue";
import NewMessage from "./views/core/mailer/side-nav/NewMessage.vue"
import Chats from "./views/core/chats/Chats.vue"
import ChatBubble from './views/core/chats/ChatBubble.vue';
import ChatMsgs from './views/core/chats/ChatMsgs.vue';
import ChatSocket from './views/core/chats/ChatSocket.vue'
import DocumentEditor from "../node_modules/vue-document-editor/src/DocumentEditor/DocumentEditor.vue"


//import global components here
export default function (app) {
    app.component('Core', Core);
    app.component('Input', Input);
    app.component('Dropdown', Dropdown);
    app.component('Checkbox', Checkbox);
    app.component('Editor', Editor);
    app.component('Image', Image);
    app.component('Radio', Radio);
    app.component('Textarea', Textarea);
    app.component('Notification', Notification);
    app.component('Notifier', Notifier);
    app.component('Button', Button);
    app.component('Tel', Tel);
    app.component('Loc', Loc);
    app.component('H1', H1);
    app.component('H2', H2);
    app.component('H3', H3);
    app.component('H4', H4);
    app.component('H5', H5);
    app.component('H6', H6);
    app.component('P', P);
    app.component('Wrapper', Wrapper);
    app.component('Row', Row);
    app.component('Box', Box);
    app.component('Column', Col);
    app.component('Steps', Steps);
    app.component('Base', Base);
    app.component('Menu', Menu);
    app.component('CrmMenu', CrmMenu);
    app.component('ModuleArea', ModuleArea);
    app.component('Nav', Nav);
    app.component('UserArea', UserArea);
    app.component('Todo', Todo);
    app.component('Activity', Activity);
    app.component('Top', Top);
    app.component('Avatar', Avatar);
    app.component('Filter', Filter);
    app.component('Submenu', Submenu);
    app.component('ContextMenu', ContextMenu);
    app.component('Modal', Modal);
    app.component('Tip', Tip);
    app.component('MailModal', MailModal);

    //Campaign View
    app.component('Campaignlistview', Campaignlistview);
    app.component('Campaignboxview', Campaignboxview);

    //Campaign Create
    app.component('Campaignstepone', Campaignstepone);
    app.component('Campaignsteptwo', Campaignsteptwo);
    app.component('Campaignstepthree', Campaignstepthree);
    app.component('Campaignstepfour', Campaignstepfour);
    app.component('Campaignstepfive', Campaignstepfive);
    app.component('Campaignintegrations', Campaignintegrations);
    app.component('Campaignuploadfile', Campaignuploadfile);

    //RegisterSteps
    app.component('RegisterStepOne', RegisterStepOne);
    app.component('RegisterStepTwo', RegisterStepTwo);
    app.component('RegisterStepThree', RegisterStepThree);
    app.component('RegisterStepFour', RegisterStepFour);
    app.component('RegisterStepVerify', RegisterStepVerify);
    app.component('RegisterStepFive', RegisterStepFive);

    //Login screens
    app.component('LoginScreen', LoginScreen);
    app.component('ResetPassword', ResetPassword);
    app.component('ForgotPassword', ForgotPassword);

    //Modals
    app.component('AddCustomerModal', AddCustomerModal);
    app.component('AddCustomerCompany', AddCustomerCompany);
    app.component('NewMessageModal', NewMessageModal);
    app.component('NewMessage', NewMessage);
    app.component('Chats', Chats);
    app.component('ChatBubble', ChatBubble);
    app.component('ChatMsgs', ChatMsgs);
    app.component('ChatSocket', ChatSocket);
    //packagelib
    app.component("DocumentEditor", DocumentEditor);
}