<template>
    <jet-authentication-card>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <h1></h1>
            </div>
            <div>
                <jet-label for="name">Name<span class="text-red-600"> *</span></jet-label>
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>
            <div class="mt-4">
                <jet-label for="username">Username<span class="text-red-600"> *</span></jet-label>
                <jet-input id="username" type="text" class="mt-1 block w-full" v-model="form.username" required />
            </div>

            <div class="mt-4">
                <jet-label for="org_id"><span>Organisation ID</span><button @click.native="showOrgModalId" class="ml-5 text-blue-600 border-2 rounded p-0.2 pl-1 pr-1">?</button></jet-label>
                <jet-input id="org_id" type="text" class="mt-1 block w-full" v-model="form.org_id" />
            </div>

            <div class="mt-4">
                <jet-label for="org_name"><span>Organisation Name</span><button @click.native="showOrgModalName" class="ml-5 text-blue-600 border-2 rounded p-0.2 pl-1 pr-1">?</button></jet-label>
                <jet-input id="org_name" type="text" class="mt-1 block w-full" v-model="form.org_name" />
            </div>

            <jet-dialog-modal :show="showOrgIdInfo" @close="showOrgIdInfo = false">
                <template #content>
                    If you're registering as a student or university employee, please use your university ID for this field.
                    Otherwise, leave it blank
                </template>
            </jet-dialog-modal>

            <jet-dialog-modal :show="showOrgNameInfo" @close="showOrgNameInfo = false">
                <template #content>
                    <ul>
                        <li class="mb-5">If you're registering as a student, please use the name of your university for this field.</li>
                        <li class="mb-5">If you're registering as an employee of a non-university organisation, please use the company name.</li>
                        <li class="mb-5">If you want to become a program vendor, you can request this under profile information.</li>
                    </ul>
                </template>
            </jet-dialog-modal>

            <jet-section-border />

            <div class="mt-4">
                <jet-label for="email">Email<span class="text-red-600"> *</span></jet-label>
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mt-4">
                <jet-label for="password">Password<span class="text-red-600"> *</span></jet-label>
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation">Confirm Password<span class="text-red-600"> *</span></jet-label>
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>
            <jet-section-border />
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                Please add some skills to your profile.
            </h2>
            <div class="mt-4">
                <jet-label for="skills" value="Your Skills" />
                <select v-model="currentSelect" @change="addTag(currentSelect)" class="block mt-1 mb-10 w-full">
                    <option :value="undefined" disabled style="display:none">Please Select</option>
                    <option v-for="tag in $attrs.skilltags" :value="tag">{{tag.tag_name}}</option>
                </select>
            </div>

            <div v-for="user_tag in this.form.user_tags" class="border-solid border border-gray-400 max-w-max rounded-md shadow-md mt-3">
                <div class="ml-2 mr-2">
                    {{user_tag.tag_name}}
                    <button @click="removeTag(user_tag)" class="ml-6 inline">x</button>
                </div>
            </div>

            <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Already registered?
                </inertia-link>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import JetDialogModal from '@/Jetstream/DialogModal'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            JetSectionBorder,
            JetDialogModal
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    username: '',
                    org_id: '',
                    org_name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    user_tags: [],
                    terms: false,
                }),

                currentSelect: {},

                showOrgIdInfo: false,
                showOrgNameInfo: false
            }
        },

        methods: {

            addTag(value) {

                if (this.form.user_tags.length < 1) {    //if user hasn't added any tags
                    this.form.user_tags.push(value);       //immediately add tag, no issues can happen

                } else {

                    let match = false;

                    for (var i = 0; i < this.form.user_tags.length; i++) {       //for each tag currently in the user's added tags

                        if (value.tag_id == this.form.user_tags[i].tag_id) {   //if a matching tag is here already
                            match = true;                                   //match is found
                            this.currentSelect = undefined;
                            return;                                         //return so the state of match is saved
                        } else {
                            //Do nothing, want to check all of user_tags
                        }
                    }

                    if (!match) {                                           //now all of user_tags checked, if no match
                        this.form.user_tags.push(value);                           //then we can safely add tag to user_tags 
                    }
                }

                 this.currentSelect = undefined;
            },

            removeTag(tag) {
                this.form.user_tags.splice(this.form.user_tags.indexOf(tag), 1);

            },

            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            },

            showOrgModalId() {
                this.showOrgIdInfo = true;
            },

            showOrgModalName() {
                this.showOrgNameInfo = true;
            }
        }
    }
</script>
