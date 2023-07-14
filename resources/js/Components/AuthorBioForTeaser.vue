<script setup>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { onMounted, reactive, ref } from 'vue';

// props and emits
const emit = defineEmits(['update:author_al', 'update:author_en']);
const textArea = defineProps({
    author_en: String,
    author_al: String,
    teaser_en: String,
    teaser_al: String,
    condition: Number,
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


// const loadEn = (evt) => {
//     // console.log(evt);
//     if (textArea.author_en) {
//         evt.setContents(JSON.parse(textArea.author_en))
//         // evt.editor.delta = textArea.author_en
//     }
// }
// const loadAl = (evt) => {
//     // console.log(evt);
//     if (textArea.author_al) {
//         evt.setContents(JSON.parse(textArea.author_al))
//         // evt.editor.delta = textArea.author_al
//     }
// }

// hooks

onMounted(() => {
    // if (condition) {

    // }
    editorAl.value.getQuill().setContents(JSON.parse(textArea.author_al))
    editorEn.value.getQuill().setContents(JSON.parse(textArea.author_en))
})

</script>
<template>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Author-Bio En
        </label>
        <!-- author_en -->
        <QuillEditor
        ref="editorEn"
        :options="optionsEn"
        @update:content="changedContentEn($event)"
        @focus="optionsEn.placeholder = ''" />
        <!-- @ready="loadEn($event)" -->
    </div>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Author-Bio Al
        </label>
        <!-- @ready="loadAl($event)" -->
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
