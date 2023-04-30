<script setup>
// heroicons
import {
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
import { onMounted, ref } from '@vue/runtime-core';

const prop = defineProps({
    languageChange: String,
    teaserAl: String,
    teaserEn: String,
    compChange: Number,
    smAndLarger: Boolean,
})

// properties
const teaser_al = ref(null)
const teaser_en = ref(null)

// hooks
onMounted(() => {
    // heroicons
    XMarkIcon
    //props

    let inAl = JSON.parse(prop.teaserAl)
    let inEn = JSON.parse(prop.teaserEn)

    var converterAl = new QuillDeltaToHtmlConverter(inAl.ops)
    var converterEn = new QuillDeltaToHtmlConverter(inEn.ops)

    //props conversion
    teaser_al.value = converterAl.convert()
    teaser_en.value = converterEn.convert()

    console.log(teaser_al.value);
})
</script>

<template>
    <div class="relative mt-0 overflow-y-hidden grow">
        <div class="grid w-full grid-cols-6 lg:w-90">
            <p class="col-span-5 font-semibold text-title text-start text-virtual-blue">
                {{ prop.languageChange === 'AL' ? 'Rreth Stacionit' : 'The Station' }}
            </p>
            <button type="button" class="mx-auto" @click="$emit('update:compChange', $event.target.value = 0)">
                <XMarkIcon class="text-virtual-blue w-7 h-7"> </XMarkIcon>
            </button>
        </div>
        <div class="relative w-full overflow-y-auto lg:w-90 scroll-smooth" scroll-region
        :class="!smAndLarger ? 'heightContain' : 'heightContainMobile'">
            <div class="h-full mt-4 leading-relaxed text-start text-virtual-blue" v-html="prop.languageChange === 'AL' ? teaser_al : teaser_en"></div>
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
