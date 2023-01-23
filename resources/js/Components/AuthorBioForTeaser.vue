<script setup>
const textArea = defineProps({
    author_en: String,
    author_al: String,
    teaser_en: String,
    teaser_al: String,
})
</script>
<template>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Author-Bio En
        </label>
        <textarea
        name="teaser"
        id="teaser"
        rows="7"
        class="self-center w-full -mt-1"
        :value="author_en"
        @input="$emit('update:author_en', $event.target.value)"> </textarea>
    </div>
    <div>
        <label for="teaser" class="self-center px-8 py-1 text-white bg-black rounded-lg ">
            Author-Bio Al
        </label>
        <textarea
        name="teaser"
        id="teaser"
        rows="7"
        class="self-center w-full -mt-1"
        :value="author_al"
        @input="$emit('update:author_al', $event.target.value)"> </textarea>
    </div>
</template>
