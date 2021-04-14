<template>
    <div class="text-center px-4 py-4">
        <h2>Active Jobs</h2>
    </div>

<!--    Vue component to read in reports and verifications-->
    <div class="grid grid-cols-2 gap-4 px-1 py-1 h-auto">
        <span class="px-4 py-4 border-4 ">
                <h2 class="text-center py-2">Reports to Verify</h2>
                <ul v-if="activeVerifications.length > 0">
                    <div v-for="verification in activeVerifications" :key="verification.id" class="py-2">
                        <active-verifications :verification="verification" />
                    </div>
                </ul>

                <ul v-else>
                    <li class="text-center py-4 italic font-thin">No Active Verifications</li>
                </ul>
        </span>

        <span class="px-4 py-4 border-4">
                <h2 class="text-center py-2">Active Reports</h2>
                <ul v-if="activeReports.length > 0">
                    <div :key="report.id" v-for="report in activeReports" class="py-2">
                        <active-report :report="report"/>
                    </div>
                </ul>

                <ul v-else>
                    <li class="text-center py-4 italic font-thin">No Active Reports</li>
                </ul>
        </span>
    </div>
</template>

<script>

import ActiveReport from '../Dashboard/ActiveReport.vue'
import ActiveVerifications from '../Dashboard/ActiveVerifications.vue'

export default {
    props: ['activeReports', 'activeVerifications'],

    components: {
        ActiveReport,
        ActiveVerifications
    },
}

</script>
