<template>
    <div class="py-12 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form @submit.prevent="submit" class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <div class="col-span-6 sm:col-span-4">

                        <h1 class="text-lg font-medium text-gray-900">
                            Create Program
                        </h1>
                        <div class="max-w-xl text-sm text-gray-600 mt-2 ">
                            Create a bug bounty program for users to test your web application. Please complete some details:
                        </div>
                    </div>

                    <div class="mt-10 w-1/2">
                        <jet-label for="title">Program Title<span class="text-red-600"> *</span></jet-label>
                        <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.Title" required />
                    </div>

                    <div class="mt-8 w-1/2">
                        <jet-label for="description">Description<span class="text-red-600"> *</span></jet-label>
                        <textarea class="w-full h-48" v-model="form.Description" placeholder="Please describe the program including the desired scope..." />
                    </div>

                    <div class="w-full ">
                        <button class="mt-8 w-auto p-1 border-2 rounded border-green-600 bg-green-600 text-white hover:bg-green-700" @click.native="submit">Create</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetSectionBorder from '@/Jetstream/SectionBorder'


    export default {

        components: {
            JetButton,
            JetInput,
            JetLabel,
            JetSectionBorder,
        },

        data() {
            return {
                form: this.$inertia.form({
                    Title: '',
                    Description: '',

                }),
            }
        },

        props: {

            programs: Array,
        },

        methods: {

            submit() {
                this.form.post('/vendor-program');

            },

        }

    }
</script>
