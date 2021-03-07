<template>
    <app-layout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Dashboard
            </h2>
        </template> -->

        <div class="py-6 px-6">
            <div class="max-w-full mx-auto">
                <div class="grid gap-4 grid-cols-8 h-auto">

                    <span class="bg-white col-span-2 shadow">
                         <stats/>
                    </span>

                    <span class="bg-white col-span-4 shadow">
                        <active-jobs :activeReports="activeReports"/>
                    </span>

                    <span class="bg-white col-span-2 shadow">
                        <awards/>
                    </span>

                </div>
            </div>
        </div>
    </app-layout>
</template>


<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Stats from '@/Pages/Dashboard/Stats'
    import ActiveJobs from '@/Pages/Dashboard/ActiveJobs'
    import Awards from '@/Pages/Dashboard/Awards'

    export default {
        props: ['activeReports'],

        components: {
            AppLayout,
            Welcome,
            Stats,
            ActiveJobs,
            Awards
        },
    }
</script>
