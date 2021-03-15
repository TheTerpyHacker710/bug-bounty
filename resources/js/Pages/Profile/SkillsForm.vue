<template>
    <jet-form-section>
        <template #title>
            Your Skill Tags
        </template>

        <template #description>
            Add a new skill tag or delete an existing skill tag
        </template>

        <template #form>
            <div class="mt-4 col-span-4">
                <jet-label for="skills" value="Your Skills" />
                <select v-model="currentSelect" @change="addTag(currentSelect)" class="block mt-1 mb-10 w-full">
                    <option v-for="tag in this.$props.skilltags" :value="tag">{{tag.tag_name}}</option>
                </select>
            </div>
            <div v-for="user_tag in this.form.new_tags" class="col-span-4 border-solid border border-gray-400 max-w-max rounded-md shadow-md mt-1">
                <span class="ml-2 mr-2">
                    {{user_tag.tag_name}}
                    <button @click="removeTag(user_tag)" class="ml-6 inline">x</button>
                </span>
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submit">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    new_tags: [],
                }),

                currentSelect: {}
            }
        },

        props:{

            user_tags: Array,
            skilltags: Array,
        },

        mounted() {

            this.form.new_tags = this.$props.user_tags;
        },

        methods: {

            addTag(tag) {


                if (this.form.new_tags.length < 1) {    //if user hasn't added any tags
                    this.form.new_tags.push(tag);       //immediately add tag, no issues can happen

                } else {

                    let match = false;

                    for (var i = 0; i < this.form.new_tags.length; i++) {       //for each tag currently in the user's added tags

                        if (tag.tag_id == this.form.new_tags[i].tag_id) {   //if a matching tag is here already
                            match = true;                                   //match is found
                            return;                                         //return so the state of match is saved
                        } else {
                            //Do nothing, want to check all of user_tags
                        }
                    }

                    if (!match) {                                           //now all of user_tags checked, if no match
                        this.form.new_tags.push(tag);                           //then we can safely add tag to user_tags 
                    }
                }

                currentSelect = {};
            },


            removeTag(tag) {
                this.form.new_tags.splice(this.form.new_tags.indexOf(tag), 1);

            },

            submit() {
                this.form.post('/update-skill');
            }
           
        },
    }
</script>
