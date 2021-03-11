<template>
    <div class="px-2 py-4 border-2">
        <li>{{report.program.Title}}:</li>
        <li class="py-2">{{report.program.Excerpt}}</li>
        <li class="py-2"><inertia-link href="/Report" as="button" type="button" class="focus:outline-none text-white text-sm py-1 px-2.5 rounded-md bg-gray-700 hover:bg-gray-900 hover:shadow-lg">View</inertia-link></li>
    </div>
</template>

<script>
export default {
    props: ['report'],
}
</script>