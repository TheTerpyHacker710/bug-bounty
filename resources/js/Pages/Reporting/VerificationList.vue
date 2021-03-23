<template>
  <div>
    <div v-for="(assignment, index) in assignments" :key="assignment['id']">
      <div class="m-1 px-2 py-4 rounded-lg" :class="getItemClasses(index)">
        <a @click="selectReport(index)" class="block text-lg cursor-pointer" :class="getLabelClasses(index)"><div class="break-words">{{ assignment["verification_batch"]["report"]["title"] }}</div></a>
        <span class="capitalize">{{ assignment["status"] }}</span>
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
    },
  },
  mounted() {
    console.log(this.assignments[0])
  }
}
</script>

<style scoped>

</style>