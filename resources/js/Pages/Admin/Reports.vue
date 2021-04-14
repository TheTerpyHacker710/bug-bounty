<!--Page once navigated to /admin/reports-->

<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reports
            </h2>
        </template>

<!--        Read in all active reports and verifications for admin user to view-->
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <span class="bg-white col-span-4 shadow-xl">
                    <admin-active-jobs :activeReports="activeReports" :activeVerifications="activeVerifications"/>
                </span>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import Welcome from '@/Jetstream/Welcome'
import AdminLayout from "../../Layouts/AdminLayout";
import AdminActiveJobs from "../Admin/AdminActiveJobs";

export default {

    props: ['activeReports', 'activeVerifications'],

    components: {
        AdminLayout,
        Welcome,
        AdminActiveJobs
    },
}
</script>
