<template>
    <app-layout>
        <template #header>
            <form @submit.prevent="submit">
                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                    Please add some skills to your profile.
                </h2>
                <div class="mt-4">
                    <jet-label for="skills" value="Your Skills" />
                    <select id="skills" v-model="selected" class="block mt-1 w-auto">
                        <option disabled value="">Please select some of your skills</option>
                        <option v-for="tag in tags" @click="addTag(tag)">{{tag.tag_name}}</option>
                    </select>
                </div>

                <div v-for="user_tag in this.form.user_tags" class="border-solid border border-gray-400 max-w-max rounded-md shadow-md mt-3">
                    <span class="ml-2  mr-2">
                        {{user_tag.tag_name}}
                        <button @click="removeTag(user_tag)" class="ml-6">x</button>
                    </span>
                </div>
                <jet-button class="mt-6" @click="submit">
                    Submit
                </jet-button>
            </form>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetLabel from '@/Jetstream/Label'
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            AppLayout,
            JetLabel,
            JetButton,
        },
        props: {
            tags: Array,
        },
        data() {
            return {
                form: this.$inertia.form({
                    user_tags: [],
                })            
            }
        },
        methods: {
            addTag(tag) {

             
                if (this.form.user_tags.length < 1) {    //if user hasn't added any tags
                    this.form.user_tags.push(tag);       //immediately add tag, no issues can happen

                } else {

                    let match = false;

                    for (var i = 0; i < this.form.user_tags.length; i++) {       //for each tag currently in the user's added tags

                        if (tag.tag_name == this.form.user_tags[i].tag_name) {   //if a matching tag is here already
                            match = true;                                   //match is found
                            return;                                         //return so the state of match is saved
                        } else {                                            
                                                                            //Do nothing, want to check all of user_tags
                        }
                    }

                    if (!match) {                                           //now all of user_tags checked, if no match
                        this.form.user_tags.push(tag);                           //then we can safely add tag to user_tags 
                    }
                }
              
                  
            },
            removeTag(tag) {
                this.form.user_tags.splice(this.form.user_tags.indexOf(tag), 1);
                
            },
            submit() {
                //console.log(this.form.user_tags);
                this.$inertia.post('/addtags', this.form.user_tags);
            }
        }
    }

</script>
