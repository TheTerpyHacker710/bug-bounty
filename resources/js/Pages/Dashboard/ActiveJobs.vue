<template>
    <div class="text-center px-4 py-4">
        <h2>Active Jobs</h2>
    </div>

    <div class="grid grid-cols-2 gap-4 px-1 py-1 h-auto">
        <span class="px-4 py-4 border-4 ">
                <h2 class="text-center py-2">Reports to Verify</h2>
        </span>

        <span class="px-4 py-4 border-4">
                <h2 class="text-center py-2">Active Reports</h2>
                <ul v-if="activeReports.length > 0">
                    <div :key="report.program.id" v-for="report in activeReports" class="py-2">
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

import ActiveReport from './ActiveReport.vue'

export default {
    name: 'Active Jobs',
    props: ['activeReports'],
    components: {
        ActiveReport
    },
}

</script>