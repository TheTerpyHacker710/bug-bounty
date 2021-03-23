<template>
  <!-- Form only fills 3/4 of the main panel on medium devices and larger -->
  <div class="md:w-3/4 mx-auto mt-12 mb-5">
    <form @submit.prevent="submitReport">
      <!-- Program selection -->
      <div class="mb-3">
        <label for="program_id" class="block mt-3 mb-1 text-lg font-bold">First, select which program your report
          applies to:</label>
        <span class="block mb-3">Be sure to double-check this is set correctly so your report is delivered to the correct vendor!</span>
        <select id="program_id" name="program_id" class="w-full" v-model="staticFormComponents.program_id">
          <option v-for="program in programs" :value="program.id">{{ program.Title }}</option>
        </select>
      </div>

      <!-- Title -->
      <div class="mb-3">
        <label for="title" class="block mt-3 mb-1 text-lg font-bold">Give your report a short title:</label>
        <input type="text" maxlength="100" class="w-full" id="title" v-model="staticFormComponents.title">
      </div>

      <!-- Procedure details    -->
      <div id="procedure_details" class="my-8">
        <label for="procedure_details" class="block mt-3 mb-1 text-lg font-bold">Please detail the steps required to
          exploit this vulnerability:</label>
        <span class="block mb-1">Include enough information so that other users can reproduce your work, and split your procedure into manageable steps</span>
        <span class="block mb-3"></span>
        <div v-for="(step, i) in procedure.steps">
          <report-step :step-number="i" :id="step.id" :content="step.content" :key="step.id"
                       @remove-step="removeStep" @update-step="updateStep"></report-step>
        </div>
        <Button type="button" class="mt-1" @click="addStep">
          Add step
        </Button>
      </div>

      <!--  Scoring    -->
      <span class="block mb-1 text-lg font-bold">Use the sliders below to indicate some of the high-level characteristics of this vulnerability:</span>
      <span class="block mb-3">It's important to be accurate here, since the users verifying your report will also be assessing these characteristics</span>
      <div class="flex flex-wrap">
        <report-metric v-for="metric in reportMetrics" :name="metric.name" :title="metric.title" :extra="metric.extra"
                       :min="metric.min" :max="metric.max" type="vulnerability" @set-report-metric="setReportMetric"></report-metric>
      </div>

      <!-- Submit button -->
      <div class="">
        <span class="block my-3 font-bold text-lg">Once you're ready, click here to submit your report!</span>
        <Button id="report-submit" type="submit">
          Submit Report
        </Button>
      </div>
    </form>
  </div>
</template>

<script>
import ReportStep from "./ReportStep";
import Button from "../../Jetstream/Button";
import Prism from 'prismjs'
import 'prismjs/themes/prism.css'
import 'prismjs/components/prism-bash'
import ReportMetric from "./ReportMetric";

class Step {
  constructor(id, content) {
    this.id = id
    this.content = content
  }
}

class Procedure {
  constructor(num) {
    this.nextId = 0
    this.steps = []
    for (let i = 0; i < num; i++) {
      this.steps.push(new Step(this.getNextId(), ""))
    }
  }

  getNextId() {
    this.nextId++
    return this.nextId
  }

  getStepById(id) {
    return this.steps.findIndex(i => i.id == id)
  }

  addStep(content) {
    this.steps.push(new Step(this.getNextId(), content))
  }

  updateStep(id, content) {
    let index = this.getStepById(id)
    this.steps[index].content = content
  }

  removeStep(id) {
    let index = this.getStepById(id)
    this.steps.splice(index, 1)
  }
}

export default {
  name: "ReportForm",
  components: {ReportMetric, Button, ReportStep},
  props: {
    reportMetrics: Array,
    programs: Array,
  },
  data() {
    return {
      procedure: new Procedure(1),
      staticFormComponents: {
        title: "",
        program_id: 0,
        metrics: {},
      }
    }
  },
  computed: {
    form: function () {
      let f = this.staticFormComponents
      f.procedure = this.procedure.steps.map(o => o.content)
      return f
    },
  },
  methods: {
    addStep() {
      this.procedure.addStep("")
    },
    updateStep(e) {
      this.procedure.updateStep(e.id, e.content)
    },
    removeStep(e) {
      this.procedure.removeStep(e.id)
    },
    getNextId() {
      this.nextId++
      return this.nextId
    },
    submitReport() {
      console.log(JSON.stringify(this.form))
      this.$inertia.post(route('storeReport'), this.form)
    },
    setReportMetric(e) {
      this.staticFormComponents.metrics[e.name] = e.value
    }
  },
}
</script>

<style scoped>

</style>