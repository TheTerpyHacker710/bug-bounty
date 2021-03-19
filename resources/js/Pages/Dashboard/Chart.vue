<template>
    <h2 class="text-center text-xl">Activity</h2>
    <apexchart :width="chart.width" :height="chart.height" :type="chart.type" :options="chart.options" :series="chart.series"></apexchart>
</template>

<script>
export default {
    props: ['chart'],
}
</script>