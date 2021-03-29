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
                                    <div class="inline-block mt-4">
                                        {{program.Title}}
                                    </div>
                                    <button class="inline-block ml-10 mt-4 w-auto p-1 border-2 rounded border-red-600 bg-red-600 text-white hover:bg-red-700" @click="remove(program)">Delete</button>
                                </div>
                                <div class="mt-5">
                                    {{program.Description}}
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
                form: this.$inertia.form({
                    id: '',

                }),
            }
        },

        props: {

            programs: Array,
        },

        methods: {

            remove(program) {

                this.form.id = program.id
                this.form.post('/program-delete');

            },

        }

    }
</script>
