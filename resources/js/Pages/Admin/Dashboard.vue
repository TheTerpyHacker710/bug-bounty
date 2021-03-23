<!--Page once navigated to /admin/dashboard -->
<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Dashboard
            </h2>
        </template>

        <div class="grid grid-cols-2 gap-4 px-1 py-1 h-auto text-center py-2">
            <h2>Active Reports</h2>

            <h2>Vendor Appeals</h2>
        </div>
    </admin-layout>
</template>

<script>
    import Welcome from '@/Jetstream/Welcome'
    import AdminLayout from "../../Layouts/AdminLayout";
    import ActiveJobs from "../Dashboard/ActiveJobs";

    export default {

        props: ['activeReports'],

        components: {
            AdminLayout,
            Welcome,
            ActiveJobs
        },
    }
</script>
