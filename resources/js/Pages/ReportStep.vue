<template>
  <div class="mb-3">
    <div>
      <label :for="textAreaId" class="">Step {{ stepNumber + 1 }}</label>
      <button type="button" class="float-right inline-block" @click="removeStep">Remove Step</button>
    </div>
    <div class="md:hidden">
      <button type="button" @click="toggleShowCompiled">Toggle</button>
    </div>
    <div class="flex flex-col space-y-2 md:flex-row md:space-x-2 md:space-y-0">
      <textarea rows=4 :id="textAreaId" :value="markdownInput" class="md:w-1/2" :class="editorViewClasses" @input="updateMarkdown"></textarea>
      <div class="md:w-1/2 overflow-auto border p-2" :class="compiledViewClasses" v-html="compiledMarkdown"></div>
    </div>
  </div>
</template>

<script>
import DOMPurify from "dompurify";
import marked from "marked";

export default {
  name: "ReportStep",
  props: {
    id: Number,
    stepNumber: Number,
    content: String,
  },
  data() {
    return {
      showCompiled: false,
      markdownInput: this.content,
      compiledMarkdown: "",
    }
  },
  emits: [
    'update-step'
  ],
  computed: {
    textAreaId: function() {
      return "step_id_" + this.id.toString()
    },
    editorViewClasses: function() {
      return {
        hidden: this.showCompiled,
        'md:block': this.showCompiled,
      }
    },
    compiledViewClasses: function() {
      return {
        hidden: !this.showCompiled,
        'md:block': !this.showCompiled,
      }
    },
  },
  watch: {
    markdownInput: function(val) {
      this.compileMarkdown()
      this.$emit('update-step', {id: this.id, content: val})
    }
  },
  methods: {
    removeStep() {
      this.$emit('remove-step', {id: this.id})
    },
    toggleShowCompiled() {
      this.showCompiled = !this.showCompiled
    },
    updateMarkdown: _.debounce(function(e) {
      this.markdownInput = e.target.value
    }, 300),
    compileMarkdown() {
      this.compiledMarkdown = DOMPurify.sanitize(marked(this.markdownInput, {}))
    }
  },
  created() {
    this.compileMarkdown()
  }
}
</script>

<style scoped>

</style>