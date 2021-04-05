<template>
    <div class="px-2 py-4 border-2 rounded-lg shadow">
        <li>{{verification.verification_batch.report.program.Title}}</li> 
        <li class="py-2">{{verification.verification_batch.report.program.Excerpt}}</li>
        <!-- ADD FUNCTIONALITY TO ALLOW USER TO OPEN SPECIFIC VERIFICATION ON /verify -->
        <li class="py-2 px-2 text-right"><inertia-link :href="'/verify?assignment=' + verification.id" as="button" type="button" class="focus:outline-none text-white text-sm py-1 px-2.5 rounded-md bg-gray-700 hover:bg-gray-900 hover:shadow-lg">View Report</inertia-link></li>
   </div>
</template>

<script>
export default {
    props: ['verification'],
}
</script>