<script setup>
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from "@headlessui/vue"

import { onMounted, ref } from "@vue/runtime-core";


const propit = defineProps({
    tour: Object,
})

// let response = ref(null)

onMounted(() => {
    TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle

    // console.log(usePage().props.value.modal);

    console.log(props);

    show, close, redirect

    window.onpopstate = (event) => {
        window.location.href = route('welcome');
    }
})


</script>
<template>

    <TransitionRoot appear as="template" :show="show" class="max-h-28 h-7">

        <Dialog as="div" class="relative z-10" @close="close">
            <TransitionChild @after-leave="redirect" as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 transition-opacity bg-black/75" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-full p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">
                        <DialogPanel
                            class="w-full max-w-4xl p-6 overflow-hidden overflow-y-auto text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl h-5/6">
                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                <slot name="title" />
                            </DialogTitle>
                            <slot />
                            <!-- :station="propit.station" -->
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

</template>

<style scoped>
.modal-mask {
    position: fixed;
    inset: 0;
    /* background: rgba(0, 0, 0, .3); */
    display: grid;
    place-items: center;
}

.modal-container {
    background: white;
    padding: 1rem;
    width: 90vw;
    max-width: 600px;
    border-radius: 7px;
}

.modal-footer {
    border-top: 1px solid #ddd;
    margin-top: 1rem;
    padding-top: .5rem;
    font-size: .8rem;
}

.modal-footer button {
    background: #ddd;
    padding: .25rem .75rem;
    border-radius: 25px;
}

.modal-footer button:hover {
    background: #c8c8c8;
    padding: .25rem .75rem;
    border-radius: 25px;
}

</style>
