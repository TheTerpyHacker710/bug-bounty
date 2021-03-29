<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Vendor Dashboard
            </h2>
        </template>

        <add-form/>

        <delete-form :programs="$page.props.programs"/>

</app-layout>
</template>

<script>import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import AddForm from './Vendor/AddForm'
    import DeleteForm from './Vendor/DeleteForm'

    export default {

        components: {
            AppLayout,
            Welcome,
            AddForm,
            DeleteForm,

        },

    
    }
</script>
