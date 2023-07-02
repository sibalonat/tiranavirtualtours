<script setup>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { onBeforeMount, onMounted, reactive, ref, watchEffect, watch } from '@vue/runtime-core';

// const emit = defineEmits(['AlChange'])
// props and emits
const emit = defineEmits(['update:teaser_al', 'update:teaser_en']);
const textArea = defineProps({
    teaser_en: String,
    teaser_al: String,
    author_en: String,
    author_al: String
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
    emit('update:teaser_al', JSON.stringify(evt))
}

const changedContentEn = (evt) => {
    emit('update:teaser_en', JSON.stringify(evt))
}


</script>
<template>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Teaser English
        </label>
        <QuillEditor
        :content="JSON.parse(teaser_en)"
        ref="editorEn"
        :options="optionsEn"
        @update:content="changedContentEn($event)"
        @focus="optionsEn.placeholder = ''" />
        <!-- <textarea
        name="teaser"
        id="teaser"
        rows="7"
        class="self-center w-full -mt-1"
        :value="teaser_en"
        @input="$emit('update:teaser_en', $event.target.value)"> </textarea> -->
    </div>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Teaser Albania
        </label>
        <QuillEditor
        ref="editorAl"
        :content="JSON.parse(teaser_al)"
        :options="optionsAl"
        @update:content="changedContentAl($event)"
        @focus="optionsAl.placeholder = ''" />
        <!-- <textarea
        name="teaser"
        id="teaser"
        rows="7"
        class="self-center w-full -mt-1"
        :value="teaser_al"
        @input="$emit('update:teaser_al', $event.target.value)"> </textarea> -->
    </div>
</template>
<style>
.ql-container {
    height: 170px !important;
    max-height: 170px;
}
</style>
