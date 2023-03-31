<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted } from '@vue/runtime-core';

const form = useForm({
    title: '',
    description_al: '',
    description_en: '',
});

const store = () => {
    form.post(route('tour.store', form));
}

onMounted(() => {
    BreezeAuthenticatedLayout, Head

    store
})

</script>
<template>

    <Head title="Create Tour" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tour Create
            </h2>
        </template>

        <div class="py-12">
            <div class="relative mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center py-40 overflow-hidden bg-white shadow-sm sm:rounded-lg space-x-11">
                    <form @submit.prevent="store" class="flex flex-col w-2/3 p-3 space-y-4 border">
                        <div class="grow">
                            <label for="title" class="flex self-center w-4/12 px-8 py-1 -mb-2 text-white bg-black rounded-lg">Title</label>
                            <input type="text" class="w-4/12" id="title" placeholder="write the title here" v-model="form.title">
                        </div>
                        <div class="grow">
                            <div class="grid grid-cols-2 gap-x-8">
                                <div>
                                    <label for="description_al" class="flex self-center px-8 py-1 -mb-2 text-white bg-black rounded-lg">Description in Albanian <button></button></label>
                                    <textarea v-model="form.description_al" id="description_al" cols="42" rows="10"></textarea>
                                </div>
                                <div>
                                    <label for="description_al" class="flex self-center px-8 py-1 -mb-2 text-white bg-black rounded-lg" >Description in English <button></button></label>
                                    <textarea v-model="form.description_en" id="description_al" cols="42" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="px-6 py-2 ml-2 text-white bg-slate-900">save</button>
                    </form>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>

</template>
