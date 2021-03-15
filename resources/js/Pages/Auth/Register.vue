<template>
    <jet-authentication-card>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <h1></h1>
            </div>
            <div>
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>
            <div class="mt-4">
                <jet-label for="username" value="Username" />
                <jet-input id="username" type="text" class="mt-1 block w-full" v-model="form.username" required />
            </div>
            <div class="mt-4">
                <jet-label for="org_id" value="Student/Staff ID Number" />
                <jet-input id="org_id" type="text" class="mt-1 block w-full" v-model="form.org_id" required />
            </div>
            <div class="mt-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>
            <jet-section-border />
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                Please add some skills to your profile.
            </h2>
            <div class="mt-4">
                <jet-label for="skills" value="Your Skills" />
                <select v-model="currentSelect" @change="addTag(currentSelect)" class="block mt-1 mb-10 w-full">
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

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            JetSectionBorder
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    username: '',
                    org_id: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    user_tags: [],
                    terms: false,
                }),

                currentSelect: {},
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
                            return;                                         //return so the state of match is saved
                        } else {
                            //Do nothing, want to check all of user_tags
                        }
                    }

                    if (!match) {                                           //now all of user_tags checked, if no match
                        this.form.user_tags.push(value);                           //then we can safely add tag to user_tags 
                    }
                }


            },

            removeTag(tag) {
                this.form.user_tags.splice(this.form.user_tags.indexOf(tag), 1);

            },

            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
