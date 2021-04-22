<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                    <div class="col-span-6 sm:col-span-4">

                        <h1 class="text-lg font-mediumtext-gray-900">
                            Your Programs
                        </h1>
                    </div>

                    <div>
                        <div v-if="programs.length == 0" class="mt-10 text-sm text-gray-600">
                            It looks like you don't have any programs. Why not create one now!
                        </div>
                        <div v-else-if="programs">
                            <div v-for="program in programs">
                                <jet-section-border />
                                <div class="flex justify-between">
                                    <div class="inline-block mt-4 font-bold">
                                        {{program.Title}}
                                    </div>
                                    <button class="inline-block ml-10 mt-4 w-auto p-1 border-2 rounded border-red-600 bg-red-600 text-white hover:bg-red-700" @click="remove(program)">Delete</button>
                                </div>
                                <div class="mt-5">

                                    <div class="mt-10 w-1/2">
                                        <jet-label for="title">Program Title<span class="text-red-600"> *</span></jet-label>
                                        <jet-input id="title" type="text" class="mt-1 block w-full" v-model="program.Title">
                                            {{program.Title}}
                                        </jet-input>
                                    </div>

                                    <div class="mt-10 w-1/2">
                                        <jet-label>Do you want to manually approve reports before they can be verified?<span class="text-red-600"> *</span></jet-label>
                                        <div class="mt-2">
                                            <label class="inline-flex items-center">
                                                <jet-input id="vendorApproveTrue" value="1" name="vendorApprove" type="radio" v-model="program.vendorApprove"></jet-input>
                                                <span class="ml-2">Yes</span>
                                            </label>
                                            <label class="inline-flex items-center ml-6">
                                                <jet-input id="vendorApproveFalse" value="0" name="vendorApprove" type="radio" v-model="program.vendorApprove"></jet-input>
                                                <span class="ml-2">No</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mt-8 w-1/2">
                                        <jet-label for="description">Description<span class="text-red-600"> *</span></jet-label>
                                        <textarea class="w-full h-48" v-model="program.Description">
                                            {{program.Description}}
                                        </textarea>
                                    </div>

                                    <button @click="update(program)" class="focus:outline-none text-white py-1 px-2.5 rounded-md bg-gray-700 hover:bg-gray-900 hover:shadow-lg mt-6">Update</button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

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
                deleteForm: this.$inertia.form({
                    id: '',

                }),

                updateForm: this.$inertia.form({
                    id: '',
                    title: '',
                    descr: '',
                    vendorApprove: '',
                }),
            }
        },

        props: {

            programs: Array,
        },

        methods: {

            remove(program) {

                this.deleteForm.id = program.id;
                this.deleteForm.post('/program-delete');

            },

            update(program) {
                this.updateForm.id = program.id;
                this.updateForm.title = program.Title;
                this.updateForm.descr = program.Description;
                this.updateForm.vendorApprove = program.vendorApprove;
                this.updateForm.post('program-update');
            }

        }

    }
</script>

