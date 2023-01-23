<script setup>
import { onBeforeMount, onMounted, reactive, ref, watchEffect, watch } from '@vue/runtime-core';

// const emit = defineEmits(['AlChange'])
const textArea = defineProps({
    teaser_en: String,
    teaser_al: String,
    author_en: String,
    author_al: String
})

// const teaserAl = ref('')

// const inputForTeaserAl = () => {
//     emit
// }

onMounted(() => {

})


</script>
<template>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Teaser English
        </label>
        <textarea
        name="teaser"
        id="teaser"
        rows="7"
        class="self-center w-full -mt-1"
        :value="teaser_en"
        @input="$emit('update:teaser_en', $event.target.value)"> </textarea>
    </div>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Teaser Albania
        </label>
        <textarea
        name="teaser"
        id="teaser"
        rows="7"
        class="self-center w-full -mt-1"
        :value="teaser_al"
        @input="$emit('update:teaser_al', $event.target.value)"> </textarea>
    </div>
</template>
