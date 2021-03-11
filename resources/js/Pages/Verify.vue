<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Verify a Report
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-3">
            <div class="flex flex-row">
              <div class="w-1/3 m-2">
                <VerificationList :assignments="assignments" :current-report="currentReport" @select-report="selectReport"></VerificationList>
              </div>
              <div class="w-2/3 m-2">
                <div v-if="currentReport >= 0">
                  <div v-for="(step, index) in currentProcedure" class="m-1 px-2 py-4 border">
                    <h2 class="font-bold text-lg">Step {{ index + 1 }}</h2>
                    <div :id="'step-' + index + '-text'" v-html="currentProcedure[index]"></div>
                  </div>
                  <div class="m-1 p-2 border" v-if="currentStatus == 'pending'">
                    <form @submit.prevent="submitVerification">
                      <!--  Verifiable?    -->
                      <label for="verifiable" class="my-3 text-lg font-bold">Please indicate whether you were able
                        to verify this report:</label>
                      <input type="checkbox" v-model="form.verifiable" id="verifiable" class="mx-3">
                      <!--  Quality score    -->
                      <label for="quality-score" class="block my-3 text-lg font-bold">Please indicate the overall quality
                        of this report:</label>
                      <div class="">
                        <div>
                          <span>Quality: {{ form.quality }}</span>
                        </div>
                        <input type="range" min="1" max="5" v-model="form.quality" class="" id="quality-score">
                      </div>
                      <!--  Detail score   -->
                      <label for="detail-score" class="block my-3 text-lg font-bold">Please indicate how detailed this report is:</label>
                      <div class="">
                        <div>
                          <span>Detail: {{ form.detail }}</span>
                        </div>
                        <input type="range" min="1" max="5" v-model="form.detail" class=""
                               id="detail-score">
                      </div>
                      <div v-if="form.verifiable">
                        <!--  Severity score    -->
                        <label for="severity-score" class="block my-3 text-lg font-bold">Please indicate the severity
                          of this vulnerability:</label>
                        <div class="">
                          <div>
                            <span>Severity: {{ form.severity }}</span>
                          </div>
                          <input type="range" min="1" max="5" v-model="form.severity" class="" id="severity-score">
                        </div>
                        <!--  Complexity score   -->
                        <label for="complexity-score" class="block my-3 text-lg font-bold">Please indicate the complexity
                          of this vulnerability:</label>
                        <div class="">
                          <div>
                            <span>Complexity: {{ form.complexity }}</span>
                          </div>
                          <input type="range" min="1" max="5" v-model="form.complexity" class=""
                                 id="complexity-score">
                        </div>
                        <!--  Reliability score   -->
                        <label for="reliability-score" class="block my-3 text-lg font-bold">Please indicate the
                          reliability of this vulnerability:</label>
                        <div class="">
                          <div>
                            <span>Reliability: {{ form.reliability }}</span>
                          </div>
                          <input type="range" min="1" max="5" v-model="form.reliability" class=""
                                 id="reliability-score">
                        </div>
                      </div>
                      <div class="text-center">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                          Submit
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
                <div v-else>
                  Nothing to verify!
                </div>
              </div>
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

export default {
  components: {
    VerificationList,
    AppLayout,
  },
  props: {
    assignments: Array,
  },
  data() {
    return {
      currentReport: this.assignments.length > 0 ? 0 : -1,
      form: {
        assignmentId: this.assignments.length > 0 ? this.assignments[0]["id"] : -1,
        verifiable: false,
        quality: 3,
        detail: 3,
        severity: 3,
        complexity: 3,
        reliability: 3,
      }
    }
  },
  computed: {
    currentProcedure: function () {
      return JSON.parse(this.assignments[this.currentReport]["verification_batch"]["report"]["procedure"]).map(this.compileMarkdown)
    },
    currentStatus: function() {
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
    submitVerification: function () {
      this.$inertia.post('/verify', this.form)
    }
  }
}
</script>

<style scoped>

</style>