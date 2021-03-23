<template>
  <div class="mb-3">
    <div class="flex items-baseline">
      <label :for="textAreaId" class="inline-flex text-lg mr-2">Step {{ stepNumber + 1 }}</label>
      <Button class="xl:hidden my-1 mx-1" type="button" @click="toggleShowCompiled">Toggle Preview</Button>
      <SecondaryButton type="button" class="inline-flex my-1 mx-1" @click="removeStep">Remove Step</SecondaryButton>
    </div>
    <div class="flex flex-col space-y-2 xl:flex-row xl:space-x-2 xl:space-y-0">
      <textarea rows=4 :id="textAreaId" :value="markdownInput" class="xl:w-1/2" :class="editorViewClasses" @input="updateMarkdown"></textarea>
      <div class="markdown xl:w-1/2 overflow-auto border p-2" :class="compiledViewClasses" v-html="compiledMarkdown"></div>
    </div>
  </div>
</template>

<script>
import DOMPurify from "dompurify";
import marked from "marked";
import Button from "../../Jetstream/Button";
import SecondaryButton from "../../Jetstream/SecondaryButton";

export default {
  name: "ReportStep",
  components: {Button, SecondaryButton},
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
        'xl:block': this.showCompiled,
      }
    },
    compiledViewClasses: function() {
      return {
        hidden: !this.showCompiled,
        'xl:block': !this.showCompiled,
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