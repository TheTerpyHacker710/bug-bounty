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
                    <li v-for="report in reports">ID: {{report.id}}</li>
                </ul>
        </span>
    </div>
    
</template>

<script>

export default {
    name: 'Active Jobs',
    props: ['reports'],
}

</script>