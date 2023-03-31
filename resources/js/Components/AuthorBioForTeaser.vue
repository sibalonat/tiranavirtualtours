<script setup>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { reactive, ref } from 'vue';

// props and emits
const emit = defineEmits(['update:author_al', 'update:author_en']);
const textArea = defineProps({
    author_en: String,
    author_al: String,
    teaser_en: String,
    teaser_al: String,
})

// properties
const optionsAl = reactive({
    modules: {
        toolbar: ['bold', 'italic', 'underline']
    },
    placeholder: 'Write author bio...',
    readOnly: false,
    scrollingContainer: 'html',
    theme: 'snow'
})

const optionsEn = reactive({
    modules: {
        toolbar: ['bold', 'italic', 'underline']
    },
    placeholder: 'Write author bio...',
    readOnly: false,
    scrollingContainer: 'html',
    theme: 'snow'
})

const editorAl = ref(null)
const editorEn = ref(null)

// methods
const changedContentAl = (evt) => {
    emit('update:author_al', JSON.stringify(evt))
}

const changedContentEn = (evt) => {
    emit('update:author_en', JSON.stringify(evt))
}

// hooks

</script>
<template>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Author-Bio En
        </label>
        <QuillEditor
        ref="editorEn"
        :options="optionsEn"
        @update:content="changedContentEn($event)"
        @focus="optionsEn.placeholder = ''" />
    </div>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Author-Bio Al
        </label>
        <QuillEditor
        ref="editorAl"
        :options="optionsAl"
        @update:content="changedContentAl($event)"
        @focus="optionsAl.placeholder = ''" />
    </div>
</template>

<style>
.ql-container {
    height: 170px !important;
    max-height: 170px;
}
</style>
