<template>
  <div>
    <div v-for="(assignment, index) in assignments" :key="assignment['id']">
      <div class="m-1 px-2 py-4" :class="getItemClasses(index)">
        <button @click="selectReport(index)" :class="getLabelClasses(index)">Verification {{ index + 1 }} - <span class="capitalize">{{ assignment["status"] }}</span></button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "VerificationList",
  props: {
    currentReport: Number,
    assignments: Array,
  },
  emits: [
    'select-report'
  ],
  computed: {
  },
  methods: {
    selectReport(index) {
      this.$emit("select-report", index)
    },
    getItemClasses(index) {
      return {
        'border': index != this.currentReport,
        'border-2': index == this.currentReport,
        'border-gray-300': index == this.currentReport,
      }
    },
    getLabelClasses(index) {
      return {
        'font-bold': index == this.currentReport,
      }
    }
  }
}
</script>

<style scoped>

</style>