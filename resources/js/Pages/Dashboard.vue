<template>
    <app-layout>
        <template #header>
                <div class = "flex justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        User Dashboard
                    </h2>
                    <h2 class="font-semibold text-gray-800 leading-tight">
                        <b>Reputation: </b> {{userInfo.reputation}}
                    </h2>
                </div>
        </template>

        <div class="py-6 px-6">
            <div class="max-w-full mx-auto">
                <div class="grid gap-4 grid-cols-1 md:grid-cols-8 h-full">

                    <span class="bg-white col-span-1 md:col-span-2 shadow-xl rounded-lg h-full">
                         <stats :chart="chart" :leaderboard="leaderboard"/>
                    </span>

                    <span class="bg-white col-span-1 md:col-span-4 shadow-xl rounded-lg h-full">
                        <active-jobs :activeReports="activeReports" :activeVerifications="activeVerifications"/>
                    </span>

                    <span class="bg-white col-span-1 md:col-span-2 shadow-xl rounded-lg h-full">
                        <awards :userInfo="userInfo" :userBadges="userBadges"/>
                    </span>

                </div>
            </div>
        </div>
    </app-layout>
</template>


<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Stats from '@/Pages/Dashboard/Stats'
    import ActiveJobs from '@/Pages/Dashboard/ActiveJobs'
    import Awards from '@/Pages/Dashboard/Awards'

    export default {
        props: ['userInfo', 'activeReports', 'activeVerifications', 'leaderboard', 'chart', 'userBadges'],

        components: {
            AppLayout,
            Stats,
            ActiveJobs,
            Awards
        },
    }
</script>
