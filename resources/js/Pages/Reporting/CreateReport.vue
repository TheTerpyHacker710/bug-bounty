<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Submit a Vulnerability Report
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-3">
            <report-form :programs="programs" :report-metrics="reportMetrics" :tip="tip"></report-form>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import ReportForm from '@/Pages/Reporting/ReportForm'

export default {
  components: {
    AppLayout,
    ReportForm,
  },
  props: {
    reportMetrics: Array,
    programs: Array,
    tip: String,
  },
  mounted() {

  }
}
</script>
