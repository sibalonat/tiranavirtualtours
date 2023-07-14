<script setup>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { onBeforeMount, onMounted, reactive, ref, watchEffect, watch, onBeforeUpdate } from '@vue/runtime-core';

// const emit = defineEmits(['AlChange'])
// props and emits
const emit = defineEmits(['update:teaser_al', 'update:teaser_en']);
const textArea = defineProps({
    teaser_en: String,
    teaser_al: String,
    author_en: String,
    author_al: String,
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

const number = ref(false)


// methods
const changedContentAl = (evt) => {
    console.log(evt, 'en');
    emit('update:teaser_al', JSON.stringify(evt))
}

const changedContentEn = (evt) => {
    emit('update:teaser_en', JSON.stringify(evt))
}


onMounted(() => {
    setTimeout(() => {
        number.value = true
    }, 100)
})

watch([editorAl, editorEn], ([val]) => {
    if (number.value === true && val.getEditor()) {
        editorAl.value.getQuill().setContents(JSON.parse(textArea.teaser_al), 'silent')
        editorEn.value.getQuill().setContents(JSON.parse(textArea.teaser_en), 'silent')
    }
}, {immediate: true, deep: true})


</script>
<template>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Teaser English
        </label>
        <!-- @ready="loadEn($event)" -->
        <!-- :content="teaser_en ? JSON.parse(teaser_en) : {}" -->
        <QuillEditor
        v-if="number"
        ref="editorEn"
        :options="optionsEn"
        @update:content="changedContentEn($event)"
        @focus="optionsEn.placeholder = ''" />
        <!-- v-model:content="contentAl" -->
        <!-- loadEn -->
    </div>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Teaser Albania
        </label>
        <!-- @ready="loadAl($event)" -->
        <QuillEditor
        v-if="number"
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
