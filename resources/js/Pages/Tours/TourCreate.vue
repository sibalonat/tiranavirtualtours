<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
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
                    <form @submit.prevent="store" class="p-3 border">
                        <div class="flex">
                            <label for="title" class="flex">Title</label>
                            <input type="text" id="title" placeholder="write the title here" v-model="form.title">
                        </div>
                        <div class="grow">
                            <label for="description_al">Description in Albanina</label>
                            <textarea v-model="form.title" id="description_al" cols="30" rows="10"></textarea>
                        </div>
                        <button type="submit" class="px-6 py-2 ml-2 text-white bg-slate-900">save</button>
                    </form>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>

</template>
