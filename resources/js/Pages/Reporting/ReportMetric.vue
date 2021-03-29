<template>
  <div class="m-5 md:w-2/5">
    <label :for="inputId" class="block my-3 font-bold">{{ title }}</label>
    <div class="">
      <div>
        <span>{{ name + ': ' + metricValue }}</span>
      </div>
      <input type="range" min="1" max="5" v-model="metricValue" class="" :id="inputId">
    </div>
  </div>
</template>

<script>
export default {
  name: "ReportMetric",
  props: {
    index: Number,
    name: String,
    title: String,
    extra: String,
    min: Number,
    max: Number,
    type: String,
  },
  emits: [
    'set-report-metric',
  ],
  data() {
    return {
      metricValue: this.min,
    }
  },
  computed: {
    inputId: name + '-input'
  },
  watch: {
    metricValue(newValue, oldValue) {
      this.$emit('set-report-metric', { name: this.name, value: newValue })
    }
  },
  mounted() {
    this.$emit('set-report-metric', { index: this.index, name: this.name, value: this.metricValue, type: this.type })
  }
}
</script>

<style scoped>

</style>