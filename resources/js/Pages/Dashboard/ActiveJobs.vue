<template>
    <div class="text-center px-4 py-4">
        <h2>Active Jobs</h2>
    </div>

    <div class="grid grid-cols-2 gap-4 px-1 py-1 h-auto">
        <span class="px-4 py-4 border-4 ">
                <h2 class="text-center py-2">Reports to Verify</h2>
        </span>

        <span class="px-4 py-4 border-4">
                <h2 class="text-center py-2">Reports</h2>
                <ul>
                    <div :key="report.program.id" v-for="report in activeReports" class="py-2">
                        <div class="px-2 py-4 border-2">
                            <li>{{report.program.Title}}:</li>
                            <li class="py-2">{{report.program.Excerpt}}</li>
                            <!--<li class="py-2"><button type="button" class="focus:outline-none text-white text-sm py-1 px-2.5 rounded-md bg-gray-700 hover:bg-gray-900 hover:shadow-lg">View</button></li>-->
                            <li class="py-2"><inertia-link href="/Report" as="button" type="button" class="focus:outline-none text-white text-sm py-1 px-2.5 rounded-md bg-gray-700 hover:bg-gray-900 hover:shadow-lg">View</inertia-link></li>
                        </div>
                        
                    </div>
                </ul>
        </span>
    </div>
    
</template>

<script>

export default {
    name: 'Active Jobs',
    props: ['activeReports'],
}

</script>