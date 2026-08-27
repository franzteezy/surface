//Static
import { AuthorizeStore } from "/src/stores/core/authorize";
import { RegisterStore } from "/src/stores/core/register";
import { LocationStore } from "/src/stores/core/location";
import { InvitationStore } from "/src/stores/core/invitation";
import { ForgotPasswordStore } from "./stores/core/forgot-password";
import { CustomerStore } from "./stores/crm/customer";
import { CompanyStore } from "./stores/crm/company";
import { MailerStore } from "./stores/crm/mailer";
import { CdnStore } from "./stores/cdn";
import { ChatStore } from "./stores/core/chat";

//import global components here
export default function () {
    window.store = {
        auth: AuthorizeStore(),
        register: RegisterStore(),
        invitation: InvitationStore(),
        forgotPassword: ForgotPasswordStore(),
        customer: CustomerStore(),
        company: CompanyStore(),
        mailer: MailerStore(),
        location: LocationStore(),
        cdn: CdnStore(),
        chat: ChatStore()
    }
}