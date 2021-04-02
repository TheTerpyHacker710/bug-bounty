<template>
    <jet-form-section>
        <template #title>
            Vendor Application
        </template>

        <template #description>
            Apply to become a vendor
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <h1 class="text-lg font-medium text-gray-900">Becoming a vendor</h1>
                <div class="max-w-xl text-sm text-gray-600 mt-2">
                    If you want to create bug bounty programs on behalf of an organisation, or for your own projects then please send an application by clicking the button below.
                </div>
                <button class="mt-5 p-1 border-2 rounded border-green-600 bg-green-600 text-white" @click.native="vendorApply">Apply to be vendor</button>
            </div>

            <jet-dialog-modal :show="vendorShowModal" @close="vendorShowModal = false">

                <template #content>

                    <div>
                        <p>
                            Are you sure you want to apply to become a vendor? The organisation name used for your programs will be your current organisation name
                            (See Profile Information).
                        </p>
                        <p class="mt-5 font-bold">If the organisation name is empty, your name will be used for your programs.</p>
                    </div>

                </template>

                <template #footer>
                    <jet-secondary-button @click.native="closeModal">
                        Wait, go back
                    </jet-secondary-button>

                    <jet-button class="ml-2" @click="sendApplication">
                        Submit
                    </jet-button>
                </template>
            </jet-dialog-modal>

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
    import JetDialogModal from '@/Jetstream/DialogModal'

    export default {

        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetDialogModal,
        },

        data() {
            return {
                vendorShowModal: false,

            }
        },

        methods: {

            vendorApply() {

               this.vendorShowModal = true;
            },

            closeModal() {

                this.vendorShowModal = false;
            },

            sendApplication() {
                this.$inertia.get(route('vendorApply'));
            }

        }

    }
</script>
