<script setup>
// heroicons
import {
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
import { onMounted, ref } from '@vue/runtime-core';
const prop = defineProps({
    languageChange: String,
    authorAl: String,
    authorEn: String,
    compChange: Number,
    smAndLarger: Boolean,
})

// properties
const author_al = ref(null)
const author_en = ref(null)

onMounted(() => {
    // heroicons
    XMarkIcon
    let inAl = JSON.parse(prop.authorAl)
    let inEn = JSON.parse(prop.authorEn)

    var converterAl = new QuillDeltaToHtmlConverter(inAl.ops)
    var converterEn = new QuillDeltaToHtmlConverter(inEn.ops)

    //props conversion
    author_al.value = converterAl.convert()
    author_en.value = converterEn.convert()

})

</script>

<template>
    <div class="relative mt-0 overflow-y-hidden grow" v-if="prop.authorAl && prop.authorEn">
        <div class="grid w-full grid-cols-6 lg:w-90">
            <p class="col-span-5 font-semibold text-title text-start text-virtual-blue">
                {{ prop.languageChange === 'AL' ? 'Rreth Artistit' : 'The Artist' }}
            </p>
            <button type="button" class="mx-auto" @click="$emit('update:compChange', $event.target.value = 0)">
                <XMarkIcon class="text-virtual-blue w-7 h-7"> </XMarkIcon>
            </button>

        </div>
        <div class="relative w-full overflow-y-auto lg:w-90 scroll-smooth" scroll-region
        :class="!smAndLarger ? 'heightContain' : 'heightContainMobile'">
            <div class="h-full mt-4 font-normal leading-relaxed text-body text-start text-virtual-blue"  v-html="prop.languageChange === 'AL' ? author_al : author_en"></div>
        </div>
    </div>
</template>
<style>
.heightContain {
    max-height: 18rem;
}
.heightContainMobile {
    max-height: 27rem;
}
</style>
