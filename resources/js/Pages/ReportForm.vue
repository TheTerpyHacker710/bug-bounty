<template>
  <!-- Form only fills 3/4 of the main panel on medium devices and larger -->
  <div class="md:w-3/4 mx-auto my-5">
    <form @submit.prevent="submitReport">
      <!-- Program selection -->
      <div class="mb-3">
        <label for="program_id" class="block my-3 text-lg font-bold">Select program:</label>
        <select id="program_id" name="program_id" class="w-full" v-model="staticFormComponents.program_id">
          <option value="1">Program 1</option>
          <option value="2">Program 2</option>
          <option value="3">Program 3</option>
        </select>
      </div>
      <!-- Procedure details    -->
      <div id="procedure_details" class="my-3">
        <label for="procedure_details" class="block my-3 text-lg font-bold">Please detail the steps you took:</label>
        <div v-for="(step, i) in procedure.steps">
          <report-step :step-number="i" :id="step.id" :content="step.content" :key="step.id"
                       @remove-step="removeStep" @update-step="updateStep"></report-step>
        </div>
        <button type="button" @click="addStep"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
          Add step
        </button>
      </div>
      <!--  Severity score    -->
      <label for="severity-slider" class="block my-3 text-lg font-bold">Please indicate the severity of this vulnerability:</label>
      <div class="">
        <div>
          <span>Severity: {{staticFormComponents.severity}}</span>
        </div>
        <input type="range" min="1" max="5" v-model="staticFormComponents.severity" class="" id="severity-slider">
      </div>
      <!--  Complexity score   -->
      <label for="complexity-slider" class="block my-3 text-lg font-bold">Please indicate the complexity of this vulnerability:</label>
      <div class="">
        <div>
          <span>Complexity: {{staticFormComponents.complexity}}</span>
        </div>
        <input type="range" min="1" max="5" v-model="staticFormComponents.complexity" class="" id="complexity-slider">
      </div>
      <!--  Reliability score   -->
      <label for="reliability-slider" class="block my-3 text-lg font-bold">Please indicate the reliability of this vulnerability:</label>
      <div class="">
        <div>
          <span>Reliability: {{staticFormComponents.reliability}}</span>
        </div>
        <input type="range" min="1" max="5" v-model="staticFormComponents.reliability" class="" id="reliability-slider">
      </div>
      <div class="text-center">
        <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
          Submit Report
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import ReportStep from "./ReportStep";

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
  components: {ReportStep},
  data() {
    return {
      procedure: new Procedure(1),
      staticFormComponents: {
        program_id: 1,
        severity: 3,
        complexity: 3,
        reliability: 3,
      }
    }
  },
  computed: {
    form: function() {
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
      console.log(this.form)
      this.$inertia.post(route('storeReport'), this.form)
    }
  }
}
</script>

<style scoped>

</style>