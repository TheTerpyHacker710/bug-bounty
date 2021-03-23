<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Verify a Vulnerability Report
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-3 mt-12 mb-5">
            <div class="flex flex-row min-h-screen" v-if="currentReport >= 0">
              <div class="w-1/3 m-2">
                <verification-list :assignments="assignments" :current-report="currentReport"
                                   @select-report="selectReport"></verification-list>
              </div>

              <!-- Verification form -->
              <div class="w-2/3 m-2">
                <div>
                  <h3 class="text-lg font-bold mb-3">First, follow the steps below to see if you can reproduce this
                    vulnerability report:</h3>
                  <div v-for="(step, index) in currentProcedure" class="">
                    <h2 class="text-lg mb-2 mt-3">Step {{ index + 1 }}</h2>
                    <div :id="'step-' + index + '-text'" class="markdown border p-2"
                         v-html="currentProcedure[index]"></div>
                  </div>
                  <div class="mt-3" v-if="currentStatus == 'pending'">
                    <form @submit.prevent="submitVerification">
                      <!--  Verifiable?    -->
                      <label for="verifiable" class="my-3 text-lg font-bold">Were you able to successfully verify this
                        vulnerability report?</label>
                      <input type="checkbox" v-model="form.verifiable" id="verifiable" class="mx-3">

                      <div v-if="form.verifiable" class="mt-3">
                        <!--  Vulnerability Scoring    -->
                        <span class="block mb-1 text-lg font-bold">
                          Great! Use the sliders below to indicate your assessment of some
                          of the high-level characteristics of this vulnerability:
                        </span>
                        <div class="flex flex-wrap">
                          <report-metric v-for="metric in vulnerabilityMetrics" :name="metric.name"
                                         :title="metric.title" :extra="metric.extra"
                                         :min="metric.min" :max="metric.max" type="vulnerability"
                                         @set-report-metric="setVulnerabilityMetric"></report-metric>
                        </div>
                      </div>
                      <!--  Procedure scoring -->
                      <div class="mt-3">
                        <span class="block mb-1 text-lg font-bold">Finally, rate the following aspects of the report itself:</span>
                        <div class="flex flex-wrap">
                          <report-metric v-for="metric in procedureMetrics" :name="metric.name" :title="metric.title"
                                         :extra="metric.extra"
                                         :min="metric.min" :max="metric.max" type="vulnerability"
                                         @set-report-metric="setProcedureMetric"></report-metric>
                        </div>
                      </div>
                      <div class="">
                        <span class="block my-3 font-bold text-lg">Once you're ready, click here to submit your verification!</span>
                        <Button type="submit">
                          Submit
                        </Button>
                      </div>
                      <div>
                        <span class="block my-3">If verifying this report is beyond your skill set, you can also click below to cancel this assignment:</span>
                        <SecondaryButton type="button" @click="cancelAssignment">
                          Cancel Assignment
                        </SecondaryButton>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div v-else class="text-center">
              <span class="text-lg font-bold">Nothing to verify at the moment! Try checking back later...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import DOMPurify from "dompurify"
import marked from "marked"

import AppLayout from '@/Layouts/AppLayout'
import VerificationList from "./VerificationList"
import ReportMetric from "./ReportMetric";
import Button from "../../Jetstream/Button";
import SecondaryButton from "../../Jetstream/SecondaryButton";

export default {
  components: {
    SecondaryButton,
    Button,
    ReportMetric,
    VerificationList,
    AppLayout,
  },
  props: {
    assignments: Array,
    selectedAssignment: Number,
    vulnerabilityMetrics: Array,
    procedureMetrics: Array,
  },
  data() {
    return {
      currentReport: this.findAssignment(this.selectedAssignment),
      form: {
        assignmentId: this.assignments.length > 0 ? this.assignments[0]["id"] : -1,
        verifiable: false,
        vulnerabilityMetrics: {},
        procedureMetrics: {},
      }
    }
  },
  computed: {
    currentProcedure: function () {
      return JSON.parse(this.assignments[this.currentReport]["verification_batch"]["report"]["procedure"]).map(this.compileMarkdown)
    },
    currentStatus: function () {
      return this.assignments[this.currentReport]["status"];
    }
  },
  methods: {
    selectReport: function (event) {
      this.currentReport = event
      this.form.assignmentId = this.assignments[this.currentReport]["id"]
      console.log(this.form.assignmentId)
    },
    compileMarkdown: function (input) {
      return DOMPurify.sanitize(marked(input, {}))
    },
    setVulnerabilityMetric(e) {
      this.form.vulnerabilityMetrics[e.name] = e.value
    },
    setProcedureMetric(e) {
      this.form.procedureMetrics[e.name] = e.value
    },
    submitVerification: function () {
      console.log(JSON.stringify(this.form))
      this.$inertia.post('/verify', this.form)
    },
    initVulnerabilityMetrics: function () {
      this.vulnerabilityMetrics.forEach((metric, i, a) => {
        console.log(metric.name, metric.min)
        this.form.vulnerabilityMetrics[metric.name] = metric.min
      })
      console.log(this.form.vulnerabilityMetrics)
    },
    cancelAssignment() {
      let data = { id: this.assignments[this.currentReport]['id'] }
      this.$inertia.post('/cancelVerification', data)
    },
    findAssignment: function(id) {
      console.log(id);
      if (this.assignments.length > 0)
        if (id != null) {
          // find report
          let index = this.assignments.findIndex(assignment => {
            return assignment["id"] == this.selectedAssignment
          });
          if (index >= 0) {
            return index;
          } else {
            return 0
          }
        } else {
          return 0
        }
      return -1;
    },
  },
  mounted() {
    this.initVulnerabilityMetrics()
  }
}
</script>

<style scoped>

</style>